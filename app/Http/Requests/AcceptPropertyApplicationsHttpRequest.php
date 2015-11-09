<?php namespace FullRent\Core\Application\Http\Requests;


class AcceptPropertyApplicationsHttpRequest extends Request {

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
			'property_id' => 'required|exists:properties,id',
		];
	}

}
