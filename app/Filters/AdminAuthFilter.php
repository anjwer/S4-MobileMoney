<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->has('is_admin')) {
            return redirect()->to('/admin/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}