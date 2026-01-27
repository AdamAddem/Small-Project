<?php
    
    $inData = getRequestInfo(); 

    // Get DB credentials
    $host = getenv('DB_HOST');
    $db = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $pwd = getenv('DB_PASS');

    $userID = $inData["userID"];
    $firstName = $inData["firstName"];
    $lastName = $inData["lastName"];
    $email = $inData["email"];
    $phone = $inData["phone"];
    
    $conn = new mysqli($host, $user, $pwd, $db);


    if ($conn->connect_error) {
        http_response_code(400);
        header('Content-type: text/plain');
        echo $conn->connect_error;
        exit();
    }
    else {
        // Create contact logic here
        
    }

    // Validation
    if (empty($firstName) || empty($lastName) || empty($userID)) {
        returnWithError("First name, last name, and user ID are required");
        $conn->close();
        exit();
    }

    // Helper functions
    function getRequestInfo() {
        return json_decode(file_get_contents('php://input'), true);
    }

    function sendResultInfoAsJson($obj) {
        header('Content-type: application/json');
        echo $obj;
    }

    function returnWithError($msg) {
        $retValue = '{"id":0,"error":"' . $msg . '"}';
        sendResultInfoAsJson($retValue);
    }

    function returnWithInfo($id, $firstName, $lastName, $email, $phone) {
        $retValue = '{"id":' . $id . ',"firstName":"' . $firstName . '","lastName":"' . $lastName . '","email":"' . $email . '","phone":"' . $phone . '","error":""}';
        sendResultInfoAsJson($retValue);
    }

?>