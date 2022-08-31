<?php

namespace Filimo\UrlShortener\Exception;

use Exception;

class HttpException extends Exception
{
    private string $errorMessage;

    public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        $this->errorMessage = $message;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}