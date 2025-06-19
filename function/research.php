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

        $newststmt = $pdo->prepare("INSERT INTO research(res_titile, res_desc, res_link, res_img, res_faculty, is_accepted, addby)
            VALUES (?, ?, ?, ?, ?, ?, ?)");

        if ($newststmt->execute([$resName, $resDesc, $resLink, $target_file, $resFaculty, 0, $resAddby])) {
            echo json_encode(["Status" => "Success"]);
        } else {
            $errorInfo = $newststmt->errorInfo();
            echo json_encode(["error" => "Internal Server Error while Creating NEWS", "details" => $errorInfo]);
        }
    }

    if ($_POST['action'] === "createResearchStats") {
        $year = $_POST['year'] ?? null;
        if (!$year) {
            echo json_encode(["error" => "Year is required"]);
            exit;
        }

        // Collect and sanitize optional numeric fields
        $research_journals = !empty($_POST['research_journals']) ? (int)$_POST['research_journals'] : 0;
        $research_publications = !empty($_POST['research_publications']) ? (int)$_POST['research_publications'] : 0;
        $citations = !empty($_POST['citations']) ? (int)$_POST['citations'] : 0;
        $research_ranking = !empty($_POST['research_ranking']) ? (int)$_POST['research_ranking'] : 0;
        $number_of_researchers_top2_percent = !empty($_POST['number_of_researchers_top2_percent']) ? (int)$_POST['number_of_researchers_top2_percent'] : 0;
        $annual_research_conferences = !empty($_POST['annual_research_conferences']) ? (int)$_POST['annual_research_conferences'] : 0;
        $annual_research_collaborations = !empty($_POST['annual_research_collaborations']) ? (int)$_POST['annual_research_collaborations'] : 0;
        $research_awards_and_recognitions = !empty($_POST['research_awards_and_recognitions']) ? (int)$_POST['research_awards_and_recognitions'] : 0;
        $annual_workshops_seminars = !empty($_POST['annual_workshops_seminars']) ? (int)$_POST['annual_workshops_seminars'] : 0;
        $capital_grants_for_research = !empty($_POST['capital_grants_for_research']) ? (float)$_POST['capital_grants_for_research'] : 0;

        $stmt = $pdo->prepare("INSERT INTO research_stats (
                year,
                research_journals,
                research_publications,
                citations,
                research_ranking,
                number_of_researchers_top2_percent,
                annual_research_conferences,
                annual_research_collaborations,
                research_awards_and_recognitions,
                annual_workshops_seminars,
                capital_grants_for_research
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $executed = $stmt->execute([
            $year,
            $research_journals,
            $research_publications,
            $citations,
            $research_ranking,
            $number_of_researchers_top2_percent,
            $annual_research_conferences,
            $annual_research_collaborations,
            $research_awards_and_recognitions,
            $annual_workshops_seminars,
            $capital_grants_for_research
        ]);

        if ($executed) {
            echo json_encode(["Status" => "Success"]);
        } else {
            $errorInfo = $stmt->errorInfo();
            echo json_encode(["error" => "Failed to create research stats", "details" => $errorInfo]);
        }
        exit;
    }

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
            echo json_encode(["error" => "Internal Server Error while updating event"]);
        }
    }

    if ($_POST['action'] === "deleteres") {
        $imgId = $_POST['Imgeid'] ?? '';

        $stmt = $pdo->prepare("SELECT * FROM research WHERE research_id = ?");
        $stmt->execute([$imgId]);
        $image = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$image) {
            echo json_encode(["error" => "Image not found"]);
            exit;
        }

        if (!empty($image['img']) && file_exists($image['img'])) {
            unlink($image['img']);
        }

        $deleteStmt = $pdo->prepare("DELETE FROM research WHERE research_id = ?");
        if ($deleteStmt->execute([$imgId])) {
            echo json_encode(["Status" => "Success"]);
        } else {
            echo json_encode(["error" => "Failed to delete image from database"]);
        }
    }

    if ($_POST['action'] === "acceptorrefusereseach") {
        $newsID = $_POST['resID'] ?? '';

        $stmt = $pdo->prepare("SELECT * FROM research WHERE research_id = ?");
        $stmt->execute([$newsID]);
        $news = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$news) {
            echo json_encode(["error" => "notice not found"]);
            exit;
        }

        $newStatus = ((int)$news['is_accepted'] === 1) ? 0 : 1;

        $updateStmt = $pdo->prepare("UPDATE research SET is_accepted = ? WHERE research_id = ?");
        $updateStmt->execute([$newStatus, $newsID]);

        echo json_encode(["Status" => "Success", "newStatus" => $newStatus]);
    }
}

// Handle GET requests
elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['action'])) {
        echo json_encode(["error" => "Action not specified"]);
        exit;
    }

    if ($_GET['action'] === "getResearch") {
        $getstmt = $pdo->prepare("SELECT * FROM research");
        $getstmt->execute();
        $research = $getstmt->fetchAll(PDO::FETCH_ASSOC);

        if ($research) {
            echo json_encode(["Status" => "Success", "Result" => $research]);
        } else {
            echo json_encode(["Status" => "Error", "Result" => []]);
        }
    }

    if ($_GET['action'] === "getResearchStats") {
        $stmt = $pdo->prepare("SELECT * FROM research_stats ORDER BY year DESC");
        if ($stmt->execute()) {
            $stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(["Status" => "Success", "Result" => $stats]);
        } else {
            $errorInfo = $stmt->errorInfo();
            echo json_encode(["error" => "Failed to fetch research stats", "details" => $errorInfo]);
        }
        exit;
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
