<?php

namespace App\Exceptions\Test;

use App\Exceptions\BusinessException;

class TestBusinessException extends BusinessException
{
    protected $code = 422;

    protected string $userMessage = 'test';
}
