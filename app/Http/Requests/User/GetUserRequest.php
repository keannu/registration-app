<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class GetUserRequest
 * 
 * @author Keannu Rim Kristoffer C. Regala <keannu>
 * @since 2023.05.18
 * @version 1.0
 */
class GetUserRequest extends FormRequest
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
            'username' => [ 'sometimes' ],
            'email'    => [ 'sometimes' ],
            'is_admin' => [ 'sometimes' ]
        ];
    }
}
