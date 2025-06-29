<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET");
header("Content-Type: application/json");

include "../config.php";

ini_set('display_errors', 1);
error_reporting(E_ALL);

// --------------------
// POST requests
// --------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['action'])) {
        echo json_encode(["error" => "Action not specified"]);
        exit;
    }

    // --------------------
    // CREATE NEW STATISTIC
    // --------------------
    if ($_POST['action'] === "createStatistic") {
        $title = $_POST['title'] ?? '';
        $countData = $_POST['countData'] ?? '';

        if (empty($title) || empty($countData)) {
            echo json_encode(["error" => "Title and countData are required"]);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO statistics (title, countData, visibale) VALUES (?, ?, 0)");
        if ($stmt->execute([$title, $countData])) {
            echo json_encode(["Status" => "Success"]);
        } else {
            echo json_encode(["error" => "Failed to insert statistic", "details" => $stmt->errorInfo()]);
        }
        exit;
    }

    // --------------------
    // UPDATE STATISTIC
    // --------------------
    if ($_POST['action'] === "updateStatistic") {
        $id = $_POST['id'] ?? null;
        $title = $_POST['title'] ?? '';
        $countData = $_POST['countData'] ?? '';
        $visibale = isset($_POST['visibale']) ? (int)$_POST['visibale'] : 0;

        if (!$id || empty($title) || empty($countData)) {
            echo json_encode(["error" => "ID, title, and countData are required"]);
            exit;
        }

        $stmt = $pdo->prepare("UPDATE statistics SET title = ?, countData = ?, visibale = ? WHERE id = ?");
        if ($stmt->execute([$title, $countData, $visibale, $id])) {
            echo json_encode(["Status" => "Success"]);
        } else {
            echo json_encode(["error" => "Failed to update statistic", "details" => $stmt->errorInfo()]);
        }
        exit;
    }

    // --------------------
    // TOGGLE VISIBLE
    // --------------------
    if ($_POST['action'] === "toggleStatisticVisible") {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            echo json_encode(["error" => "ID is required"]);
            exit;
        }

        // Get current visibility
        $stmt = $pdo->prepare("SELECT visibale FROM statistics WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            echo json_encode(["error" => "Statistic not found"]);
            exit;
        }

        $newVisibale = ((int)$data['visibale'] === 1) ? 0 : 1;

        // Update visibility
        $updateStmt = $pdo->prepare("UPDATE statistics SET visibale = ? WHERE id = ?");
        if ($updateStmt->execute([$newVisibale, $id])) {
            echo json_encode(["Status" => "Success", "newVisibale" => $newVisibale]);
        } else {
            echo json_encode(["error" => "Failed to update visibility", "details" => $updateStmt->errorInfo()]);
        }
        exit;
    }
}

// --------------------
// GET requests
// --------------------
elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['action'])) {
        echo json_encode(["error" => "Action not specified"]);
        exit;
    }

    // --------------------
    // GET ALL STATISTICS
    // --------------------
    if ($_GET['action'] === "getStatistics") {
        $stmt = $pdo->prepare("SELECT * FROM statistics ORDER BY id DESC");
        if ($stmt->execute()) {
            echo json_encode(["Status" => "Success", "Result" => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
        } else {
            echo json_encode(["error" => "Failed to fetch statistics", "details" => $stmt->errorInfo()]);
        }
        exit;
    }

    // --------------------
    // GET STATISTIC BY ID
    // --------------------
    if ($_GET['action'] === "getStatisticById") {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo json_encode(["error" => "ID is required"]);
            exit;
        }

        $stmt = $pdo->prepare("SELECT * FROM statistics WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            echo json_encode(["Status" => "Success", "Result" => $data]);
        } else {
            echo json_encode(["error" => "Statistic not found"]);
        }
        exit;
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
