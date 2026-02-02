<?php
    require __DIR__ . "/bootstrap.php";

    $data = json_in();

    $login = trim((string)($data["login"] ?? ""));
    $pass  = trim((string)($data["password"] ?? ""));
    $first = trim((string)($data["firstName"] ?? ""));
    $last  = trim((string)($data["lastName"] ?? ""));

    if ($login === "" || $pass === "") 
        json_out(["error" => "login and password required"], 400);
    

    $hash = password_hash($pass, PASSWORD_DEFAULT);

    try {
        $pdo = db();
        $stmt = $pdo->prepare(
            "INSERT INTO Users (Login, Password, FirstName, LastName)
            VALUES (:login, :pw, :fn, :ln)"
        );
        $stmt->execute([
            ":login" => $login,
            ":pw"    => $hash,
            ":fn"    => $first,
            ":ln"    => $last,
        ]);

        $_SESSION["user_id"] = (int)$pdo->lastInsertId();
        $_SESSION["login"] = $login;

        json_out(["ok" => true], 201);
    } catch (PDOException $e) {
        // Duplicate login
        if (($e->errorInfo[1] ?? null) === 1062) {
            json_out(["error" => "login already exists"], 409);
        }
        json_out(["error" => "registration failed"], 500);
    }
?>