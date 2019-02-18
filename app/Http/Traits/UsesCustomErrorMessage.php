<?php

namespace App\Http\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Response\APIResponse;
use App\Http\ResponseTransformers\ValidationResponseTransformer;
use Illuminate\Http\Request;

trait UsesCustomErrorMessage
{

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $apiResponse = new APIResponse();
        $message = (method_exists($this, 'message')) ? $this->container->call([$this, 'message']) : 'The given data was invalid.';

        throw new HttpResponseException($apiResponse->respondValidationError($this->response($validator->errors()->getMessages()), ""));
    }

    public function response($errors)
    {
        $validationResponseTransformer = new ValidationResponseTransformer();
        return $validationResponseTransformer->response($errors);
    }
    
    public function getResponseMessage($type)
    {
        $lang = Request::segment(2);
        return (config("site_messages.{$lang}.{$type}")?:config("site_messages.en.{$type}"))?:config("site_messages.en.general.ok");
    }
}
