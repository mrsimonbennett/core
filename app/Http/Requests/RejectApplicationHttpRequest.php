<?php namespace FullRent\Core\Application\Http\Requests;

use FullRent\Core\Application\Http\Requests\Request;

/**
 * @property mixed reason
 */
class RejectApplicationHttpRequest extends Request {

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
			'reason' => 'required'
		];
	}

}
