<?php
namespace FullRent\Core\Application\Http\Requests;

/**
 * Class SaveContractDatesHttpRequest
 * @property mixed start
 * @property mixed end
 * @package FullRent\Core\Application\Http\Requests
 * @author Simon Bennett <simon@bennett.im>
 */
final class SaveContractDatesHttpRequest extends Request
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
            'start'            => 'required',
            'end'              => 'required',
            'rent'             => 'required',
            'rent_payable'     => 'required',
            'first_rent'       => 'required',
        ];

    }
}