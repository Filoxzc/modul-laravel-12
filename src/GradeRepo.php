<?php
// src/GradeRepo.php
require_once __DIR__ . '/GradeService.php';

final class GradeRepo {
  // Add grade untuk student dengan skor
  public static function add($pdo, int $studentId, int $courseId, int $score): bool {
    $letter = GradeService::letter($score);
    if ($letter === 'INVALID') return false;

    // INSERT dengan prepared statement
    $sql = "INSERT INTO grades (student_id, course_id, score, letter) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$studentId, $courseId, $score, $letter]);
  }

  // List grade untuk student JOIN dengan courses
  public static function listForStudent($pdo, int $studentId): array {
    $sql = "SELECT grades.id, grades.score, grades.letter, courses.code, courses.name, courses.sks 
            FROM grades 
            JOIN courses ON grades.course_id = courses.id 
            WHERE grades.student_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$studentId]);
    return $stmt->fetchAll();
  }
}

