<?php namespace FullRent\Core\Application\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public abstract function rules();

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public abstract function authorize();

}
