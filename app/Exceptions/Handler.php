<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    // ...existing code...

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {
            $status = $exception->getCode();
            if (!is_int($status) || $status < 100 || $status >= 600) {
                $status = 400; // Código de status padrão para erros
            }
            return response()->json([
                'message' => $exception->getMessage()
            ], $status);
        }

        return parent::render($request, $exception);
    }
}