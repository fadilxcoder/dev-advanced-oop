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


// INIT

Dotenv::createImmutable(__DIR__)->load();       // Load .env variables, accessible by `$_ENV`
Debugger::enable(Debugger::DEVELOPMENT);        // Tracy debugger
$faker = Factory::create();                     // Faker generator
Session::setPrefix('app_');                     // Session prefix
Session::init();                                // Session start
$request = Request::createFromGlobals();        // HttpFoundation request (Symfony)

// OBJECTS

$view = new ViewManager('views', 'base.php');
$userServices = new UserManagementService();

// route to page

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

$excludedRoutes = [
    'login',
    'register',
];

if (null === Session::get("id_user") && !in_array($url, $excludedRoutes)) {
    header('Location: /login');
}

if (null !== Session::get("id_user") && in_array($url, $excludedRoutes)) {
    header('Location: /dashboard');
}


// EXEC
/*
try {
 
    // Generate a version 1 (time-based) UUID object
    $uuid1 = Uuid::uuid1();
    echo $uuid1->toString() . "<br>";
 
    // Generate a version 3 (name-based and hashed with MD5) UUID object
    $uuid3 = Uuid::uuid3(Uuid::NAMESPACE_DNS, 'php.net');
    echo $uuid3->toString() . "<br>";
 
    // Generate a version 4 (random) UUID object
    $uuid4 = Uuid::uuid4();
    echo $uuid4->toString() . "<br>";
 
    // Generate a version 5 (name-based and hashed with SHA1) UUID object
    $uuid5 = Uuid::uuid5(Uuid::NAMESPACE_DNS, 'php.net');
    echo $uuid5->toString() . "<br>";
 
} catch (UnsatisfiedDependencyException $e) {
    echo 'Caught exception: ' . $e->getMessage() . "\n";
}
*/


if ($request->request->has('login_process')) {
    if ($request->request->has('username') && $request->request->has('password')) {
        $uname = $request->request->get('username');
        $passwd = $request->request->get('password');
        $user = $userServices->getUserByUsernameAndPassword(htmlentities($uname), htmlentities($passwd));
        
        if (null !== $user) {
            Session::set("id_user", $user['id_user']);
            Session::set("un_user", $user['username']);
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

if ($request->query->get('action') && $request->query->get('action') == 'logout') {
    Session::destroy(Session::getPrefix(), true);
    header('Location: /');
}

/*
if ($request->query->has('action') && $request->query->get('action') == 'login') {
    
	if ($request->request->has('username') && $request->request->has('password')) {
        $user = $userServices->getUserByUsernameAndPassword(htmlentities($request->request->get('username')), htmlentities($request->request->get('password')) );
        
		if ($user !== null) {
            Session::set("id_user", $user['id_user']);
            Session::set("un_user", $user['username']);
			header('Location: /index.php');
		} else {
			echo $view->render('login.php',[
                'errors' => 'Utilisateur ou mot de passe non valide'
            ]);
		}
	}else{
		echo $view->render('login.php',[
            'errors' => 'Un ou plusieurs champs sont manquants'
        ]);
	}
} elseif($request->query->get('action') == 'logout') {
	Session::destroy(Session::getPrefix(), true);
    header('Location: /index.php');
    
} elseif( Session::get("id_user") !== null ) {
	if ($userServices->isUserInGroup((int)Session::get("id_user"), 2)){
        $arr = [];
	} else {
        $arr = [
            'noRights' => true,
        ];
    }

    echo $view->render('main.php', $arr);
	
} else {
	echo $view->render('login.php', []);
}
*/

// DISPLAYING THE RENDERED VIEW

echo $view->render($render['HTML'], $render['parametersArray']);
?>

