<?php
require_once __DIR__ . '/../core/View.php';
require_once __DIR__ . '/../model/StockModel.php';

class StockController {
    private $stockModel;

    public function __construct(PDO $conn) {
        $this->stockModel = new StockModel($conn);
    }

    // Mostrar vista de stock
    public function indexStock() {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?alert=3");
            exit();
        }

        $stock = $this->stockModel->getStock();

        $data = [
            'Title' => 'Gestión de Stock',
            'data' => $stock
        ];

        View::render('stock/viewStock', $data);
    }
   
}
