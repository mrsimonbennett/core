<?php
namespace FullRent\Core\Application\Http\Requests\Tenancies\RentBook;

use FullRent\Core\Application\Http\Requests\Request;

/**
 * Class ChangeRentBookPaymentInfoRequest
 * @package FullRent\Core\Application\Http\Requests\Tenancies\RentBook
 * @author Simon Bennett <simon@bennett.im>
 */
final class ChangeRentBookPaymentInfoRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rent_amount' => 'required',
            'rent_due'    => 'required|date_format:d/m/Y'
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