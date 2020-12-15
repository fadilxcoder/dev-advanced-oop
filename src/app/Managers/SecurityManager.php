<?php

namespace Codebase\Managers;

use Josantonius\Session\Session;

class SecurityManager
{
    public static function verify()
    {
        $url = str_replace('/', '', $_GET['url']);
        $excludedRoutes = [
            'login',
            'register',
        ];

        if (null === Session::get("id_user") && !in_array($url, $excludedRoutes)) {
            return 'login';
        }

        if (null !== Session::get("id_user") && in_array($url, $excludedRoutes)) {
            return 'dashboard';
        }

        return null;
    }
}