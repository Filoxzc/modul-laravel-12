<?php
// src/FileStorage.php
// Service untuk menyimpan file di storage
final class FileStorage {
  // Simpan file dari string (dipakai autograder)
  public static function saveString(string $studentNim, string $filename, string $content): array {
    $safeName = basename($filename);
    $dir = __DIR__ . '/../storage/uploads/' . $studentNim;
    if (!is_dir($dir)) mkdir($dir, 0777, true);

    $path = $dir . '/' . $safeName;
    file_put_contents($path, $content, LOCK_EX);

    return [
      'stored_path' => 'storage/uploads/' . $studentNim . '/' . $safeName,
      'size_bytes' => filesize($path),
      'mime' => 'text/plain',
    ];
  }

  // Simpan uploaded file (move_uploaded_file untuk form upload)
  public static function saveUploadedFile(string $studentNim, array $file): ?array {
    // $file format: $_FILES['file']
    $safeName = basename($file['name']);
    $dir = __DIR__ . '/../storage/uploads/' . $studentNim;
    if (!is_dir($dir)) mkdir($dir, 0777, true);

    $path = $dir . '/' . $safeName;
    if (!move_uploaded_file($file['tmp_name'], $path)) return null;

    return [
      'stored_path' => 'storage/uploads/' . $studentNim . '/' . $safeName,
      'size_bytes' => filesize($path),
      'mime' => mime_content_type($path) ?: 'application/octet-stream',
    ];
  }
}

