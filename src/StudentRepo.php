<?php
// src/StudentRepo.php
require_once __DIR__ . '/Validator.php';

final class StudentRepo {
  // Create student dengan validasi NIM dan email
  public static function create($pdo, string $nim, string $name, string $email, ?string $phone): int {
    // Validasi regex (wajib)
    if (!Validator::isValidNim($nim) || !Validator::isValidEmail($email)) return 0;
    if ($phone !== null && $phone !== '' && !Validator::isValidPhone($phone)) return 0;

    // INSERT dengan prepared statement
    $sql = "INSERT INTO students (nim, name, email, phone) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nim, $name, $email, $phone]);
    return (int)$pdo->lastInsertId();
  }

  // Find by NIM
  public static function findByNim($pdo, string $nim): ?array {
    $sql = "SELECT * FROM students WHERE nim = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nim]);
    $row = $stmt->fetch();
    return $row ?: null;
  }

  // List semua student
  public static function list($pdo): array {
    $sql = "SELECT nim, name, email, phone FROM students ORDER BY nim";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
  }
}
