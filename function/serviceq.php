<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET");
header("Content-Type: application/json");

include "../config.php";

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['action'])) {
        echo json_encode(["error" => "Action not specified"]);
        exit;
    }

    if ($_POST['action'] === "createService") {
        // Pull and sanitize
        $Name         = trim($_POST['name'] ?? '');
        $Link         = trim($_POST['link'] ?? '');
        $MainType     = trim($_POST['main_type'] ?? '');
        $ServiceType  = trim($_POST['service_type'] ?? '');

        // Basic validation
        if ($Name === '' || $Link === '' || $MainType === '') {
            echo json_encode([
                "error" => "All fields are required: name, link, main_type, service_type"
            ]);
            exit;
        }

        // Check for duplicate name
        $checkStmt = $pdo->prepare(
            "SELECT COUNT(*) FROM servicequicklink WHERE name = ?"
        );
        $checkStmt->execute([$Name]);
        $count = $checkStmt->fetchColumn();

        if ($count > 0) {
            echo json_encode(["error" => "Name already exists"]);
            exit;
        }

        // Insert including main_type and services_type
        $insertStmt = $pdo->prepare(
            "INSERT INTO servicequicklink
            (name, link, main_type, services_type)
         VALUES
            (?,      ?,    ?,         ?)"
        );

        if ($insertStmt->execute([
            $Name,
            $Link,
            $MainType,
            $ServiceType
        ])) {
            echo json_encode(["Status" => "Success"]);
        } else {
            $errorInfo = $insertStmt->errorInfo();
            echo json_encode([
                "error"   => "Internal Server Error while creating service quicklink",
                "details" => $errorInfo
            ]);
        }
    }

    if ($_POST['action'] === "toggleStatus") {
        $SQid = $_POST['SQID'] ?? '';

        if (empty($SQid)) {
            echo json_encode(["error" => "ID not specified"]);
            exit;
        }

        // Fetch current status
        $stmt = $pdo->prepare("SELECT is_active FROM servicequicklink WHERE id = ?");
        $stmt->execute([$SQid]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            echo json_encode(["error" => "Service Quick Link not found"]);
            exit;
        }

        $currentStatus = $result['is_active'];
        $newStatus = $currentStatus == 1 ? 0 : 1;

        // Update status
        $update = $pdo->prepare("UPDATE servicequicklink SET is_active = ? WHERE id = ?");
        if ($update->execute([$newStatus, $SQid])) {
            echo json_encode([
                "Status" => "Success",
                "newStatus" => $newStatus
            ]);
        } else {
            echo json_encode([
                "error" => "Failed to toggle status"
            ]);
        }
    }


    // if ($_POST['action'] === "updateCertificate") {
    //     $dipID = $_POST['Dipid'] ?? '';

    //     if (empty($dipID) || $dipID === 'undefined') {
    //         echo json_encode(["error" => "Invalid or missing certificate ID"]);
    //         exit;
    //     }

    //     $Desc = $_POST['description'] ?? '';
    //     $Link = $_POST['link'] ?? '';
    //     $target_file = "";

    //     if (!empty($_FILES['image']['name'])) {
    //         $target_dir = "uploads/";
    //         if (!is_dir($target_dir)) {
    //             mkdir($target_dir, 0777, true);
    //         }
    //         $target_file = $target_dir . basename($_FILES["image"]["name"]);
    //         if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    //             echo json_encode(["error" => "Image upload failed"]);
    //             exit;
    //         }
    //     }

    //     // No valid fields to update
    //     if (empty($Desc) && empty($Link) && empty($target_file)) {
    //         echo json_encode(["error" => "At least one field is required to update"]);
    //         exit;
    //     }

    //     $updateQuery = "UPDATE cirtificate SET ";
    //     $params = [];

    //     if (!empty($Desc)) {
    //         $updateQuery .= "description = ?, ";
    //         $params[] = $Desc;
    //     }

    //     if (!empty($Link)) {
    //         $updateQuery .= "link = ?, ";
    //         $params[] = $Link;
    //     }

    //     if (!empty($target_file)) {
    //         $updateQuery .= "image = ?, ";
    //         $params[] = $target_file;
    //     }

    //     $updateQuery = rtrim($updateQuery, ', ') . " WHERE id = ?";
    //     $params[] = $dipID;

    //     $stmt = $pdo->prepare($updateQuery);

    //     if ($stmt->execute($params)) {
    //         echo json_encode(["Status" => "Success"]);
    //     } else {
    //         $errorInfo = $stmt->errorInfo();
    //         echo json_encode(["error" => "Internal Server Error while updating event", "details" => $errorInfo]);
    //     }
    // }


    if ($_POST['action'] === "deleteSQ") {
        $SQid = $_POST['SQID'] ?? '';

        $stmt = $pdo->prepare("SELECT * FROM servicequicklink WHERE id = ?");
        $stmt->execute([$SQid]);
        $image = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$image) {
            echo json_encode(["error" => "Society not found"]);
            exit;
        }

        $deleteStmt = $pdo->prepare("DELETE FROM servicequicklink WHERE id = ?");
        if ($deleteStmt->execute([$SQid])) {
            echo json_encode(["Status" => "Success"]);
        } else {
            echo json_encode(["error" => "Failed to delete image from database"]);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['action'])) {
        echo json_encode(["error" => "Action not specified"]);
        exit;
    }

    if ($_GET['action'] === "getallsq") {
        $getstmt = $pdo->prepare("SELECT * FROM servicequicklink");
        $getstmt->execute();
        $sq = $getstmt->fetchAll(PDO::FETCH_ASSOC);

        if ($sq) {
            echo json_encode(["Status" => "Success", "Result" => $sq]);
        } else {
            echo json_encode(["Status" => "Error", "Result" => []]);
        }
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
