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
    
    if ($_POST['action'] === "createVideo") {
        $Title = $_POST['title'] ?? '';
        $CloseDate = $_POST['vidoe_url'] ?? '';

        $stmt = $pdo->prepare("INSERT INTO video(title, video_url)
        VALUES (?, ?)");

        if ($stmt->execute([$Title, $notice_file_path, $application_file_path, $CloseDate])) {
            echo json_encode(["Status" => "Success"]);
        } else {
            $errorInfo = $stmt->errorInfo();
            echo json_encode(["error" => "Internal Server Error while Creating Vacancies", "details" => $errorInfo]);
        }
    }

    if ($_POST['action'] === "updateVacancy") {
        $vacancyID = $_POST['id'] ?? null;

        if (!$vacancyID) {
            echo json_encode(["error" => "Vacancy ID is required"]);
            exit;
        }

        // Check at least one field or file is set for update
        if (empty($_POST['title']) && empty($_POST['vidoe_url'])) {
            echo json_encode(["error" => "At least one field or file is required to update"]);
            exit;
        }

        $title = $_POST['title'] ?? '';
        $closingdate = $_POST['vidoe_url'] ?? '';

        $updateQuery = "UPDATE video SET ";
        $params = [];

        if ($title) {
            $updateQuery .= "title = ?, ";
            $params[] = $title;
        }

        if ($target_notice_file) {
            $updateQuery .= "video_url = ?, ";
            $params[] = $target_notice_file;
        }

        $updateQuery = rtrim($updateQuery, ', ') . " WHERE id = ?";
        $params[] = $vacancyID;

        $stmt = $pdo->prepare($updateQuery);

        if ($stmt->execute($params)) {
            echo json_encode(["Status" => "Success"]);
        } else {
            $errorInfo = $stmt->errorInfo();
            echo json_encode([
                "error" => "Failed to update vacancy",
                "sql_error" => $errorInfo
            ]);
        }
    }

}

// Handle GET requests
elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['action'])) {
        echo json_encode(["error" => "Action not specified"]);
        exit;
    }

    if ($_GET['action'] === "getallvideos") {
        $getstmt = $pdo->prepare("SELECT * FROM video");
        $getstmt->execute();
        $vacancies = $getstmt->fetchAll(PDO::FETCH_ASSOC);

        if ($vacancies) {
            echo json_encode(["Status" => "Success", "Result" => $vacancies]);
        } else {
            echo json_encode(["Status" => "Error", "Result" => []]);
        }
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
