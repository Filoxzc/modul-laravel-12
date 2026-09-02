<?php
// src/GradeService.php
// Service untuk konversi skor ke huruf nilai
final class GradeService {
  // Konversi skor (0-100) ke huruf (A, AB, B, BC, C, D, E, INVALID)
  public static function letter(int $score): string {
    if ($score < 0 || $score > 100) return 'INVALID';
    if ($score >= 81) return 'A';
    if ($score >= 71) return 'AB';
    if ($score >= 66) return 'B';
    if ($score >= 61) return 'BC';
    if ($score >= 56) return 'C';
    if ($score >= 41) return 'D';
    return 'E';
  }
}

