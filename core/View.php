<?php
require_once __DIR__ . '/../model/UserModel.php';

class View {
    public static function render($viewName, $data = []) {
        global $pdo; // usamos la conexión global

        // Extraemos datos manuales
        extract($data);

        // Inyectamos automáticamente $user si hay sesión activa
        if (isset($_SESSION['id_user'])) {
            if (!isset($user)) {
                $userModel = new UserModel($pdo);
                $user = $userModel->getUserInfo($_SESSION['id_user']);
            }
        }

        // Ruta de la vista de contenido
        $contentViewPath = __DIR__ . "/../view/{$viewName}.php";

        if (!file_exists($contentViewPath)) {
            echo "Error: Vista '{$viewName}' no encontrada en la ruta {$contentViewPath}";
            return;
        }

        // Vista de contenido
        ob_start();
        include $contentViewPath;
        $pageContent = ob_get_clean();

        // Menú superior
        ob_start();
        include __DIR__ . '/../view/template/top_menu.php';
        $topMenu = ob_get_clean();

        // Menú lateral
        ob_start();
        include __DIR__ . '/../view/template/sidebar_menu.php';
        $sidebarMenu = ob_get_clean();

        // Plantilla principal
        include __DIR__ . '/../view/template/Main.php';
    }
}
