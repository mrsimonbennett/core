<?php namespace FullRent\Core\Application\Http\Requests;


class TenantDirectDebitAccessTokenHttpRequest extends Request
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
            'tenant_id'     => 'required|uuid',
            'resource_id'   => 'required',
            'resource_type' => 'required',
            'resource_uri'  => 'required',
            'signature'     => 'required',
        ];
    }

}
