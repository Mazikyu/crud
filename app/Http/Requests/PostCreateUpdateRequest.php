<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PostCreateUpdateRequest extends FormRequest
{

    public function rules(): array
    {
        $post = $this->route('post');

        return [
            'name' => [

                Rule::unique('posts', 'name')->ignore($post?->id),
                'required',
                'min:3',
                'max:15'
            ],
            'description' => ['required', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'status' => ['required', 'boolean'],
        ];
    }
}
