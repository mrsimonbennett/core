<?php
namespace FullRent\Core\Application\Http\Requests;

/**
 * Class UpdateUserPasswordHttpRequest
 * @package FullRent\Core\Application\Http\Requests
 * @author Simon Bennett <simon@bennett.im>
 */
final class UpdateUserPasswordHttpRequest extends Request
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
    public function rules()
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',

        ];
    }
}