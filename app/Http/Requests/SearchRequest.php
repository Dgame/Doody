<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;

class SearchRequest extends FormRequest
{
    public function rules()
    {
        return [
            'search' => 'required',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
