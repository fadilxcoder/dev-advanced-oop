<?php

if (!isset($_GET['url'])) {
    header('Location: /index');
}

require_once 'router.php';
require_once 'loader.php';