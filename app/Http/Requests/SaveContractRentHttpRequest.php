<?php
namespace FullRent\Core\Application\Http\Requests;


/**
 * Class SaveContractRentHttpRequest
 * @package FullRent\Core\Application\Http\Requests
 * @author Simon Bennett <simon@bennett.im>
 */
final class SaveContractRentHttpRequest extends Request
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
            'rent' => 'required',
            'rent_payable'   => 'required',
            'first_rent'   => 'required',
            'deposit'   => 'required',
            'deposit_due'   => 'required',
            'fullrent_deposit'   => 'required|boolean',

        ];
    }
}