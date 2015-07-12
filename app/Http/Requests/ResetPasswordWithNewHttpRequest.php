<?php
namespace FullRent\Core\Application\Http\Requests;

/**
 * Class ResetPasswordWithNewHttpRequest
 * @package FullRent\Core\Application\Http\Requests
 * @author Simon Bennett <simon@bennett.im>
 */
final class ResetPasswordWithNewHttpRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ];
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