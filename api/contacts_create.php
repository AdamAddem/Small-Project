<?php
    require __DIR__ . "/bootstrap.php";

    $userId = require_login();
    $data = json_in();

    $first = trim((string)($data["fn"] ?? ""));
    $last  = trim((string)($data["ln"] ?? ""));
    $email = trim((string)($data["em"] ?? ""));
    $phone = trim((string)($data["ph"] ?? ""));

    $pdo = db();
    $stmt = $pdo->prepare(
        "INSERT INTO Contacts (UserID, FirstName, LastName, Email, Phone)
        VALUES (:uid, :fn, :ln, :em, :ph)"

    );
    $stmt->execute([
        ":uid" => $userId,
        ":fn"  => $first,
        ":ln"  => $last,
        ":em"  => $email,
        ":ph"  => $phone,
    ]);



    json_out(["ok" => true, "contactId" => (int)$pdo->lastInsertId()], 201);
?>