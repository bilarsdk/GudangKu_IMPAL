<?php
namespace App\Controllers;

use App\Core\Database;

class AuthController
{
    public function __construct()
    {

        // Pastikan akun admin ada di database
        $this->validate();
    }

    private function validate()
    {
        // Koneksi ke database
        $db = Database::conn();
        
        // Cek apakah admin sudah ada di tabel admin
        $query = "SELECT * FROM admin WHERE username = 'admin' LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();

        // Jika admin belum ada, tambahkan
        if (!$result) {
            // Password yang sudah di-hash
            $hashedPassword = password_hash('admin', PASSWORD_DEFAULT);

            // Menambahkan akun admin
            $insertQuery = "INSERT INTO admin (username, password_hash, created_at) VALUES ('admin', ?, NOW())";
            $insertStmt = $db->prepare($insertQuery);
            $insertStmt->execute([$hashedPassword]);
        }
    }

    public function showLogin(): void
    {
        // Tampilkan view login
        require __DIR__ . '/../Views/auth/login.php';
    }

    public function login(): void
    {
        // Ambil data username dan password dari form login
        $u = $_POST['username'] ?? '';
        $p = $_POST['password'] ?? '';

        // Koneksi ke database
        $db = Database::conn();
        
        // Cek kredensial di database
        $query = "SELECT * FROM admin WHERE username = :username LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->execute([':username' => $u]);
        $user = $stmt->fetch();

        // Jika username ditemukan dan password cocok
        if ($user && password_verify($p, $user['password_hash'])) {
            // Set session untuk autentikasi berhasil
            $_SESSION['auth'] = true;
            header('Location: /?r=category');
            exit;
        }

        // Jika login gagal, tampilkan error
        $_SESSION['error'] = 'Incorrect Username or Password!           ';
        header('Location: /?r=login');
        exit;
    }

    public function logout(): void
    {
        // Menghapus session dan logout
        session_destroy();
        header('Location: /?r=login');
        exit;
    }
}
