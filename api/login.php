<?php
    require __DIR__ . "/bootstrap.php";

    $data = json_in();
    $login = trim((string)($data["login"] ?? ""));
    $pass  = (string)($data["password"] ?? "");

    if ($login === "" || $pass === "") {
        json_out(["error" => "login and password required"], 400);
    }

    $pdo = db();
    $stmt = $pdo->prepare("SELECT ID, Password FROM Users WHERE Login = :login LIMIT 1");
    $stmt->execute([":login" => $login]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($pass, (string)$user["Password"])) {
        json_out(["error" => "invalid credentials"], 401);
    }

    $_SESSION["user_id"] = (int)$user["ID"];
    $_SESSION["login"] = $login;

    json_out(["ok" => true]);
?>