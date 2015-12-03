<?php namespace FullRent\Core\Application\Http\Requests\Properties\Documents;


/**
 * Class UpdatePropertyDocumentHttpRequest
 * @package FullRent\Core\Application\Http\Requests\Properties\Documents
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class UpdatePropertyDocumentHttpRequest extends \FullRent\Core\Application\Http\Requests\Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required',
            'expiry-date' => 'required|date',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}