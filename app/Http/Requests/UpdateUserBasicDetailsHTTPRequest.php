<?php
namespace FullRent\Core\Application\Http\Requests;

/**
 * Class UpdateUserBasicDetailsHTTPRequest
 * @package FullRent\Core\Application\Http\Requests
 * @author Simon Bennett <simon@bennett.im>
 */
final class UpdateUserBasicDetailsHTTPRequest extends Request
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
            'legal_name' => 'required',
            'known_as' => 'required',
        ];
    }
}