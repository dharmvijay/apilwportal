<?php /** @noinspection ALL */

namespace App\Http\Response;

use BadMethodCallException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response as ResponseHTTP;
use Request;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class APIResponse
{
    /**
     * Default is (200).
     *
     * @var int
     */
    protected $statusCode = ResponseHTTP::HTTP_OK;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     * @return mixed
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * Responds with JSON, status code and headers.
     *
     * @param array $data
     * @return JsonResponse
     */
    public function respond(array $data)
    {

        return new JsonResponse($data, $this->getStatusCode(), $this->getHeaders());
    }

    /**
     *  create API structure.
     *
     * @param type $success
     * @param type $payload
     * @param type $message
     * @param type $debug
     * @return type
     */
    public function getResponseStructure($success = false, $payload = null, $message = '', $debug = null)
    {
        if (isset($debug)) {
            $data = [
                'success' => $success,
                'message' => $message,
                'payload' => $payload,
                'debug' => $debug
            ];
        } else {
            $data = [
                'success' => $success,
                'message' => $message,
                'payload' => $payload
            ];
        }
        return $data;
    }

    /**
     *
     * @param array $data
     * @return JsonResponse
     */
    public function respondWithData(array $data)
    {

        $responseData = $this->getResponseStructure(true, $data, '');


        return new JsonResponse($responseData, $this->getStatusCode(), $this->getHeaders());
    }

    /**
     * Use this for responding with messages.
     *
     * @param $message
     * @return JsonResponse
     */
    public function respondWithMessage($message = "Ok")
    {
        $data = $this->getResponseStructure(true, null, $message);

        return $this->respond($data);
    }

    /**
     * @param null $payload
     * @param string $message
     * @return JsonResponse
     */
    public function respondWithMessageAndPayload($payload = null, $message = "Ok")
    {
        $data = $this->getResponseStructure(true, $payload, $message);

        return $this->respond($data);
    }

    /**
     * @param string $message
     * @param null $e
     * @param null $data
     * @return JsonResponse|null
     */
    public function respondWithError($message = "Error", $e = null, $data = null)
    {
        $response = null;
        if (\App::environment('local', 'staging') && isset($e)) {
            $debug_message = $e;
            $data = $this->getResponseStructure(false, $data, $message, $debug_message);
        } else {
            $data = $this->getResponseStructure(false, $data, $message);
        }

        $response = $this->respond($data);

        return $response;
    }

    /**
     * Use this to respond with a message (200).
     *
     * @param $message
     * @return JsonResponse
     */
    public function respondOk($message = "Ok")
    {
        return $this->setStatusCode(ResponseHTTP::HTTP_OK)
            ->respondWithMessage($message);
    }

    /**
     * Use this when a resource has been created (201).
     *
     * @param $message
     * @return mixed
     */
    public function respondCreated($message = "Created")
    {
        Cache::flush();
        return $this->setStatusCode(ResponseHTTP::HTTP_CREATED)
            ->respondWithMessage($message);
    }

    /**
     * @param null $payload
     * @param string $message
     * @return mixed
     */
    public function respondCreatedWithPayload($payload = null, $message = "Created")
    {
        Cache::flush();
        return $this->setStatusCode(ResponseHTTP::HTTP_CREATED)
            ->respondWithMessageAndPayload($payload, $message);
    }

    /**
     * Use this when a resource has been updated (202).
     *
     * @param $message
     * @return mixed
     */
    public function respondUpdated($message = "Updated")
    {
        Cache::flush();
        return $this->setStatusCode(ResponseHTTP::HTTP_ACCEPTED)
            ->respondWithMessage($message);
    }

    /**
     * @param null $payload
     * @param string $message
     * @return mixed
     */
    public function respondUpdatedWithPayload($payload = null, $message = "Updated")
    {
        Cache::flush();
        return $this->setStatusCode(ResponseHTTP::HTTP_ACCEPTED)
            ->respondWithMessageAndPayload($payload, $message);
    }

    /**
     * Use this when a resource has been deleted (202).
     *
     * @param $messageKey
     * @return mixed
     */
    public function respondDeleted($message = "Deleted")
    {
        Cache::flush();
        return $this->setStatusCode(ResponseHTTP::HTTP_ACCEPTED)
            ->respondWithMessage($message);
    }

    /**
     * Use this when a resource has been deleted (202).
     *
     * @param $messageKey
     * @return mixed
     */
    public function respondDeletedWithPayload($payload = null, $message = "Deleted")
    {
        Cache::flush();
        return $this->setStatusCode(ResponseHTTP::HTTP_ACCEPTED)
            ->respondWithMessageAndPayload($payload, $message);
    }

    /**
     * Use this when the user needs to be authorized to do something (401).
     *
     * @param $message
     * @return mixed
     */
    public function respondUnauthorized($message = "Unauthorized")
    {
        return $this->setStatusCode(ResponseHTTP::HTTP_UNAUTHORIZED)
            ->respondWithError($message);
    }

    /**
     * Use this when the user does not have permission to do something (403).
     *
     * @param string $message
     * @return mixed
     */
    public function respondForbidden($message = "Forbidden")
    {
        return $this->setStatusCode(ResponseHTTP::HTTP_FORBIDDEN)
            ->respondWithError($message);
    }

    /**
     * Use this when a resource is not found (404).
     *
     * @param string $message
     * @return mixed
     */
    public function respondNotFound($message = "Not Found")
    {
        return $this->setStatusCode(ResponseHTTP::HTTP_NOT_FOUND)
            ->respondWithError($message);
    }

    /**
     * @param string $message
     * @param null $data
     * @return mixed
     */
    public function respondValidationError($message = "Validation Error", $data = null)
    {
        return $this->setStatusCode(ResponseHTTP::HTTP_UNPROCESSABLE_ENTITY)
            ->respondWithError($message, null, $data);
    }

    /**
     * Use this for general server errors (500).
     *
     * @param string $message
     * @return mixed
     */
    public function respondInternalError($message, $e)
    {
        $message = $message?:"Internal Error";
        return $this->setStatusCode(ResponseHTTP::HTTP_INTERNAL_SERVER_ERROR)
            ->respondWithError($message, $e);
    }

    /**
     * Use this for general server errors (500).
     *
     * @param string $message
     * @return mixed
     */
    public function respondCustomError($message, $status_code, $e)
    {
        $message = $message?:"Internal Error";
        return $this->setStatusCode($status_code)
            ->respondWithError($message, $e);
    }

    /**
     * Use this for HTTP not implemented errors (501).
     *
     * @param string $message
     * @return mixed
     */
    public function respondNotImplemented($message = "Internal Error")
    {
        return $this->setStatusCode(ResponseHTTP::HTTP_NOT_IMPLEMENTED)
            ->respondWithError($message);
    }

    /**
     * Use this for conflict of resource which already exists with unique key.
     *
     * @param string $message
     * @return mixed
     */
    public function respondResourceConflict($message = "Resource Already Exists")
    {
        return $this->setStatusCode(ResponseHTTP::HTTP_CONFLICT)
            ->respondWithError($message);
    }

    public function respondResourceConflictWithData($payload = null, $message = "Resource Already Exists", $responseCode = ResponseHTTP::HTTP_CONFLICT)
    {
        return $this->setStatusCode($responseCode)
            ->respondWithMessageAndPayload($payload, $message);
    }

    /**
     * @param \Illuminate\Contracts\Filesystem\Filesystem $file
     * @param $mime
     * @return mixed
     */
    public function respondWithFile($file, $mime)
    {

        return (new \Illuminate\Http\Response($file, ResponseHTTP::HTTP_OK))
            ->header('Content-Type', $mime);
    }

    public function respondNoContent($message)
    {
        return $this->setStatusCode(ResponseHTTP::HTTP_NO_CONTENT)
            ->respondWithMessage($message);
    }

    /**
     * Use this for conflict of resource which already exists with unique key.
     *
     * @param string $message
     * @return mixed
     */
    public function respondBadRequest($message = "Bad Request")
    {
        return $this->setStatusCode(ResponseHTTP::HTTP_BAD_REQUEST)
            ->respondWithError($message);
    }

    /**
     * Use this for conflict of resource which already exists with unique key.
     *
     * @param string $message
     * @return mixed
     */
    public function respondHTTPNotAcceptable($message = "HTTP Not Acceptable")
    {
        return $this->setStatusCode(ResponseHTTP::HTTP_NOT_ACCEPTABLE)
            ->respondWithError($message);
    }

    public function handleAndResponseException(\Exception $ex)
    {

        $response = '';
        switch (true) {
            case $ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException:
                $response = $this->respondNotFound('Record not found');
                break;
            case $ex instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException:
                $response = $this->respondNotFound("Not found");
                break;
            case $ex instanceof \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException:
                $response = $this->respondForbidden("Access denied");
                break;
            case $ex instanceof \Symfony\Component\HttpKernel\Exception\BadRequestHttpException:
                $response = $this->respondBadRequest("Bad request");
                break;
            case $ex instanceof BadMethodCallException:
                $response = $this->respondBadRequest("Bad method Call");
                break;
            case $ex instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException:
                $response = $this->respondForbidden("Method not found");
                break;
            case $ex instanceof \Illuminate\Database\QueryException:
                $response = $this->respondValidationError("Some thing went wrong with your query", [$ex->getMessage()]);
                break;
            case $ex instanceof \Illuminate\Http\Exceptions\HttpResponseException:
                $response = $this->respondInternalError("Something went wrong with our system", [$ex->getMessage()]);
                break;
            case $ex instanceof \Illuminate\Auth\AuthenticationException:
                $response = $this->respondUnauthorized("Unauthorized request");
                break;
            case $ex instanceof \Illuminate\Validation\ValidationException:
                $response = $this->respondValidationError("In valid request", [$ex->getMessage()]);
                break;
            case $ex instanceof \Exception:
                $response = $this->respondInternalError("Something went wrong with our system", [$ex->getMessage()]);
                break;
        }
        return $response;
    }
}
