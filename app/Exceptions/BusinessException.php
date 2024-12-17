<?php

namespace App\Exceptions;

use RuntimeException;

class BusinessException extends RuntimeException
{
    protected string $userMessage = 'Не удалось выполнить запрос';

    /** @var int */
    protected $code = 400;

    public function __construct(string $userMessage = '', string $errorMessage = '', int $code = 0)
    {
        $this->userMessage = $userMessage ?: $this->userMessage;

        if (! $errorMessage) {
            $className = explode('\\', $this::class);
            $className = end($className);
            $errorMessage = "$className($this->userMessage)";
        }

        parent::__construct($errorMessage, $code ?: $this->code);
    }

    public function getUserMessage(): string
    {
        return $this->userMessage;
    }
}
