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

        if ($_POST['action'] === "createPImge") {
            $ptitle = $_POST['ptitle'] ?? '';
            $pdesc = $_POST['pdesc'] ?? '';
            $plink = $_POST['plink'] ?? '';
            $paddby = $_POST['paddby'] ?? '';

            $target_file = "";
            if (!empty($_FILES['pimg']['name'])) {
                $target_dir = "uploads/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $target_file = $target_dir . basename($_FILES["pimg"]["name"]);
                if (!move_uploaded_file($_FILES["pimg"]["tmp_name"], $target_file)) {
                    echo json_encode(["error" => "Image upload failed"]);
                    exit;
                }
            }

            $imgstmt = $pdo->prepare("INSERT INTO program_slider(title, pdesc, img, link, addby, is_accepted)
            VALUES (?, ?, ?, ?, ?, ?)");

            if ($imgstmt->execute([$ptitle, $pdesc, $target_file, $plink, $paddby, 0])) {
                echo json_encode(["Status" => "Success"]);
            } else {
                $errorInfo = $eventstmt->errorInfo();
                echo json_encode(["error" => "Internal Server Error while Creating Events", "details" => $errorInfo]);
            }

        }

        if ($_POST['action'] === "deleteimg") {
            $imgId = $_POST['Imgeid'] ?? '';

            $stmt = $pdo->prepare("SELECT img FROM program_slider WHERE id = ?");
            $stmt->execute([$imgId]);
            $image = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$image) {
                echo json_encode(["error" => "Image not found"]);
                exit;
            }

            if (!empty($image['img']) && file_exists($image['img'])) {
                unlink($image['img']); 
            }

            $deleteStmt = $pdo->prepare("DELETE FROM program_slider WHERE id = ?");
            if ($deleteStmt->execute([$imgId])) {
                echo json_encode(["Status" => "Success"]);
            } else {
                echo json_encode(["error" => "Failed to delete image from database"]);
            }
        }

        if ($_POST['action'] === "updatepImge") {
            if (empty($_POST['title']) && empty($_POST['desc']) && empty($_POST['link']) && empty($_FILES['img']['name'])) {
                echo json_encode(["error" => "At least one field is required to update"]);
                exit;
            }
            $Himge = $_POST['pImgeID'];

            $newsName = $_POST['title'] ?? '';
            $newsDesc = $_POST['desc'] ?? '';
            $newsLink = $_POST['link'] ?? '';

            $target_file = "";
            if (!empty($_FILES['img']['name'])) {
                $target_dir = "uploads/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $target_file = $target_dir . basename($_FILES["img"]["name"]);
                if (!move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                    echo json_encode(["error" => "Image upload failed"]);
                    exit;
                }
            }

            $updateQuery = "UPDATE program_slider SET ";
            $params = [];
        

            if ($newsName) {
                $updateQuery .= "title = ?, ";
                $params[] = $newsName;
            }
        
            if ($newsDesc) {
                $updateQuery .= "pdesc = ?, ";
                $params[] = $newsDesc;
            }
        
            if ($newsLink) {
                $updateQuery .= "link = ?, ";
                $params[] = $newsLink;
            }
        
       
            if ($target_file) {
                $updateQuery .= "img = ?, ";
                $params[] = $target_file;
            }

            $updateQuery = rtrim($updateQuery, ', ') . " WHERE id = ?";
            $params[] = $Himge; 

            $stmt = $pdo->prepare($updateQuery);

            if($stmt->execute($params)){
                echo json_encode(["Status" => "Success"]);
            }
            else{
                echo json_encode(["error" => "Internal Server Error while updating event"]);
            }
        }
        
        if ($_POST['action'] === "acceptorrefuse") {
            $newsID = $_POST['ProID'] ?? '';

            $stmt = $pdo->prepare("SELECT * FROM program_slider WHERE id = ?");
            $stmt->execute([$newsID]);
            $news = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$news) {
                echo json_encode(["error" => "News not found"]);
                exit;
            }

            $newStatus = ((int)$news['is_accepted'] === 1) ? 0 : 1;

            $updateStmt = $pdo->prepare("UPDATE program_slider SET is_accepted = ? WHERE id = ?");
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

        if ($_GET['action'] === "getallImages") {
            $getstmt = $pdo->prepare("SELECT * FROM program_slider");
            $getstmt->execute();
            $imges = $getstmt->fetchAll(PDO::FETCH_ASSOC);

            if ($imges) {
                echo json_encode(["Status" => "Success", "Result" => $imges]);
            } else {
                echo json_encode(["Status" => "Error", "Result" => []]);
            }
        }
    } else {
        echo json_encode(["error" => "Invalid request method"]);
    }
?>
