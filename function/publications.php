<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET");
header("Content-Type: application/json");

include "../config.php";

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['action'])) {
        echo json_encode(["error" => "Action not specified"]);
        exit;
    }

    // Create a publication
    if ($_POST['action'] === "createPublication") {
        $pub_name = $_POST['pub_name'] ?? '';
        $desc = $_POST['desc'] ?? '';
        $year = $_POST['year'] ?? '';
        $pub_type = $_POST['pub_type'] ?? '';
        $upload_at = date('Y-m-d H:i:s');

        $target_file = '';
        if (!empty($_FILES['file']['name'])) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . time() . '_' . basename($_FILES['file']['name']);
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
                echo json_encode(["error" => "File upload failed"]);
                exit;
            }
        }

        $cover_image_path = '';
        if (!empty($_FILES['coverimge']['name'])) {
            $cover_dir = "uploads/";
            if (!is_dir($cover_dir)) {
                mkdir($cover_dir, 0777, true);
            }
            $cover_image_path = $cover_dir . time() . '_cover_' . basename($_FILES['coverimge']['name']);
            if (!move_uploaded_file($_FILES['coverimge']['tmp_name'], $cover_image_path)) {
                echo json_encode(["error" => "Cover image upload failed"]);
                exit;
            }
        }

        $stmt = $pdo->prepare("INSERT INTO publications(pub_name, `desc`, year, pub_type, file, upload_at, coverimge) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$pub_name, $desc, $year, $pub_type, $target_file, $upload_at, $cover_image_path])) {
            echo json_encode(["Status" => "Success"]);
        } else {
            echo json_encode(["error" => "Failed to insert publication"]);
        }
    }

    // Update a publication
    if ($_POST['action'] === "updatePublication") {
        $id = $_POST['id'] ?? '';
        if (!$id) {
            echo json_encode(["error" => "Publication ID required"]);
            exit;
        }

        $pub_name = $_POST['pub_name'] ?? '';
        $desc = $_POST['desc'] ?? '';
        $year = $_POST['year'] ?? '';
        $pub_type = $_POST['pub_type'] ?? '';

        $target_file = '';
        if (!empty($_FILES['file']['name'])) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . time() . '_' . basename($_FILES['file']['name']);
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
                echo json_encode(["error" => "File upload failed"]);
                exit;
            }
        }

        $cover_image_path = '';
        if (!empty($_FILES['coverimge']['name'])) {
            $cover_dir = "uploads/";
            if (!is_dir($cover_dir)) {
                mkdir($cover_dir, 0777, true);
            }
            $cover_image_path = $cover_dir . time() . '_cover_' . basename($_FILES['coverimge']['name']);
            if (!move_uploaded_file($_FILES['coverimge']['tmp_name'], $cover_image_path)) {
                echo json_encode(["error" => "Cover image upload failed"]);
                exit;
            }
        }

        $updateQuery = "UPDATE publications SET ";
        $params = [];
        $fields = [];

        if ($pub_name) {
            $fields[] = "pub_name = ?";
            $params[] = $pub_name;
        }
        if ($desc) {
            $fields[] = "`desc` = ?";
            $params[] = $desc;
        }
        if ($year) {
            $fields[] = "year = ?";
            $params[] = $year;
        }
        if ($pub_type) {
            $fields[] = "pub_type = ?";
            $params[] = $pub_type;
        }
        if ($target_file) {
            $fields[] = "file = ?";
            $params[] = $target_file;
        }
        if ($cover_image_path) {
            $fields[] = "coverimge = ?";
            $params[] = $cover_image_path;
        }

        if (count($fields) === 0) {
            echo json_encode(["error" => "No fields to update"]);
            exit;
        }

        $updateQuery .= implode(", ", $fields) . " WHERE id = ?";
        $params[] = $id;

        $stmt = $pdo->prepare($updateQuery);
        if ($stmt->execute($params)) {
            echo json_encode(["Status" => "Success"]);
        } else {
            echo json_encode(["error" => "Failed to update publication"]);
        }
    }

    // Delete a publication
    if ($_POST['action'] === "deletePublication") {
        $id = $_POST['id'] ?? '';
        if (!$id) {
            echo json_encode(["error" => "Publication ID required"]);
            exit;
        }

        $stmt = $pdo->prepare("SELECT file, coverimge FROM publications WHERE id = ?");
        $stmt->execute([$id]);
        $publication = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($publication) {
            if (!empty($publication['file']) && file_exists($publication['file'])) {
                unlink($publication['file']);
            }
            if (!empty($publication['coverimge']) && file_exists($publication['coverimge'])) {
                unlink($publication['coverimge']);
            }
        }

        $deleteStmt = $pdo->prepare("DELETE FROM publications WHERE id = ?");
        if ($deleteStmt->execute([$id])) {
            echo json_encode(["Status" => "Success"]);
        } else {
            echo json_encode(["error" => "Failed to delete publication"]);
        }
    }
}

// Handle GET request: get all publications
elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['action']) || $_GET['action'] !== "getPublications") {
        echo json_encode(["error" => "Invalid or missing action"]);
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM publications ORDER BY upload_at DESC");
    $stmt->execute();
    $publications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["Status" => "Success", "Result" => $publications]);
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
