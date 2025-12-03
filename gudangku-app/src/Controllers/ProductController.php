<?php
namespace App\Controllers;
use App\Models\Product;
use App\Models\Category;

class ProductController {

    // Menampilkan daftar produk
    public static function index() {
        $q = $_GET['q'] ?? null; // Mencari produk berdasarkan nama
        $sort = isset($_GET['sort']); // Mengurutkan produk berdasarkan abjad

        // Mengambil produk berdasarkan pencarian dan urutan
        $products = Product::all($q, $sort);
        $categories = Category::all(); // Mengambil semua kategori untuk dropdown
        require __DIR__.'/../Views/product/index.php';
    }

    // Menampilkan form untuk menambah atau mengedit produk
    public static function form() {
        $categories = Category::all();
        $product = null;
        
        // Jika ada ID produk, ambil data produk untuk di-edit
        if (isset($_GET['id'])) {
            $product = Product::find((int)$_GET['id']);
        }

        require __DIR__.'/../Views/product/form.php'; // Menampilkan form
    }

    // Menyimpan data produk (tambah atau update)
    public static function save() {
        $data = [
            'category_id' => (int)$_POST['category_id'],
            'code' => $_POST['code'],
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'stock' => (int)$_POST['stock'],
            'price' => (float)$_POST['price']
        ];

        if (empty($_POST['id'])) {
            // Menambah produk baru
            Product::create($data);
        } else {
            // Mengupdate produk yang sudah ada
            Product::update((int)$_POST['id'], $data);
        }

        header('Location: /?r=product'); // Redirect ke halaman produk
    }

    // Menghapus produk
    public static function delete() {
        $id = (int)$_GET['id'];
        Product::delete($id); // Menghapus produk berdasarkan ID
        header('Location: /?r=product'); // Redirect ke halaman produk
    }
}
