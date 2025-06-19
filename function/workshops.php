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
    
    if ($_POST['action'] === "createWorkshopandShortCourse") {
        $wsname = $_POST['name'] ?? '';
        $wsdesc = $_POST['desc'] ?? '';
        $wslink = $_POST['link'] ?? '';
        $wsfuclty = $_POST['fuclty'] ?? '';       



        $stmt = $pdo->prepare("INSERT INTO workshops_shortcourse(course_name, course_desc, course_link, fuclty, is_active)
        VALUES (?, ?, ?, ?, ?)");

        if ($stmt->execute([$wsname, $wsdesc, $wslink, $wsfuclty, 1])) {
            echo json_encode(["Status" => "Success"]);
        } else {
            $errorInfo = $stmt->errorInfo();
            echo json_encode(["error" => "Internal Server Error while Creating workshops_shortcourse", "details" => $errorInfo]);
        }
    }


    if ($_POST['action'] === "updateVacancy") {
        $vacancyID = $_POST['id'] ?? null;

        if (!$vacancyID) {
            echo json_encode(["error" => "Vacancy ID is required"]);
            exit;
        }

        // Check at least one field or file is set for update
        if (empty($_POST['title']) && empty($_FILES['notice']['name']) && empty($_POST['closingdate']) && empty($_FILES['application']['name'])) {
            echo json_encode(["error" => "At least one field or file is required to update"]);
            exit;
        }

        $title = $_POST['title'] ?? '';
        $closingdate = $_POST['closingdate'] ?? '';

        $target_notice_file = "";
        if (!empty($_FILES['notice']['name'])) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_notice_file = $target_dir . basename($_FILES["notice"]["name"]);
            if (!move_uploaded_file($_FILES["notice"]["tmp_name"], $target_notice_file)) {
                echo json_encode(["error" => "Notice file upload failed"]);
                exit;
            }
        }

        $target_application_file = "";
        if (!empty($_FILES['application']['name'])) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $target_application_file = $target_dir . basename($_FILES["application"]["name"]);
            if (!move_uploaded_file($_FILES["application"]["tmp_name"], $target_application_file)) {
                echo json_encode(["error" => "Application file upload failed"]);
                exit;
            }
        }

        $updateQuery = "UPDATE vacancies SET ";
        $params = [];

        if ($title) {
            $updateQuery .= "title = ?, ";
            $params[] = $title;
        }

        if ($target_notice_file) {
            $updateQuery .= "notice = ?, ";
            $params[] = $target_notice_file;
        }

        if ($closingdate) {
            $updateQuery .= "closingdate = ?, ";
            $params[] = $closingdate;
        }

        if ($target_application_file) {
            $updateQuery .= "application = ?, ";
            $params[] = $target_application_file;
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

    if ($_POST['action'] === "deleteVacancy") {
        $vacancyID = $_POST['id'] ?? '';

        if (!$vacancyID) {
            echo json_encode(["error" => "Vacancy ID is required"]);
            exit;
        }

        // Get existing vacancy to delete associated files
        $stmt = $pdo->prepare("SELECT * FROM vacancies WHERE id = ?");
        $stmt->execute([$vacancyID]);
        $vacancy = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$vacancy) {
            echo json_encode(["error" => "Vacancy not found"]);
            exit;
        }

        if (!empty($vacancy['application']) && file_exists($vacancy['application'])) {
            unlink($vacancy['application']);
        }
        if (!empty($vacancy['notice']) && file_exists($vacancy['notice'])) {
            unlink($vacancy['notice']);
        }

        $deleteStmt = $pdo->prepare("DELETE FROM vacancies WHERE id = ?");
        if ($deleteStmt->execute([$vacancyID])) {
            echo json_encode(["Status" => "Success"]);
        } else {
            echo json_encode(["error" => "Failed to delete vacancy from database"]);
        }
    }
}

// Handle GET requests
elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['action'])) {
        echo json_encode(["error" => "Action not specified"]);
        exit;
    }

    if ($_GET['action'] === "getallworkshops") {
        $getstmt = $pdo->prepare("SELECT * FROM workshops_shortcourse");
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
