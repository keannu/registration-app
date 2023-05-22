<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

/**
 * Class UserLoginRequest
 * 
 * @author Keannu Rim Kristoffer C. Regala <keannu>
 * @since 2023.05.18
 */
class UserLoginRequest extends FormRequest
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
     * @return array
     */
    public function rules() : array
    {
        return [
            'username' => [ 'required', 'string', 'min:3', 'max:150' ],
            'password' => [ 'required', 'max:16', Password::min(8) ]
        ];
    }
}
