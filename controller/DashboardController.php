<?php
require_once __DIR__ . '/../model/UserModel.php';
require_once __DIR__ . '/../core/View.php';

class DashboardController {
  
    public function __construct() {
        
    }

    public function index() {
        // Evitamos el caché del navegador
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");

       

        // Creamos un array con los datos que la vista necesita.
        $data = [
            'Title'  => 'Cambiar Contraseña'
        ];
        
        
        View::render('dashboard', $data);
    }
}