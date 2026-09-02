<?php

require_once __DIR__ . '/src/Db.php';

require_once __DIR__ . '/src/StudentRepo.php';
require_once __DIR__ . '/src/CourseRepo.php';
require_once __DIR__ . '/src/GradeRepo.php';
require_once __DIR__ . '/src/NoteRepo.php';
require_once __DIR__ . '/src/AttachmentRepo.php';

require_once __DIR__ . '/src/Validator.php';
require_once __DIR__ . '/src/Logger.php';
require_once __DIR__ . '/src/FileStorage.php';
require_once __DIR__ . '/src/GradeService.php';

$pdo = Db::pdo();

echo "<h1>PBL Mini SIAKAD Lite</h1>";

echo "<hr>";

echo "<h2>1. Test StudentRepo</h2>";

$students = StudentRepo::list($pdo);

echo "<pre>";
print_r($students);
echo "</pre>";

echo "<hr>";

echo "<h2>2. Test CourseRepo</h2>";

$courses = CourseRepo::list($pdo);

echo "<pre>";
print_r($courses);
echo "</pre>";

echo "<hr>";

echo "<h2>3. Test GradeRepo</h2>";

$grades = GradeRepo::listForStudent($pdo, 2);

echo "<pre>";
print_r($grades);
echo "</pre>";

echo "<hr>";

echo "<h2>4. Test NoteRepo</h2>";

$notes = NoteRepo::listForStudent($pdo, 2);

echo "<pre>";
print_r($notes);
echo "</pre>";

echo "<hr>";

echo "<h2>5. Test Validator</h2>";

echo "NIM 001 : ";
echo Validator::isValidNim('001')
    ? 'VALID'
    : 'INVALID';

echo "<br>";

echo "Email ana@x.com : ";
echo Validator::isValidEmail('ana@x.com')
    ? 'VALID'
    : 'INVALID';

echo "<br>";

echo "Phone 08123456789 : ";
echo Validator::isValidPhone('08123456789')
    ? 'VALID'
    : 'INVALID';

echo "<hr>";

echo "<h2>6. Test GradeService</h2>";

echo "Nilai 85 = ";
echo GradeService::letter(85);

echo "<br>";
echo "Nilai 72 = ";
echo GradeService::letter(72);
echo "<hr>";
echo "<h2>7. Test Logger</h2>";
Logger::info('PBL dijalankan');
echo "Log berhasil ditulis ke storage/app.log";
echo "<hr>";
echo "<h2>8. Test AttachmentRepo</h2>";
$content = "Ini file test attachment";
AttachmentRepo::addFromString(
    $pdo,
    2,
    '002',
    'test.txt',
    $content
);
echo "Attachment berhasil dibuat";
echo "<hr>";
echo "<h2>SEMUA TEST SELESAI</h2>";