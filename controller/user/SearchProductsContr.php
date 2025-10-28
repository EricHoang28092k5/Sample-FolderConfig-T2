<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/user/SearchProducts.php"; 

class SearchProductsContr {
    private $product;

    public function __construct() {
        $this->product = new SearchProducts();
    }

    public function handleSearch() {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $maLoaiSP = isset($_GET['MaLoaiSP']) ? (int)$_GET['MaLoaiSP'] : 0;
        $min_price = isset($_GET['min_price']) ? (int)$_GET['min_price'] : 0;
        $max_price = isset($_GET['max_price']) ? (int)$_GET['max_price'] : 500000;

        return $this->product->searchProducts($search, $maLoaiSP, $min_price, $max_price);
    }
}

$controller = new SearchProductsContr();
$products = $controller->handleSearch();
?>
