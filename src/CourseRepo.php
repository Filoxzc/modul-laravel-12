<?php
// src/CourseRepo.php
// Repository untuk course/matakuliah
final class CourseRepo {
  // List semua course
  public static function list($pdo): array {
    $sql = "SELECT id, code, name, sks FROM courses";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
  }

  // Find course by code
  public static function findByCode($pdo, string $code): ?array {
    $sql = "SELECT * FROM courses WHERE code = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$code]);
    $row = $stmt->fetch();
    return $row ?: null;
  }
}
