<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreService extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->hasAccess();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quand' => 'required|unique:services|date_format:"Y-m-d H:i:s"|before:now',
        ];
    }

    public function messages()
    {
        return [
            'quand.required' => 'La date est obligatoire',
            'quand.unique'  => 'Ce service existe déjà!',
        ];
    }
}
