<?php namespace FullRent\Core\Application\Http\Requests;


class DraftContractHttpRequest extends Request
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
            "landlord_id" => 'required|uuid|exists:Company',
            'property_id' => 'required|uuid|exists:Property',
            'rent' => 'required|integer',
            'deposit' => 'required|integer',
            'start_date' => 'required|date_format:d/m/Y|before_date:end_date',
            'end_date' => 'required|date_format:d/m/Y',
            'deposit_due' => 'required|date_format:d/m/Y',
            "rolls" => 'required|boolean',
            'first_payment_date' => 'required|date_format:d/m/Y|before_date:end_date',
            'rent_due_day' => 'required|min:1|max:28',
        ];
    }

}
