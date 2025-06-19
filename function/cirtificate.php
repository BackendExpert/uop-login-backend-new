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

        if ($_POST['action'] === "createcirtificate") {
            $Title = $_POST['title'] ?? '';
            $Desc = $_POST['decription'] ?? '';
            $Link = $_POST['link'] ?? '';

            $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM cirtificate WHERE title = ?");
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

            $eventstmt = $pdo->prepare(
                "INSERT INTO cirtificate(title, description, image, link)
                 VALUES (?, ?, ?, ?)"
            );

            if ($eventstmt->execute([$Title, $Desc, $target_file, $Link])) {
                echo json_encode(["Status" => "Success"]);
            } else {
                $errorInfo = $eventstmt->errorInfo();
                echo json_encode([
                    "error"   => "Internal Server Error while Creating Events",
                    "details" => $errorInfo
                ]);
            }
        }

        if ($_POST['action'] === "updateCertificate") {
            $dipID = $_POST['Dipid'] ?? '';
            if (empty($dipID) || $dipID === 'undefined') {
                echo json_encode(["error" => "Invalid or missing certificate ID"]);
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

            if (empty($Desc) && empty($Link) && empty($target_file)) {
                echo json_encode(["error" => "At least one field is required to update"]);
                exit;
            }

            $updateQuery = "UPDATE cirtificate SET ";
            $params = [];

            if (!empty($Desc)) {
                $updateQuery .= "description = ?, ";
                $params[] = $Desc;
            }
            if (!empty($Link)) {
                $updateQuery .= "link = ?, ";
                $params[] = $Link;
            }
            if (!empty($target_file)) {
                $updateQuery .= "image = ?, ";
                $params[] = $target_file;
            }

            $updateQuery = rtrim($updateQuery, ', ') . " WHERE id = ?";
            $params[] = $dipID;

            $stmt = $pdo->prepare($updateQuery);
            if ($stmt->execute($params)) {
                echo json_encode(["Status" => "Success"]);
            } else {
                $errorInfo = $stmt->errorInfo();
                echo json_encode([
                    "error"   => "Internal Server Error while updating event",
                    "details" => $errorInfo
                ]);
            }
        }

        // ▼ toggle via is_active column ▼
        if ($_POST['action'] === "toggleCertificateStatus") {
            $certID    = $_POST['id']     ?? '';
            $newStatus = $_POST['status'] ?? '';

            if (
                empty($certID) ||
                $certID === 'undefined' ||
                !in_array($newStatus, ['0','1'], true)
            ) {
                echo json_encode(["error" => "Invalid ID or status"]);
                exit;
            }

            $stmt = $pdo->prepare(
                "UPDATE cirtificate
                 SET is_active = ?
                 WHERE id = ?"
            );
            if ($stmt->execute([$newStatus, $certID])) {
                echo json_encode([
                    "Status"  => "Success",
                    "message" => "Status updated"
                ]);
            } else {
                $errorInfo = $stmt->errorInfo();
                echo json_encode([
                    "error"   => "Failed to update status",
                    "details" => $errorInfo
                ]);
            }
        }

    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (!isset($_GET['action'])) {
            echo json_encode(["error" => "Action not specified"]);
            exit;
        }

        if ($_GET['action'] === "getallcirtificate") {
            $getstmt = $pdo->prepare(
                "SELECT id, title, description, image, link, is_active
                 FROM cirtificate"
            );
            $getstmt->execute();
            $dips = $getstmt->fetchAll(PDO::FETCH_ASSOC);

            if ($dips) {
                echo json_encode([
                    "Status" => "Success",
                    "Result" => $dips
                ]);
            } else {
                echo json_encode([
                    "Status" => "Error",
                    "Result" => []
                ]);
            }
        }

    } else {
        echo json_encode(["error" => "Invalid request method"]);
    }
?>
