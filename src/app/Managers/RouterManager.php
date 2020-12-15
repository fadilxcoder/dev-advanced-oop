<?php

namespace Codebase\Managers;

class RouterManager
{
    public static function init($routes)
    {
        $render = [];
        $url = str_replace('/', '', $_GET['url']);
        foreach ($routes as $key => $value) {
            if ($key === $url) {
                $page = $value;
            }
        }

        if (!isset($page)) {
            $render['HTML'] = '404.php';
            $render['parametersArray'] = [
                'errors' => 'Page not found !',
            ];
        } else {
            $render['HTML'] = $page;
            $render['parametersArray'] = [];
        }

        return $render;
    }
}