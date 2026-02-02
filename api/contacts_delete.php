<?php
    require __DIR__ . "/bootstrap.php";

    $userId = require_login();
    $data = json_in();

    $first = trim((string)($data["fn"] ?? ""));
    $last  = trim((string)($data["ln"] ?? ""));
    if ($first === "" || $last === "") {
     json_out(["error" => "first and last name required"], 400); 
    }
    

    $pdo = db();
    $stmt = $pdo->prepare("DELETE FROM Contacts 
        WHERE UserID = :uid
        AND FirstName = :fn
        AND LastName = :ln
    ");
    $stmt->execute([":uid" => $userId, ":fn" => $first, ":ln" => $last]);


    json_out(["ok" => $stmt->rowCount() > 0]);
?>