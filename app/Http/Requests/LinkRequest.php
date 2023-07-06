<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LinkRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'slug' => [
                'nullable',
                'min:2',
                Rule::unique('links')->where(function ($query) {
                    return $query->where('slug', request()->input('slug'))
                        ->where('domain', url($this->link?->domain ?? '/'));
                })->ignore($this->link?->id),
            ],
            'app_url' => 'nullable|regex:/^([a-zA-Z0-9+.-]+):\/\/([^\s\/?#]+)(\/[^\s?#]*)?(\?[^#\s]*)?(#.*)?$/',
            'android_url' => 'nullable|url',
            'ios_url' => 'nullable|url',
            'huawei_url' => 'nullable|url',
            'fallback_url' => 'required|url',
        ];
    }
}
