<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('logged_in')) {
            log_message('debug', '[AUTH_FILTER] allowed authenticated request method={method} path={path}', [
                'method' => $request->getMethod(),
                'path'   => $request->getUri()->getPath(),
            ]);
            return;
        }

        log_message('debug', '[AUTH_FILTER] redirect unauthenticated request method={method} path={path}', [
            'method' => $request->getMethod(),
            'path'   => $request->getUri()->getPath(),
        ]);
        return redirect()->to(base_url('login'));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No-op.
    }
}
