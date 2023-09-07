<?php

namespace Qcloud\Cos\Exception;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Qiniu\Http\Response;

class ServiceResponseException extends \RuntimeException {

    /**
     * @var Response|ResponseInterface Response
     */
    protected Response|ResponseInterface $response;

    /**
     * @var RequestInterface Request
     */
    protected RequestInterface $request;

    /**
     * @var string Request ID
     */
    protected string $requestId;

    /**
     * @var string Exception type (client / server)
     */
    protected string $exceptionType;

    /**
     * @var string Exception code
     */
    protected string $exceptionCode;

    /**
     * Set the exception code
     *
     * @param string $code Exception code
     */
    public function setExceptionCode(string $code): void
    {
        $this->exceptionCode = $code;
    }

    /**
     * Get the exception code
     *
     * @return string|null
     */
    public function getExceptionCode(): ?string
    {
        return $this->exceptionCode;
    }

    /**
     * Set the exception type
     *
     * @param string $type Exception type
     */
    public function setExceptionType(string $type): void
    {
        $this->exceptionType = $type;
    }

    /**
     * Get the exception type (one of clients or server)
     *
     * @return string|null
     */
    public function getExceptionType(): ?string
    {
        return $this->exceptionType;
    }

    /**
     * Set the request ID
     *
     * @param string $id Request ID
     */
    public function setRequestId(string $id): void
    {
        $this->requestId = $id;
    }

    /**
     * Get the Request ID
     *
     * @return string|null
     */
    public function getRequestId(): ?string
    {
        return $this->requestId;
    }

    /**
     * Set the associated response
     *
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response): void
    {
        $this->response = $response;
    }

    /**
     * Get the associated response object
     *
     * @return Response|ResponseInterface|null
     */
    public function getResponse(): Response|ResponseInterface|null
    {
        return $this->response;
    }

    /**
     * Set the associated request
     *
     * @param RequestInterface $request
     */
    public function setRequest(RequestInterface $request): void
    {
        $this->request = $request;
    }

    /**
     * Get the associated request object
     *
     * @return RequestInterface|null
     */
    public function getRequest(): ?RequestInterface
    {
        return $this->request;
    }

    /**
     * Get the status code of the response
     *
     * @return int|null
     */
    public function getStatusCode(): ?int
    {
        return $this->response?->getStatusCode();
    }

    /**
     * Cast to a string
     *
     * @return string
     */
    public function __toString() {
        $message = get_class($this) . ': '
            . 'Cos Error Code: ' . $this->getExceptionCode() . ', '
            . 'Status Code: ' . $this->getStatusCode() . ', '
            . 'Cos Request ID: ' . $this->getRequestId() . ', '
            . 'Cos Error Type: ' . $this->getExceptionType() . ', '
            . 'Cos Error Message: ' . $this->getMessage();

        // Add the User-Agent if available
        $message .= ', ' . 'User-Agent: ' . $this->request->getHeader('User-Agent')[0];

        return $message;
    }

    /**
     * Get the request ID of the error. This value is only present if a
     * response was received, and is not present in the event of a networking
     * error.
     *
     * Same as `getRequestId()` method, but matches the interface for SDKv3.
     *
     * @return string|null Returns null if no response was received
     */
    public function getCosRequestId(): ?string
    {
        return $this->requestId;
    }

    /**
     * Get the Cos error type.
     *
     * Same as `getExceptionType()` method, but matches the interface for SDKv3.
     *
     * @return string|null Returns null if no response was received
     */
    public function getCosErrorType(): ?string
    {
        return $this->exceptionType;
    }

    /**
     * Get the Cos error code.
     *
     * Same as `getExceptionCode()` method, but matches the interface for SDKv3.
     *
     * @return string|null Returns null if no response was received
     */
    public function getCosErrorCode(): ?string
    {
        return $this->exceptionCode;
    }
}
