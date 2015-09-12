<?php
namespace FullRent\Core\Application\Http\Requests;

/**
 * Class CreateNewContractHttpRequest
 * @package FullRent\Core\Application\Http\Requests
 * @author Simon Bennett <simon@bennett.im>
 */
final class CreateNewContractHttpRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'property_id'              => 'required',
            'company_id'               => 'required',
            'landlord_id'              => 'required',
            'tenant_id'                => 'required',
            'start'                    => 'required',
            'end'                      => 'required',
            'rent'                     => 'required',
            'rent_payable'             => 'required',
            'first_payment_due'        => 'required',
            'fullrent_rent_collection' => 'required',
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