<?php
namespace FullRent\Core\Application\Http\Requests;

/**
 * Class ResetPasswordHttpRequest
 * @package FullRent\Core\Application\Http\Requests
 * @author Simon Bennett <simon@bennett.im>
 */
final class ResetPasswordHttpRequest extends Request
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