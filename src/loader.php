<?php 

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
use Codebase\Test;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

use Symfony\Component\HttpFoundation\Request;

use Codebase\Managers\ViewManager;
use Codebase\Services\UserManagementService;


// INIT

Dotenv::createImmutable(__DIR__)->load();       // Load .env variables

Debugger::enable(Debugger::DEVELOPMENT);        // Tracy debugger

$faker = Factory::create();                     // Faker generator

Session::setPrefix('app_');                     // Session
Session::init();

$request = Request::createFromGlobals();        // HttpFoundation request (Symfony)


// EXEC

// dump($_ENV);

$test = new Test();

Session::set("id_user", 'xyz');
// dump(Session::get("id_user"));
// dump(Session::pull("id_user"));
// dump(Session::id());
// $data = 'dev...';

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

// dump($request);
$url = str_replace('/', '', $_GET['url']);
// dump($url);
// dump($routes);
foreach ($routes as $key => $value) {
    if ($key === $url) {
        $page = $value;

    }
}

// dump($routes);



$view = new ViewManager('views', 'base.php');

echo $view->render($page,[]);

$userServices = new UserManagementService();
// dump($view);
// echo $view->render('login.php',['errors'=>'']);
// echo $view->render('main.php',['errors'=>'']);

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
?>

