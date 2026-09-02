<?php
// src/NoteRepo.php
// Repository untuk note/catatan konsultasi student
final class NoteRepo {
  // Add note untuk student
  public static function add($pdo, int $studentId, string $title, string $content): bool {
    $title = trim($title);
    $content = trim($content);
    if ($title === '' || $content === '') return false;

    // INSERT dengan prepared statement
    $sql = "INSERT INTO notes (student_id, title, content) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$studentId, $title, $content]);
  }

  // List note untuk student
  public static function listForStudent($pdo, int $studentId, int $limit = 10): array {
    $sql = "SELECT * FROM notes WHERE student_id = ? ORDER BY id DESC LIMIT ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$studentId, $limit]);
    return $stmt->fetchAll();
  }
}
