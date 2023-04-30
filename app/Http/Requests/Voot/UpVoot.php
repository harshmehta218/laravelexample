<?php

namespace App\Http\Requests\Voot;

use Illuminate\Foundation\Http\FormRequest;

class UpVoot extends FormRequest
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
            'post_id' => 'required',
            'up_voot' => 'required'
        ];
    }
}
