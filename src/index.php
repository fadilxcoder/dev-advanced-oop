<?php

if (!isset($_GET['url'])) {
    header('Location: /login');
}

require_once 'router.php';
require_once 'loader.php';