<?php

// DECLARATION

declare(strict_types=1);

// ERRORS

ini_set('display_errors', 'true');
ini_set('display_startup_errors', 'true');
error_reporting(E_ALL);

// PACKAGES

require 'vendor/autoload.php';
use Dotenv\Dotenv;
use Tracy\Debugger;
use Faker\Factory;
use Josantonius\Session\Session;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Symfony\Component\HttpFoundation\Request;
use Codebase\Managers\ViewManager;
use Codebase\Services\UserManagementService;
use Codebase\Managers\RouterManager;
use Codebase\Managers\SecurityManager;


// INIT

Dotenv::createImmutable(__DIR__)->load();       // Load .env variables, accessible by `$_ENV`
Debugger::enable(Debugger::DEVELOPMENT);        // Tracy debugger
$faker = Factory::create();                     // Faker generator
Session::setPrefix('app_');                     // Session prefix
Session::init();                                // Session start
$request = Request::createFromGlobals();        // HttpFoundation request (Symfony)

$view = new ViewManager('views', 'base.php');
$userServices = new UserManagementService();
$render = RouterManager::init($routes);
$isAppAllowed = SecurityManager::verify();

if (null !== $isAppAllowed) {
    header('Location: /' . $isAppAllowed);
}


if ($request->request->has('login_process')) {
    if ($request->request->has('username') && $request->request->has('password')) {
        $uname = $request->request->get('username');
        $passwd = $request->request->get('password');
        $user = $userServices->getUserByUsernameAndPassword(htmlentities($uname), htmlentities($passwd));
        
        if (null !== $user) {
            Session::set("id_user", $user['id_user']);
            Session::set("un_user", $user['username']);
            $userServices->updateLastLogin((int)$user['id_user']);
            header('Location: /dashboard');
        } else {
            $render['HTML'] = 'login.php';
            $render['parametersArray'] = [
                'errors' => 'Invalid Username / Password',
            ];
        }
    } else {
        $render['HTML'] = 'login.php';
        $render['parametersArray'] = [
            'errors' => 'One or more fields missing.',
        ];
    }
}

if ($request->request->has('register_process')) {
    if ($request->request->has('username') && $request->request->has('password')) {
        $uname = $request->request->get('username');
        $passwd = $request->request->get('password');
        $user = $userServices->insertUser(htmlentities($uname), htmlentities($passwd));
        
        if ($user) {
            $render['HTML'] = 'login.php';
            $render['parametersArray'] = [
                'success' => 'Account created !',
            ];
        } else {
            $render['HTML'] = 'login.php';
            $render['parametersArray'] = [
                'errors' => 'Something went wrong !',
            ];
        }
    } else {
        $render['HTML'] = 'login.php';
        $render['parametersArray'] = [
            'errors' => 'One or more fields missing.',
        ];
    }
}

if ($request->query->get('action') && $request->query->get('action') == 'logout') {
    Session::destroy(Session::getPrefix(), true);
    header('Location: /');
}

if (null !== Session::get("id_user")) {
	if ($userServices->isUserInGroup((int)Session::get("id_user"), 2) ==- false) {
        $render['parametersArray'] = [
            'noRights' => true,
        ];
    }
}

// DISPLAYING THE RENDERED VIEW

// dump($render);
echo $view->render($render['HTML'], $render['parametersArray']);
?>

