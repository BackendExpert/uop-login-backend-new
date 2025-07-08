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

    // =====================
    // CREATE RESEARCH
    // =====================
    if ($_POST['action'] === "createResearch") {
        $resName = $_POST['resName'] ?? '';
        $resDesc = $_POST['resDesc'] ?? '';
        $resLink = $_POST['resLink'] ?? '';
        $resFaculty = $_POST['resFaculty'] ?? '';
        $resAddby = $_POST['resAddby'] ?? '';

        $target_file = "";
        if (!empty($_FILES['resImg']['name'])) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . basename($_FILES["resImg"]["name"]);
            if (!move_uploaded_file($_FILES["resImg"]["tmp_name"], $target_file)) {
                echo json_encode(["error" => "Image upload failed"]);
                exit;
            }
        }

        $stmt = $pdo->prepare("INSERT INTO research(res_titile, res_desc, res_link, res_img, res_faculty, is_accepted, addby)
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$resName, $resDesc, $resLink, $target_file, $resFaculty, 0, $resAddby])) {
            echo json_encode(["Status" => "Success"]);
        } else {
            echo json_encode(["error" => "Internal Server Error", "details" => $stmt->errorInfo()]);
        }
        exit;
    }

    // =====================
    // CREATE RESEARCH HEIGHTLIGHT
    // =====================
    if ($_POST['action'] === "createResearchHeightlight") {
        $year = $_POST['year'] ?? null;
        if (!$year) {
            echo json_encode(["error" => "Year is required"]);
            exit;
        }

        $column_title = $_POST['column_title'] ?? null;
        $data_column = $_POST['data_column'] ?? null;
        $is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;

        if (!$column_title || !$data_column) {
            echo json_encode(["error" => "column_title and data_column are required"]);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO research_heightlight (
            column_title, data_column, year, is_active
        ) VALUES (?, ?, ?, ?)");

        if ($stmt->execute([
            $column_title, $data_column, $year, $is_active
        ])) {
            echo json_encode(["Status" => "Success"]);
        } else {
            echo json_encode(["error" => "Failed to create research heightlight", "details" => $stmt->errorInfo()]);
        }
        exit;
    }


    // =====================
    // UPDATE RESEARCH HEIGHTLIGHT
    // =====================
    if ($_POST['action'] === "updateResearchHeightlight") {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            echo json_encode(["error" => "ID is required"]);
            exit;
        }

        $column_title = $_POST['column_title'] ?? null;
        $data_column = $_POST['data_column'] ?? null;
        $year = $_POST['year'] ?? null;
        $is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;

        if (!$column_title || !$data_column || !$year) {
            echo json_encode(["error" => "column_title, data_column, and year are required"]);
            exit;
        }

        $stmt = $pdo->prepare("UPDATE research_heightlight SET 
            column_title=?, data_column=?, year=?, is_active=?
            WHERE id=?");

        if ($stmt->execute([
            $column_title, $data_column, $year, $is_active, $id
        ])) {
            echo json_encode(["Status" => "Success"]);
        } else {
            echo json_encode(["error" => "Failed to update research heightlight", "details" => $stmt->errorInfo()]);
        }
        exit;
    }


    // =====================
    // UPDATE RESEARCH
    // =====================
    if ($_POST['action'] === "updateResearch") {
        if (empty($_POST['resName']) && empty($_POST['resDesc']) && empty($_POST['resLink']) && empty($_POST['resFaculty']) && empty($_FILES['resImg']['name'])) {
            echo json_encode(["error" => "At least one field is required to update"]);
            exit;
        }
        $resID = $_POST['ResID'];

        $resName = $_POST['resName'] ?? '';
        $resDesc = $_POST['resDesc'] ?? '';
        $resLink = $_POST['resLink'] ?? '';
        $resFaculty = $_POST['resFaculty'] ?? '';

        $target_file = "";
        if (!empty($_FILES['resImg']['name'])) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_file = $target_dir . basename($_FILES["resImg"]["name"]);
            if (!move_uploaded_file($_FILES["resImg"]["tmp_name"], $target_file)) {
                echo json_encode(["error" => "Image upload failed"]);
                exit;
            }
        }

        $updateQuery = "UPDATE research SET ";
        $params = [];

        if ($resName) {
            $updateQuery .= "res_titile = ?, ";
            $params[] = $resName;
        }
        if ($resDesc) {
            $updateQuery .= "res_desc = ?, ";
            $params[] = $resDesc;
        }
        if ($resLink) {
            $updateQuery .= "res_link = ?, ";
            $params[] = $resLink;
        }
        if ($resFaculty) {
            $updateQuery .= "res_faculty = ?, ";
            $params[] = $resFaculty;
        }
        if ($target_file) {
            $updateQuery .= "res_img = ?, ";
            $params[] = $target_file;
        }

        $updateQuery = rtrim($updateQuery, ', ') . " WHERE research_id = ?";
        $params[] = $resID;

        $stmt = $pdo->prepare($updateQuery);

        if ($stmt->execute($params)) {
            echo json_encode(["Status" => "Success"]);
        } else {
            echo json_encode(["error" => "Internal Server Error while updating"]);
        }
        exit;
    }

    // =====================
    // DELETE RESEARCH
    // =====================
    if ($_POST['action'] === "deleteres") {
        $imgId = $_POST['Imgeid'] ?? '';
        $stmt = $pdo->prepare("SELECT * FROM research WHERE research_id = ?");
        $stmt->execute([$imgId]);
        $image = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$image) {
            echo json_encode(["error" => "Not found"]);
            exit;
        }

        if (!empty($image['img']) && file_exists($image['img'])) {
            unlink($image['img']);
        }

        $deleteStmt = $pdo->prepare("DELETE FROM research WHERE research_id = ?");
        if ($deleteStmt->execute([$imgId])) {
            echo json_encode(["Status" => "Success"]);
        } else {
            echo json_encode(["error" => "Failed to delete"]);
        }
        exit;
    }

    // =====================
    // ACCEPT OR REFUSE RESEARCH
    // =====================
    if ($_POST['action'] === "acceptorrefusereseach") {
        $newsID = $_POST['resID'] ?? '';
        $stmt = $pdo->prepare("SELECT * FROM research WHERE research_id = ?");
        $stmt->execute([$newsID]);
        $news = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$news) {
            echo json_encode(["error" => "Not found"]);
            exit;
        }

        $newStatus = ((int)$news['is_accepted'] === 1) ? 0 : 1;
        $updateStmt = $pdo->prepare("UPDATE research SET is_accepted = ? WHERE research_id = ?");
        $updateStmt->execute([$newStatus, $newsID]);

        echo json_encode(["Status" => "Success", "newStatus" => $newStatus]);
        exit;
    }
}

// =====================
// GET requests
// =====================
elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['action'])) {
        echo json_encode(["error" => "Action not specified"]);
        exit;
    }

    if ($_GET['action'] === "getResearch") {
        $stmt = $pdo->prepare("SELECT * FROM research");
        $stmt->execute();
        echo json_encode(["Status" => "Success", "Result" => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
        exit;
    }

    if ($_GET['action'] === "getResearchHeightlight") {
        $stmt = $pdo->prepare("SELECT * FROM research_heightlight ORDER BY year DESC");
        $stmt->execute();
        echo json_encode(["Status" => "Success", "Result" => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
        exit;
    }

    if ($_GET['action'] === "getResearchHeightlightById") {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo json_encode(["error" => "ID required"]);
            exit;
        }
        $stmt = $pdo->prepare("SELECT * FROM research_heightlight WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            echo json_encode(["Status" => "Success", "Result" => $data]);
        } else {
            echo json_encode(["error" => "Not found"]);
        }
        exit;
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
