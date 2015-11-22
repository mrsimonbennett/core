<?php
namespace FullRent\Core\Application\Http\Requests\Tenancies;

use FullRent\Core\Application\Http\Requests\Request;

/**
 * Class DraftTenancyHttpRequest
 * @package FullRent\Core\Application\Http\Requests\Tenancies
 * @author Simon Bennett <simon@bennett.im>
 */
final class DraftTenancyHttpRequest extends Request
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
     * @todo Fix Validation
     * @return array
     */
    public function rules()
    {
        return [
            'tenancy_property_id' => 'required',
            'tenancy_start'       => 'required',
            'tenancy_end'         => 'required',
            'tenancy_rent_amount'         => 'required',
            'tenancy_rent_frequency'      => 'required',
        ];

    }

}