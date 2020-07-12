<?php


namespace App\Http\Frontend\Dashboard\Request;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Frontend\Dashboard\Request\ButtonRequest;
use App\Domain\Button\Validation\ButtonRule;

class AddButtonRequest extends ButtonRequest
{
//    public function authorize()
//    {
//        return true;
//    }
//
    public function rules()
    {
        $rules = parent::rules();
        $rules['title'][] = new ButtonRule;

//        $rules = array(
//            'title' => 'required|max:255',
//            'link' => 'required|active_url',
//            'color_id' => 'required',
//        );

        return $rules;
    }
}
