<?php
declare(strict_types=1);

header("Content-Type: application/json; charset=utf-8");

ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_httponly', '1');

// If you have HTTPS, turn this on:
// ini_set('session.cookie_secure', '1');
ini_set('session.cookie_samesite', 'Lax');

session_start();

function json_in(): array {
    $raw = file_get_contents("php://input");
    if ($raw === false || trim($raw) === "") return [];
    $data = json_decode($raw, true);
    if (!is_array($data)) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid JSON"]);
        exit;
    }
    return $data;
}

function json_out($payload, int $code = 200): void {
    http_response_code($code);
    echo json_encode($payload);
    exit;
}

function require_login(): int {
    if (!isset($_SESSION["user_id"])) {
        json_out(["error" => "Unauthorized"], 401);
    }
    return (int)$_SESSION["user_id"];
}

// ---- DB (REMOTE) ----
// Put your remote DB host/user/pass here
function db(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;

    // IP HERE
    $host = "127.0.0.1";
    $db   = "SMALLPROJECT";
    $user = "root";
    $pass = "pass";

    $pdo = new PDO(
        "mysql:host={$host};dbname={$db};charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
    return $pdo;
}
?>