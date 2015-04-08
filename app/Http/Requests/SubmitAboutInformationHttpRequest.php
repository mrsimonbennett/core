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
            'about' => 'about_description',
            'dob'   => 'date_of_birth',
            'phone' => 'phone_number'
        ];
    }

}
