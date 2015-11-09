<?php namespace FullRent\Core\Application\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Validator;

abstract class Request extends FormRequest {

  public function wantsJson()
  {
      return true;
  }
}
