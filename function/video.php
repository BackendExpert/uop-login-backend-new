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
    
    if ($_POST['action'] === "createVideo") {
        $Title = $_POST['title'] ?? '';
        $VideoUrl = $_POST['vidoe_url'] ?? '';
        $ShortDesc = $_POST['short_desc'] ?? '';

        $stmt = $pdo->prepare("INSERT INTO videos(title, video_url, short_desc, add_date) VALUES (?, ?, ?, CURRENT_DATE)");

        if ($stmt->execute([$Title, $VideoUrl, $ShortDesc])) {
            echo json_encode(["Status" => "Success"]);
        } else {
            $errorInfo = $stmt->errorInfo();
            echo json_encode(["error" => "Internal Server Error while creating video", "details" => $errorInfo]);
        }
    }

    if ($_POST['action'] === "updateVideo") {
        $videoID = $_POST['id'] ?? null;

        if (!$videoID) {
            echo json_encode(["error" => "Video ID is required"]);
            exit;
        }

        if (empty($_POST['title']) && empty($_POST['vidoe_url']) && empty($_POST['short_desc'])) {
            echo json_encode(["error" => "At least one field is required to update"]);
            exit;
        }

        $title = $_POST['title'] ?? null;
        $videoUrl = $_POST['vidoe_url'] ?? null;
        $shortDesc = $_POST['short_desc'] ?? null;

        $updateQuery = "UPDATE videos SET ";
        $params = [];

        if ($title) {
            $updateQuery .= "title = ?, ";
            $params[] = $title;
        }
        if ($videoUrl) {
            $updateQuery .= "video_url = ?, ";
            $params[] = $videoUrl;
        }
        if ($shortDesc) {
            $updateQuery .= "short_desc = ?, ";
            $params[] = $shortDesc;
        }

        $updateQuery = rtrim($updateQuery, ', ') . " WHERE id = ?";
        $params[] = $videoID;

        $stmt = $pdo->prepare($updateQuery);

        if ($stmt->execute($params)) {
            echo json_encode(["Status" => "Success"]);
        } else {
            $errorInfo = $stmt->errorInfo();
            echo json_encode(["error" => "Failed to update video", "details" => $errorInfo]);
        }
    }
}

elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['action'])) {
        echo json_encode(["error" => "Action not specified"]);
        exit;
    }

    if ($_GET['action'] === "getallvideos") {
        $getstmt = $pdo->prepare("SELECT * FROM videos ORDER BY id DESC");
        $getstmt->execute();
        $videos = $getstmt->fetchAll(PDO::FETCH_ASSOC);

        if ($videos) {
            echo json_encode(["Status" => "Success", "Result" => $videos]);
        } else {
            echo json_encode(["Status" => "Error", "Result" => []]);
        }
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
