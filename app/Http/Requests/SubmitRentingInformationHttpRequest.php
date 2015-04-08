<?php namespace FullRent\Core\Application\Http\Requests;


/**
 * @property mixed currently_renting
 */
class SubmitRentingInformationHttpRequest extends Request {

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
			'currently_renting' => 'required'
		];
	}

}
