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
        $island = $_POST['island'] ?? '';
        $asian = $_POST['asian'] ?? '';
        $world = $_POST['world'] ?? '';
        $year = $_POST['year'] ?? date('Y');
        $theur = $_POST['theur'] ?? '';
        $their = $_POST['their'] ?? '';
        $usnw = $_POST['usnw'] ?? '';
        $qsur = $_POST['qsur'] ?? '';
        $wrwu = $_POST['wrwu'] ?? '';
        $uig = $_POST['uig'] ?? '';
        
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM rankings WHERE year = ?");
        $checkStmt->execute([$year]);
        $count = $checkStmt->fetchColumn();

        if ($count > 0) {
            echo json_encode(["error" => "Duplicate entry"]);
            exit;
        }


        $stmt = $pdo->prepare("INSERT INTO rankings (island, asian, world, year, theur, their, usnw, qsur, wrwu, uig) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt->execute([$island, $asian, $world, $year, $theur, $their, $usnw, $qsur, $wrwu, $uig])) {
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

        $fields = ['island', 'asian', 'world', 'year', 'theur', 'their', 'usnw', 'qsur', 'wrwu', 'uig'];
        $setParts = [];
        $params = [];

        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $setParts[] = "$field = ?";
                $params[] = $_POST[$field];
            }
        }

        if (empty($setParts)) {
            echo json_encode(["error" => "At least one field is required to update"]);
            exit;
        }

        $query = "UPDATE rankings SET " . implode(', ', $setParts) . " WHERE id = ?";
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
