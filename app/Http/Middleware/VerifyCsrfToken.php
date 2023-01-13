<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'http://192.168.10.10:8080/alumno/store',
        'http://192.168.10.10:8080/alumno/image/upload/store',
        //
    ];
}
