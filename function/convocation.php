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

    if ($_POST['action'] === "createconvocation") {
        $year = $_POST['year'] ?? date('Y');
        $vsmsg = $_POST['vc_message'] ?? '';
        $vs_title_name = $_POST['vs_title_name'] ?? '';

        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file1 = "";
        $target_file2 = "";
        $target_file3 = "";

        if (!empty($_FILES['vc_img']['name'])) {
            $filename1 = basename($_FILES["vc_img"]["name"]);
            $upload_path1 = $target_dir . $filename1;
            if (!move_uploaded_file($_FILES["vc_img"]["tmp_name"], $upload_path1)) {
                echo json_encode(["error" => "Image 1 upload failed"]);
                exit;
            }
            $target_file1 = $upload_path1;
        }

        if (!empty($_FILES['notice_Graduands']['name'])) {
            $filename2 = basename($_FILES["notice_Graduands"]["name"]);
            $upload_path2 = $target_dir . $filename2;
            if (!move_uploaded_file($_FILES["notice_Graduands"]["tmp_name"], $upload_path2)) {
                echo json_encode(["error" => "Image 2 upload failed"]);
                exit;
            }
            $target_file2 = $upload_path2;
        }

        if (!empty($_FILES['Convocation_schedule']['name'])) {
            $filename3 = basename($_FILES["Convocation_schedule"]["name"]);
            $upload_path3 = $target_dir . $filename3;
            if (!move_uploaded_file($_FILES["Convocation_schedule"]["tmp_name"], $upload_path3)) {
                echo json_encode(["error" => "Image 3 upload failed"]);
                exit;
            }
            $target_file3 = $upload_path3;
        }

        // Check for duplicate year
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM convocation_tbl WHERE year = ?");
        $checkStmt->execute([$year]);
        $count = $checkStmt->fetchColumn();

        if ($count > 0) {
            echo json_encode(["error" => "Duplicate entry"]);
            exit;
        }

        // Insert record
        $stmt = $pdo->prepare("INSERT INTO convocation_tbl (year, vc_message, vc_img, vs_title_name, notice_Graduands, Convocation_schedule)
                               VALUES (?, ?, ?, ?, ?, ?)");
        $values = [$year, $vsmsg, $target_file1, $vs_title_name, $target_file2, $target_file3];

        if ($stmt->execute($values)) {
            echo json_encode(["Status" => "Success"]);
        } else {
            $errorInfo = $stmt->errorInfo();
            echo json_encode(["error" => "Internal Server Error while creating record", "details" => $errorInfo]);
        }
    }

    if ($_POST['action'] === "updateconvocation") {
        $id = $_POST['id'] ?? null;
        if (!$id) {
            echo json_encode(["error" => "ID is required"]);
            exit;
        }

        $year = $_POST['year'] ?? '';
        $vc_message = $_POST['vc_message'] ?? '';
        $vs_title_name = $_POST['vs_title_name'] ?? '';

        $stmt = $pdo->prepare("UPDATE convocation_tbl SET year = ?, vc_message = ?, vs_title_name = ? WHERE id = ?");
        if ($stmt->execute([$year, $vc_message, $vs_title_name, $id])) {
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

    if ($_GET['action'] === "getallconvocation") {
        $stmt = $pdo->prepare("SELECT * FROM convocation_tbl ORDER BY id DESC");
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
