<?php
namespace App\Models;
use App\Core\Database;
use PDO;

class Product {
  public static function all(?string $q=null, bool $sort=false): array {
    $sql = "SELECT p.*, c.name AS category_name
            FROM product p JOIN category c ON c.id=p.category_id";
    $args = [];
    if ($q) { $sql .= " WHERE p.name LIKE ?"; $args[] = "%$q%"; }   // Pencarian
    if ($sort){ $sql .= " ORDER BY p.name ASC"; }                   // Pengurutan
    $stmt = Database::conn()->prepare($sql);
    $stmt->execute($args);
    return $stmt->fetchAll();
  }
  public static function create(array $data): bool {
    $stmt = Database::conn()->prepare(
      "INSERT INTO product(category_id, code, name, description, stock, price)
       VALUES(?,?,?,?,?,?)"
    );
    return $stmt->execute([$data['category_id'], $data['code'], $data['name'], $data['description'], $data['stock'], $data['price']]);
  }
  public static function update(int $id, array $data): bool {
    $stmt = Database::conn()->prepare(
      "UPDATE product SET category_id=?, code=?, name=?, description=?, stock=?, price=? WHERE id=?"
    );
    return $stmt->execute([$data['category_id'], $data['code'], $data['name'], $data['description'], $data['stock'], $data['price'], $id]);
  }
  public static function delete(int $id): bool {
    $stmt = Database::conn()->prepare("DELETE FROM product WHERE id=?");
    return $stmt->execute([$id]);
  }
}
