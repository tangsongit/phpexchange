<?php

namespace App\proxyAdmin\Controllers;

use Dcat\Admin\Http\Controllers\AuthController as BaseAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseAuthController
{
    protected function redirectPath()
    {
        //        dd(admin_url('/'));
        return $this->redirectTo ?: 'admin_url(' / ')';
    }
}
