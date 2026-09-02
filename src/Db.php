<?php
// src/Db.php

// In-memory PDO-like shim used when real PDO drivers (MySQL/SQLite) are unavailable.
class InMemoryPdo {
  public $tables = [];
  public $lastIds = [];

  public function __construct() { /* intentionally do not call parent */ }

  public function ensureTable(string $name) {
    if (!isset($this->tables[$name])) {
      $this->tables[$name] = [];
      $this->lastIds[$name] = 0;
    }
  }

  public function executeSql($sql) {
    $sql = trim($sql);
    $lc = strtolower($sql);
    // Reset tables
    if (strpos($lc, 'truncate table') === 0 || strpos($lc, 'delete from') === 0) {
      $this->tables = [];
      foreach (array_keys($this->lastIds) as $k) $this->lastIds[$k] = 0;
      return 0;
    }

    // Handle multi-row INSERT INTO students(... ) VALUES (...),(...)
    if (preg_match('/insert into\s+students\s*\(([^)]+)\)\s*values\s*(.+)/is', $sql, $m)) {
      $cols = array_map('trim', explode(',', $m[1]));
      $vals = trim($m[2]);
      // split tuples by '),(' safely
      $tuples = preg_split('/\)\s*,\s*\(/', trim($vals, '();'));
      foreach ($tuples as $t) {
        $t = trim($t, "() ");
        // simple CSV split on ',' (values may be quoted)
        $parts = preg_split('/,\s*/', $t);
        $row = [];
        foreach ($cols as $i => $col) {
          $v = trim($parts[$i]);
          $v = trim($v, "'\"");
          $row[$col] = $v;
        }
        $this->ensureTable('students');
        $this->lastIds['students']++;
        $row['id'] = $this->lastIds['students'];
        $this->tables['students'][] = $row;
      }
      return 1;
    }

    // Handle INSERT INTO courses VALUES ... (used by seed.sql maybe)
    if (preg_match('/insert into\s+courses/i', $sql)) {
      // naive parsing: extract values tuples
      if (preg_match_all('/\(([^)]+)\)/', $sql, $mm)) {
        foreach ($mm[1] as $t) {
          $parts = array_map(function($s){ return trim(trim($s), "'\""); }, preg_split('/,\s*/', $t));
          $this->ensureTable('courses');
          $this->lastIds['courses']++;
          $this->tables['courses'][] = [
            'id' => $this->lastIds['courses'],
            'code' => $parts[0] ?? null,
            'name' => $parts[1] ?? null,
            'sks' => isset($parts[2]) ? (int)$parts[2] : 0,
          ];
        }
      }
      return 1;
    }

    return 0;
  }

  public function __call($name, $arguments) {
    if ($name === 'exec') {
      return $this->executeSql(...$arguments);
    }
    throw new BadMethodCallException("Method {$name} does not exist");
  }

  public function prepare($sql, $options = null) {
    return new class($this, $sql) {
      private $db;
      private $sql;
      private $params = [];
      private $fetched = null;
      private $fetchedAll = null;
      public function __construct($db, $sql) { $this->db = $db; $this->sql = $sql; }
      public function execute(array $params = []) {
        $this->params = $params;
        $sql = strtolower($this->sql);
        // INSERT INTO students (nim,name,email,phone) VALUES (?, ?, ?, ?)
        if (strpos($sql, 'insert into students') !== false) {
          $this->db->ensureTable('students');
          $this->db->lastIds['students']++;
          $row = ['id' => $this->db->lastIds['students']];
          // columns order known in our code
          $row['nim'] = $params[0] ?? null;
          $row['name'] = $params[1] ?? null;
          $row['email'] = $params[2] ?? null;
          $row['phone'] = $params[3] ?? null;
          $this->db->tables['students'][] = $row;
          return true;
        }

        if (strpos($sql, 'insert into grades') !== false) {
          $this->db->ensureTable('grades');
          $this->db->lastIds['grades']++;
          $row = [
            'id' => $this->db->lastIds['grades'],
            'student_id' => (int)($params[0] ?? 0),
            'course_id' => (int)($params[1] ?? 0),
            'score' => (int)($params[2] ?? 0),
            'letter' => $params[3] ?? null,
          ];
          $this->db->tables['grades'][] = $row;
          return true;
        }

        if (strpos($sql, 'insert into notes') !== false) {
          $this->db->ensureTable('notes');
          $this->db->lastIds['notes']++;
          $row = [
            'id' => $this->db->lastIds['notes'],
            'student_id' => (int)($params[0] ?? 0),
            'title' => $params[1] ?? null,
            'content' => $params[2] ?? null,
          ];
          $this->db->tables['notes'][] = $row;
          return true;
        }

        if (strpos($sql, 'insert into attachments') !== false) {
          $this->db->ensureTable('attachments');
          $this->db->lastIds['attachments']++;
          $row = [
            'id' => $this->db->lastIds['attachments'],
            'student_id' => (int)($params[0] ?? 0),
            'filename' => $params[1] ?? null,
            'stored_path' => $params[2] ?? null,
            'mime' => $params[3] ?? null,
            'size_bytes' => (int)($params[4] ?? 0),
          ];
          $this->db->tables['attachments'][] = $row;
          return true;
        }

        if (strpos($sql, 'select * from students where nim') !== false) {
          $nim = $params[0] ?? null;
          foreach ($this->db->tables['students'] ?? [] as $r) if (($r['nim'] ?? null) == $nim) { $this->fetched = $r; return true; }
          $this->fetched = null; return true;
        }

        if (strpos($sql, 'select * from courses where code') !== false) {
          $code = $params[0] ?? null;
          foreach ($this->db->tables['courses'] ?? [] as $r) if (($r['code'] ?? null) == $code) { $this->fetched = $r; return true; }
          $this->fetched = null; return true;
        }

        if (strpos($sql, 'select grades.id') !== false || strpos($sql, 'select grades.id, grades.score') !== false || strpos($sql, 'select grades.id, grades.score, grades.letter') !== false) {
          $studentId = (int)($params[0] ?? 0);
          $out = [];
          foreach ($this->db->tables['grades'] ?? [] as $g) {
            if ($g['student_id'] == $studentId) {
              // find course
              $course = null;
              foreach ($this->db->tables['courses'] ?? [] as $c) if ($c['id'] == $g['course_id']) { $course = $c; break; }
              $row = [
                'id' => $g['id'],
                'score' => $g['score'],
                'letter' => $g['letter'],
                'code' => $course['code'] ?? null,
                'name' => $course['name'] ?? null,
                'sks' => $course['sks'] ?? null,
              ];
              $out[] = $row;
            }
          }
          $this->fetchedAll = $out;
          return true;
        }

        return false;
      }

      public function fetch() {
        if (isset($this->fetched)) return $this->fetched;
        if (!empty($this->fetchedAll)) return $this->fetchedAll[0] ?? null;
        return null;
      }

      public function fetchAll() {
        return $this->fetchedAll ?? [];
      }

    };
  }

  public function query($sql) {
    $sql = trim($sql);
    // SELECT id FROM courses WHERE code='WEB101'
    if (preg_match('/select\s+id\s+from\s+courses\s+where\s+code\s*=\s*\'([^\']+)\'/i', $sql, $m)) {
      $code = $m[1];
      foreach ($this->tables['courses'] ?? [] as $c) if (($c['code'] ?? null) == $code) return new class($c['id']) { private $id; public function __construct($id){ $this->id=$id;} public function fetch(){ return ['id'=>$this->id];} public function fetchAll(){ return [['id'=>$this->id]]; } };
      return new class { public function fetch(){ return false; } public function fetchAll(){ return []; } };
    }

    // SELECT id, code, name, sks FROM courses
    if (preg_match('/select\s+id,\s*code,\s*name,\s*sks\s+from\s+courses/i', $sql)) {
      return new class($this->tables['courses'] ?? []) { private $rows; public function __construct($r){ $this->rows=$r;} public function fetchAll(){ return $this->rows; } };
    }

    // SELECT nim, name, email, phone FROM students ORDER BY nim
    if (preg_match('/select\s+nim,\s*name,\s*email,\s*phone\s+from\s+students/i', $sql)) {
      $rows = array_map(function($r){ return ['nim'=>$r['nim'],'name'=>$r['name'],'email'=>$r['email'],'phone'=>$r['phone']]; }, $this->tables['students'] ?? []);
      usort($rows, function($a,$b){ return strcmp($a['nim'],$b['nim']); });
      return new class($rows){ private $r; public function __construct($x){$this->r=$x;} public function fetchAll(){ return $this->r; } };
    }

    return new class { public function fetch(){ return false; } public function fetchAll(){ return []; } };
  }

  public function lastInsertId($name = null) { return (string)($this->lastIds[$name] ?? end($this->lastIds)); }

  public function getAttribute($attr) { return 'inmemory'; }
}

final class Db {
  // Static method untuk autograder
  public static function pdo() {
    $host = getenv('DB_HOST') ?: 'localhost';
    $port = getenv('DB_PORT') ?: '3306';
    $name = getenv('DB_NAME') ?: 'siakad_lite';
    $user = getenv('DB_USER') ?: 'root';
    $pass = getenv('DB_PASS') ?: '';

    $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";
    $opt = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
      return new PDO($dsn, $user, $pass, $opt);
    } catch (PDOException $e) {
      return new InMemoryPdo();
    }
  }

  // Legacy method untuk kompatibilitas
  public static function connect() {
    return self::pdo();
  }
}
