<?php


namespace App\Http\Frontend\Dashboard\Request;

use Illuminate\Foundation\Http\FormRequest;

class ButtonRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = array(
            'title' => [
                'required',
                'max:255',
            ],
            'link' => [
                'required',
                'max:255',
                'active_url'
            ],
            'color_id' => 'required',
        );

        return $rules;
    }
}
