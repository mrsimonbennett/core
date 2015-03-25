<?php
namespace FullRent\Core\Application\Http\Requests;

/**
 * Class ApiRequest
 * @package FullRent\Core\Application\Http\Requests
 * @author Simon Bennett <simon@bennett.im>
 */
class ApiRequest
{
    public function response(array $errors)
    {
        return new JsonResponse(['message' => 'Bad Request', 'validation' => $errors], 400);
    }

    /**
     * Format the errors from the given Validator instance.
     *
     * @param  Validator $validator
     * @return array
     */
    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->toArray();

    }

    /**
     * @param Factory $service
     * @return \Illuminate\Validation\Validator
     */
    public function validator(Factory $service)
    {
        $this->addJsonvalidation($service);
        $this->addUUIDValidation($service);

        $this->addDateOrderCheck($service);

        return $service->make($this->request->all(), $this->rules());
    }

    /**
     * @param Factory $service
     */
    private function addUUIDValidation(Factory $service)
    {
        $service->extend(
            'uuid',
            function ($key, $value) {
                try {
                    new UUID($value);
                    return true;
                } catch (\InvalidArgumentException $ex) {
                    return false;
                }
            },
            "The :attribute field must be valid UUID."
        );
    }

    /**
     * @param Factory $service
     */
    private function addJsonvalidation(Factory $service)
    {
        $service->extend(
            'json',
            function ($key, $value) {
                json_decode($value);
                return (json_last_error() == JSON_ERROR_NONE);
            },
            "The :attribute field must be valid json."
        );
    }

    /**
     * @param Factory $service
     */
    private function addDateOrderCheck(Factory $service)
    {
        $service->extend(
            'before_date',
            function ($attributes, $value, $parameters, $validator) {

                return Carbon::createFromFormat('d/m/Y', $value) < Carbon::createFromFormat('d/m/Y',($validator->getData()[$parameters[0]]));
            }
            ,
            ":attribute must be before end date"
        );
    }
}