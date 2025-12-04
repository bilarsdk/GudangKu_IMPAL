<?php
namespace App\Controllers;
use App\Models\Category;

class CategoryController {

    // Menampilkan daftar kategori atau hasil pencarian
    public static function index() {
        // PERBAIKAN: Tambahkan session_start() jika belum ada di file lain
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $searchQuery = $_GET['q'] ?? '';  // Mendapatkan nilai pencarian dari URL (jika ada)

        // Mengambil data kategori berdasarkan query pencarian
        $categories = Category::search($searchQuery);  // Menyesuaikan dengan model untuk pencarian

        // Menampilkan data kategori dalam layout
        require __DIR__.'/../Views/category/index.php';
    }

    // Menambahkan kategori baru
    public static function create() {
        // PERBAIKAN: Pastikan session dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // PERBAIKAN: Validasi method request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /?r=category');
            exit;
        }

        // Ambil nama kategori dari form
        $name = trim($_POST['name'] ?? '');

        // Validasi kategori kosong
        if (empty($name)) {
            $_SESSION['error'] = "Category name cannot be empty!";
            header('Location: /?r=category');
            exit;
        }

        // PERBAIKAN: Tambahkan validasi panjang maksimal
        if (strlen($name) > 100) {
            $_SESSION['error'] = "Category name is too long! Maximum 100 characters.";
            header('Location: /?r=category');
            exit;
        }

        // Periksa apakah kategori sudah ada
        if (Category::existsByName($name)) {
            $_SESSION['error'] = "The category has already been added!";
            header('Location: /?r=category');
            exit;
        }

        // Simpan kategori ke database
        $isCreated = Category::create($name);

        // Cek jika data berhasil disimpan
        if ($isCreated) {
            // PERBAIKAN: Tambahkan pesan sukses
            $_SESSION['success'] = "Category added successfully!";
            header('Location: /?r=category');
        } else {
            // Tampilkan error jika gagal
            $_SESSION['error'] = "Failed to add category!";
            header('Location: /?r=category'); 
        }
        exit;
    }

    // Mengupdate kategori
    public static function update() {
        // PERBAIKAN: Pastikan session dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // PERBAIKAN: Validasi method request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /?r=category');
            exit;
        }

        // PERBAIKAN: Validasi ID ada dan valid
        if (!isset($_POST['id']) || empty($_POST['id'])) {
            $_SESSION['error'] = "Invalid category ID!";
            header('Location: /?r=category');
            exit;
        }

        $id = (int)$_POST['id'];
        $name = trim($_POST['name'] ?? '');

        // Validasi kategori kosong
        if (empty($name)) {
            $_SESSION['error'] = "Category name cannot be empty!";
            header('Location: /?r=category');
            exit;
        }

        // PERBAIKAN: Tambahkan validasi panjang maksimal
        if (strlen($name) > 100) {
            $_SESSION['error'] = "Category name is too long! Maximum 100 characters.";
            header('Location: /?r=category');
            exit;
        }

        // PERBAIKAN: Cek apakah nama baru sudah digunakan kategori lain
        // (opsional, tergantung apakah Anda ingin mengizinkan nama duplikat saat update)
        $existingCategory = Category::existsByName($name);
        if ($existingCategory) {
            // Bisa tambahkan pengecekan apakah itu kategori yang sama
            $_SESSION['error'] = "Category name already exists!";
            header('Location: /?r=category');
            exit;
        }

        // Update kategori di database
        $isUpdated = Category::update($id, $name);

        // PERBAIKAN: Cek hasil update
        if ($isUpdated) {
            $_SESSION['success'] = "Category updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update category!";
        }

        // Redirect ke halaman kategori setelah berhasil
        header('Location: /?r=category');
        exit;
    }
}
?>