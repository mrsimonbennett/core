<?php namespace FullRent\Core\Application\Http\Requests;

/**
 * @property mixed about_description
 * @property mixed date_of_birth
 * @property mixed phone_number
 */
class SubmitAboutInformationHttpRequest extends Request
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
            'about_description' => 'required',
            'date_of_birth'     => 'required|date_format:d/m/Y',
            'phone_number'      => 'required'
        ];
    }

}
