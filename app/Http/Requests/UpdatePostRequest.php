<?php

namespace App\Http\Requests;


class UpdatePostRequest extends AbstractRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['string', 'min:1', 'max:255', 'unique:posts'],
            'avatar' => ['nullable', 'image'],
            'body' => ['nullable', 'string'],
            'author_id' => ['numeric', 'min:1'],
        ];
    }
}
