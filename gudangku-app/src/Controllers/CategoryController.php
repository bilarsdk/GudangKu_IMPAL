<?php
namespace App\Controllers;
use App\Models\Category;

class CategoryController {

    // Menampilkan daftar kategori atau hasil pencarian
    public static function index() {
        
        $searchQuery = $_GET['q'] ?? '';  // Mendapatkan nilai pencarian dari URL (jika ada)

        // Mengambil data kategori berdasarkan query pencarian
        $categories = Category::search($searchQuery);  // Menyesuaikan dengan model untuk pencarian

        // Menampilkan data kategori dalam layout
        require __DIR__.'/../Views/category/index.php';
    }

    // Menambahkan kategori baru
    public static function create() {
        // Ambil nama kategori dari form
        $name = trim($_POST['name'] ?? '');

        // Validasi kategori kosong
        if (empty($name)) {
            $_SESSION['error'] = "Category name cannot be empty!";
            header('Location: /?r=category');  // Kembali ke halaman form
            exit;
        }

        // Simpan kategori ke database
        Category::create($name);  // Menambahkan kategori baru ke database

        // Redirect ke halaman kategori setelah berhasil
        header('Location: /?r=category');
        exit;
    }


    // Mengupdate kategori
    public static function update() {
    $id = (int)$_POST['id'];  // Ambil ID kategori yang akan diupdate
    $name = trim($_POST['name']);  // Ambil nama kategori baru

    // Validasi kategori kosong
    if (empty($name)) {
        $_SESSION['error'] = "Category name cannot be empty!";
        header('Location: /?r=catUpdate&id=' . $id);  // Kembali ke halaman form
        exit;
    }

    // Update kategori di database
    Category::update($id, $name);  // Mengupdate kategori berdasarkan ID

    // Redirect ke halaman kategori setelah berhasil
    header('Location: /?r=category');
    exit;
}



}
