<?php

namespace App\Models;

use App\Jobs\VisitLinkJob;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Url\Url;

class Link extends Model
{
    use HasFactory;

    protected $appends = ['url'];

    protected $fillable = [
        'slug',
        'app_url',
        'android_url',
        'huawei_url',
        'ios_url',
        'fallback_url',
        'html',
    ];

    public function visit(?string $userAgent = null): void
    {
        VisitLinkJob::dispatch($this->id, $userAgent ?? request()->userAgent(), now());
    }

    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn () => (string) Url::fromString($this->domain)
                ->withPath($this->slug),
        );
    }

    public function scopeUseRequestDomain($query)
    {
        return $query->where(fn($q) => $q->orWhere('domain', request()->getSchemeAndHttpHost())->orWhereNull('domain'));
    }

    protected static function boot(): void
    {
        parent::boot();

        self::creating(function ($link) {
            if (! $link->slug) {
                $link->slug = uniqid_real(6);
            }

            if (! $link->domain) {
                $link->domain = url('/');
            }
        });
    }
}
