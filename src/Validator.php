<?php
// src/Validator.php
// Validasi input menggunakan regex
final class Validator {
  // Validasi NIM: 3-10 digit
  public static function isValidNim(string $nim): bool {
    return preg_match('/^[0-9]{3,10}$/', $nim) === 1;
  }

  // Validasi Email
  public static function isValidEmail(string $email): bool {
    return preg_match('/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/', $email) === 1;
  }

  // Validasi Telepon: mulai 0 atau +62, diikuti 8-14 digit
  public static function isValidPhone(string $phone): bool {
    return preg_match('/^(\+62|0)[0-9]{8,14}$/', $phone) === 1;
  }
}

