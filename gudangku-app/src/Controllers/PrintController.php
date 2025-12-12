<?php
namespace App\Controllers;
use App\Models\Category;
use App\Models\Product;

class PrintController {

    // Method untuk generate PDF list produk berdasarkan kategori
    public static function printProductsByCategory() {
        // Pastikan session dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Ambil semua kategori
        $categories = Category::all();
        
        // Array untuk menyimpan produk per kategori
        $categoryProducts = [];
        
        foreach ($categories as $category) {
            // Ambil produk untuk setiap kategori
            $products = Product::getByCategoryId($category['id']);
            
            // Simpan jika kategori memiliki produk
            if (!empty($products)) {
                $categoryProducts[] = [
                    'category' => $category,
                    'products' => $products
                ];
            }
        }

        // Load view untuk print/PDF
        require __DIR__.'/../Views/print/product_by_category.php';
    }
}
?>