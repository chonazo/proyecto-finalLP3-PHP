<?php
class MainController {
    // Constructor vacío para carga del router
    public function __construct() {

    }

    public function index() {// Si el usuario no inicio session lo devolvemos al login con alerta = 3
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

       // Datos que quieras pasar al main (opcional)
        $data = [
            'pageTitle' => 'Panel Principal'
        ];

        // Renderizamos la vista (dashboard por defecto al entrar en main)
        View::render('dashboard', $data);
    }
}
