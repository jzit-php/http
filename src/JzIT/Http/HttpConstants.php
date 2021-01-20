<?php

declare(strict_types=1);

namespace JzIT\Http;

interface HttpConstants
{
    public const SERVICE_NAME_ROUTER = 'router';
    public const SERVICE_NAME_REQUEST = 'request';
    public const SERVICE_NAME_EMITTER = 'emitter';
    
    public const POST = 'POST';
    public const GET = 'GET';
    public const PUT = 'PUT';
    public const DELETE = 'DELETE';
}
