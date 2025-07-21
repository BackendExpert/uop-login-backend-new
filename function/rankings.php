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

    if ($_POST['action'] === "createRankings") {
        $year = $_POST['year'] ?? date('Y');

        // Check for duplicate year
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM rankings WHERE year = ?");
        $checkStmt->execute([$year]);
        $count = $checkStmt->fetchColumn();

        if ($count > 0) {
            echo json_encode(["error" => "Duplicate entry"]);
            exit;
        }

        // Ranking systems
        $rankingSystems = ['theur', 'their', 'usnw', 'qsur', 'wrwu', 'uig'];

        $columns = ['year'];
        $placeholders = ['?'];
        $values = [$year];

        foreach ($rankingSystems as $system) {
            foreach (['islandrank', 'asianrank', 'worldrank'] as $rankType) {
                $key = "{$system}_{$rankType}";
                $columns[] = $key;
                $placeholders[] = '?';
                $values[] = $_POST[$key] ?? '';
            }
        }

        $sql = "INSERT INTO rankings (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute($values)) {
            echo json_encode(["Status" => "Success"]);
        } else {
            $errorInfo = $stmt->errorInfo();
            echo json_encode(["error" => "Internal Server Error while creating record", "details" => $errorInfo]);
        }
    }

    if ($_POST['action'] === "updateRankings") {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            echo json_encode(["error" => "ID is required"]);
            exit;
        }

        $fields = ['year'];
        $params = [];

        $rankingSystems = ['theur', 'their', 'usnw', 'qsur', 'wrwu', 'uig'];

        foreach ($rankingSystems as $system) {
            foreach (['islandrank', 'asianrank', 'worldrank'] as $rankType) {
                $key = "{$system}_{$rankType}";
                if (isset($_POST[$key])) {
                    $fields[] = "$key = ?";
                    $params[] = $_POST[$key];
                }
            }
        }

        if (isset($_POST['year'])) {
            $params[] = $_POST['year'];
        }

        if (empty($fields)) {
            echo json_encode(["error" => "At least one field is required to update"]);
            exit;
        }

        $query = "UPDATE rankings SET " . implode(', ', $fields) . " WHERE id = ?";
        $params[] = $id;

        $stmt = $pdo->prepare($query);

        if ($stmt->execute($params)) {
            echo json_encode(["Status" => "Success"]);
        } else {
            $errorInfo = $stmt->errorInfo();
            echo json_encode(["error" => "Failed to update record", "details" => $errorInfo]);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['action'])) {
        echo json_encode(["error" => "Action not specified"]);
        exit;
    }

    if ($_GET['action'] === "getallrankings") {
        $stmt = $pdo->prepare("SELECT * FROM rankings ORDER BY id DESC");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode(["Status" => "Success", "Result" => $result]);
        } else {
            echo json_encode(["Status" => "Error", "Result" => []]);
        }
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
