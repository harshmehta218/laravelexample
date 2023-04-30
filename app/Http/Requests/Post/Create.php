<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required|min:20|max:255',
            'files.*' => 'nullable|mimes:png,jpg,gif,m4v,avi,flv,mp4,mov'
        ];
    }
}
