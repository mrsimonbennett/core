<?php
namespace FullRent\Core\Application\Http\Requests\Auth;

use FullRent\Core\Application\Http\Requests\Request;

/**
 * Class AuthLoginHttpRequest
 * @package FullRent\Core\Application\Http\Requests\Auth
 * @author Simon Bennett <simon@bennett.im>
 */
final class AuthLoginHttpRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return ['email' => 'required', 'password' => 'required'];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}