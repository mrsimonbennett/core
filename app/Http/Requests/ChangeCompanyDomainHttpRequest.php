<?php namespace FullRent\Core\Application\Http\Requests;


class ChangeCompanyDomainHttpRequest extends Request {

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
            'company_domain' => 'required|min:2|max:62|alpha_dash|unique:companies,domain',
        ];
	}

}
