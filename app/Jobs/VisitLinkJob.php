<?php

namespace App\Jobs;

use App\Models\Link;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VisitLinkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private int    $linkId,
        private string $userAgent,
        private Carbon $visitedAt
    ) {
    }

    public function handle()
    {
        Link::where('id', $this->linkId)->increment('visits');

        Visit::create([
            'link_id' => $this->linkId,
            'user_agent' => $this->userAgent,
            'visited_at' => $this->visitedAt,
        ]);
    }
}
