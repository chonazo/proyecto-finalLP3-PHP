<?php
/*Aquí se inicia la session del usuario, único punto de entrada del usuario, todas las peticiones 
del usuario pasan por aquí index.php*/
session_start();

// Cargamos las librerías instaladas para cargador de Composer (para PHPMailer y otras librerías futuras)
require __DIR__ . '/vendor/autoload.php'; 


// Cargamos la conexión a la bd
require_once 'config/Conexion.php';

// 1. Método de autocarga de clases para cargar controladores y modelos en automation
spl_autoload_register(function ($className) {
    
    $folders = ['controller', 'model'];// definimos las carpetas donde buscar las clases

    foreach ($folders as $folder) {//Buscamos en cada carpeta si existen las clases esto construirá por ejemplo 'controller/UserController.php'
        $path = $folder . '/' . $className . '.php'; 
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Obtenemos el nombre del controlador y la acción de la URL
$controllerName = $_GET['controller'] ?? 'Login';
$action = $_GET['action'] ?? 'login';

// construir el nombre completo de la clase del controlador por ejemplo 'UserController'
$controllerClass = $controllerName . 'Controller';


// 2. Control de acceso: si no hay sesión activa, solo permitir acceso al LoginController (middleware simple)
$publicControllers = ['Login'];

// Verificamos si la sesión esta activa y si el controlador solicitado es publico
if (!in_array($controllerName, $publicControllers) && !isset($_SESSION['id_user'])) {// Se usa id_user para mayor seguridad en ves de username
    header("Location: index.php?controller=Login&action=login&alert=3");// Si no está logueado y no está intentando acceder a un controlador público
    exit();
} 

// 4. realizamos la lógica del enrutador
if (class_exists($controllerClass) && method_exists($controllerClass, $action)) { //verificamos que la clase y el metodo existan
    
    try { // usamos el 'try-catch' para manejar si el constructor requiere la conexión o no
        $reflectionMethod = new ReflectionMethod($controllerClass, '__construct'); // Buscamos en constructor de la clase y si necesita parametros
        if ($reflectionMethod->getNumberOfParameters() > 0) { // si el constructor necesita para metros le pasamos la conexion
            $controller = new $controllerClass($pdo);
        } else {
            $controller = new $controllerClass(); // si no necesita parametros lo instanciamos normalmente
        }
    } catch (ReflectionException $e) {
        $controller = new $controllerClass();
    }
    
    // 5. Ejecutamos la accion del controlador
    $controller->$action();
} else {
    // 6. Si el controlador o la acción no existen redirigir al login
    header("Location: index.php?controller=Login&action=login&error=not_found");
    exit();
}