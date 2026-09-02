<?php
// src/AttachmentRepo.php
require_once __DIR__ . '/FileStorage.php';

final class AttachmentRepo {
  // Add attachment dari string (dipakai autograder)
  public static function addFromString($pdo, int $studentId, string $studentNim, string $filename, string $content): bool {
    $saved = FileStorage::saveString($studentNim, $filename, $content);

    // INSERT attachment metadata ke DB
    $sql = "INSERT INTO attachments (student_id, filename, stored_path, mime, size_bytes) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$studentId, $filename, $saved['stored_path'], $saved['mime'], $saved['size_bytes']]);
  }

  // List attachment untuk student
  public static function listForStudent($pdo, int $studentId, int $limit = 10): array {
    $sql = "SELECT filename, stored_path, created_at FROM attachments WHERE student_id = ? ORDER BY id DESC LIMIT ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$studentId, $limit]);
    return $stmt->fetchAll();
  }

  // Count attachment untuk student
  public static function countForStudent($pdo, int $studentId): int {
    $sql = "SELECT COUNT(*) FROM attachments WHERE student_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$studentId]);
    return (int)$stmt->fetchColumn();
  }
}

