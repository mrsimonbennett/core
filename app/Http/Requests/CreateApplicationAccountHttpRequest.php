<?php namespace FullRent\Core\Application\Http\Requests;


class CreateApplicationAccountHttpRequest extends Request {

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
			//'user_email' => 'required|email|unique:users,email',
			'user_legal_name' => 'required',
			'user_know_as' => 'required',
			'user_password' => 'required|min:8',
			'property_id' => 'required|uuid|exists:properties,id'
		];
	}

}
