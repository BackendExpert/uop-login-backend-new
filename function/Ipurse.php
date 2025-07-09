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

        if ($_POST['action'] === "createIpurse") {
            $year = $_POST['year'] ?? '';
            $link = $_POST['link'] ?? '';            

            $target_file = "";
            if (!empty($_FILES['image']['name'])) {
                $target_dir = "uploads/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    echo json_encode(["error" => "Image upload failed"]);
                    exit;
                }
            }

            $eventstmt = $pdo->prepare("INSERT INTO ipurse_tbl(img, link, year)
            VALUES (?, ?, ?)");

            if ($eventstmt->execute([$target_file, $link, $year])) {
                echo json_encode(["Status" => "Success"]);
            } else {
                $errorInfo = $eventstmt->errorInfo();
                echo json_encode(["error" => "Internal Server Error while Creating ipurse", "details" => $errorInfo]);
            }
        }

        if ($_POST['action'] === "UpdateIpurse") {
            if (empty($_POST['eventName']) && empty($_POST['eventDesc']) && empty($_POST['eventLink']) && empty($_POST['eventDate']) && empty($_FILES['eventImg']['name'])) {
                echo json_encode(["error" => "At least one field is required to update"]);
                exit;
            }
            $eventId = $_POST['eventID'];

            $year = $_POST['year'] ?? '';
            $link = $_POST['link'] ?? '';      

            $target_file = "";
            if (!empty($_FILES['image']['name'])) {
                $target_dir = "uploads/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    echo json_encode(["error" => "Image upload failed"]);
                    exit;
                }
            }

            $updateQuery = "UPDATE ipurse_tbl SET ";
            $params = [];
        

            if ($eventName) {
                $updateQuery .= "img = ?, ";
                $params[] = $eventName;
            }
        
            if ($eventDesc) {
                $updateQuery .= "link = ?, ";
                $params[] = $eventDesc;
            }
        
            if ($eventLink) {
                $updateQuery .= "year = ?, ";
                $params[] = $eventLink;
            }
        
            $updateQuery = rtrim($updateQuery, ', ') . " WHERE id = ?";
            $params[] = $eventId; 

            $stmt = $pdo->prepare($updateQuery);

            if($stmt->execute($params)){
                echo json_encode(["Status" => "Success"]);
            }
            else{
                echo json_encode(["error" => "Internal Server Error while updating event"]);
            }
        }     
        


    }

    // Handle GET requests
    elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (!isset($_GET['action'])) {
            echo json_encode(["error" => "Action not specified"]);
            exit;
        }

        if ($_GET['action'] === "getallipurse") {
            $getstmt = $pdo->prepare("SELECT * FROM ipurse_tbl");
            $getstmt->execute();
            $events = $getstmt->fetchAll(PDO::FETCH_ASSOC);

            if ($events) {
                echo json_encode(["Status" => "Success", "Result" => $events]);
            } else {
                echo json_encode(["Status" => "Error", "Result" => []]);
            }
        }
    } else {
        echo json_encode(["error" => "Invalid request method"]);
    }
?>
