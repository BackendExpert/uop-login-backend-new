<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET");
header("Content-Type: application/json");

include "../config.php";

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $action = $_POST['action'] ?? '';

    if (!$action) {
        echo json_encode(["error" => "Action not specified"]);
        exit;
    }

    // CREATE DIPLOMA
    if ($action === "creatediploma") {
        $Title = $_POST['title'] ?? '';
        $Desc = $_POST['description'] ?? '';
        $Link = $_POST['link'] ?? '';

        // Check if title exists
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM diploma WHERE title = ?");
        $checkStmt->execute([$Title]);
        $count = $checkStmt->fetchColumn();

        if ($count > 0) {
            echo json_encode(["error" => "Title already exists"]);
            exit;
        }

        $target_file = "";
        if (!empty($_FILES['image']['name'])) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo json_encode(["error" => "Image upload failed"]);
                exit;
            }
        }

        $stmt = $pdo->prepare("INSERT INTO diploma (title, description, image, link, is_active) VALUES (?, ?, ?, ?, 1)");
        if ($stmt->execute([$Title, $Desc, $target_file, $Link])) {
            echo json_encode(["Status" => "Success"]);
        } else {
            echo json_encode(["error" => "Failed to create diploma"]);
        }
        exit;
    }

    // UPDATE DIPLOMA
    if ($action === "updateDip") {
        $dipID = $_POST['Dipid'] ?? '';
        if (!$dipID) {
            echo json_encode(["error" => "Diploma ID required"]);
            exit;
        }

        $Desc = $_POST['description'] ?? '';
        $Link = $_POST['link'] ?? '';

        $target_file = "";
        if (!empty($_FILES['image']['name'])) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo json_encode(["error" => "Image upload failed"]);
                exit;
            }
        }

        // Build dynamic query
        $updateQuery = "UPDATE diploma SET ";
        $params = [];

        if ($Desc) {
            $updateQuery .= "description = ?, ";
            $params[] = $Desc;
        }

        if ($Link) {
            $updateQuery .= "link = ?, ";
            $params[] = $Link;
        }

        if ($target_file) {
            $updateQuery .= "image = ?, ";
            $params[] = $target_file;
        }

        $updateQuery = rtrim($updateQuery, ', ') . " WHERE id = ?";
        $params[] = $dipID;

        $stmt = $pdo->prepare($updateQuery);
        if ($stmt->execute($params)) {
            echo json_encode(["Status" => "Success"]);
        } else {
            echo json_encode(["error" => "Failed to update diploma"]);
        }
        exit;
    }

    // TOGGLE STATUS
    if ($action === "toggleDiplomaStatus") {
        $dipID = $_POST['id'] ?? '';
        if (!$dipID) {
            echo json_encode(["error" => "Diploma ID required"]);
            exit;
        }

        // Get current status
        $stmt = $pdo->prepare("SELECT is_active FROM diploma WHERE id = ?");
        $stmt->execute([$dipID]);
        $currentStatus = $stmt->fetchColumn();

        if ($currentStatus === false) {
            echo json_encode(["error" => "Diploma not found"]);
            exit;
        }

        $newStatus = $currentStatus == 1 ? 0 : 1;

        $updateStmt = $pdo->prepare("UPDATE diploma SET is_active = ? WHERE id = ?");
        if ($updateStmt->execute([$newStatus, $dipID])) {
            echo json_encode(["Status" => "Success", "newStatus" => $newStatus]);
        } else {
            echo json_encode(["error" => "Failed to toggle status"]);
        }
        exit;
    }

    // Invalid action for POST
    echo json_encode(["error" => "Invalid action for POST"]);
    exit;

} elseif ($method === 'GET') {
    $action = $_GET['action'] ?? '';

    if (!$action) {
        echo json_encode(["error" => "Action not specified"]);
        exit;
    }

    // GET ALL DIPLOMAS
    if ($action === "getalldips") {
        $stmt = $pdo->prepare("SELECT * FROM diploma");
        $stmt->execute();
        $dips = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(["Status" => "Success", "Result" => $dips]);
        exit;
    }

    echo json_encode(["error" => "Invalid action for GET"]);
    exit;
} else {
    echo json_encode(["error" => "Invalid request method"]);
    exit;
}
?>
