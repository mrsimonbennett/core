<?php namespace FullRent\Core\Application\Http\Requests;


class ListNewPropertyHttpRequest extends Request {

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
			"bedrooms"    => "required|numeric",
			"bathrooms"   => "required|numeric",
			"parking"     => "required|numeric",
			"pets"        => "required|boolean",


			"address"     => "required",
			"city"        => "required",
			"county"      => "required",
			"country"     => "required",
			"postcode"    => "required",
			"company_id"  => 'required|uuid',//|exists:Company,uuid',
			"landlord_id" => "required|uuid", //|exists:User,uuid",
		];
	}

}