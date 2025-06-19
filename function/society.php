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

    if ($_POST['action'] === "createSociety") {
        $Name = $_POST['name'] ?? '';
        $Link = $_POST['link'] ?? '';
        $Faculty = $_POST['faculty'] ?? '';

        // Check if name already exists
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM societies WHERE name = ?");
        $checkStmt->execute([$Name]);
        $count = $checkStmt->fetchColumn();

        if ($count > 0) {
            echo json_encode(["error" => "Name already exists"]);
            exit;
        }

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

        $eventstmt = $pdo->prepare("INSERT INTO societies(name, image, link, faculty)
                                    VALUES (?, ?, ?, ?)");

        if ($eventstmt->execute([$Name, $target_file, $Link, $Faculty])) {
            echo json_encode(["Status" => "Success"]);
        } else {
            $errorInfo = $eventstmt->errorInfo();
            echo json_encode(["error" => "Internal Server Error while Creating Society", "details" => $errorInfo]);
        }
    }


        // if ($_POST['action'] === "updateCertificate") {
        //     $dipID = $_POST['Dipid'] ?? '';

        //     if (empty($dipID) || $dipID === 'undefined') {
        //         echo json_encode(["error" => "Invalid or missing certificate ID"]);
        //         exit;
        //     }

        //     $Desc = $_POST['description'] ?? '';
        //     $Link = $_POST['link'] ?? '';
        //     $target_file = "";

        //     if (!empty($_FILES['image']['name'])) {
        //         $target_dir = "uploads/";
        //         if (!is_dir($target_dir)) {
        //             mkdir($target_dir, 0777, true);
        //         }
        //         $target_file = $target_dir . basename($_FILES["image"]["name"]);
        //         if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        //             echo json_encode(["error" => "Image upload failed"]);
        //             exit;
        //         }
        //     }

        //     // No valid fields to update
        //     if (empty($Desc) && empty($Link) && empty($target_file)) {
        //         echo json_encode(["error" => "At least one field is required to update"]);
        //         exit;
        //     }

        //     $updateQuery = "UPDATE cirtificate SET ";
        //     $params = [];

        //     if (!empty($Desc)) {
        //         $updateQuery .= "description = ?, ";
        //         $params[] = $Desc;
        //     }

        //     if (!empty($Link)) {
        //         $updateQuery .= "link = ?, ";
        //         $params[] = $Link;
        //     }

        //     if (!empty($target_file)) {
        //         $updateQuery .= "image = ?, ";
        //         $params[] = $target_file;
        //     }

        //     $updateQuery = rtrim($updateQuery, ', ') . " WHERE id = ?";
        //     $params[] = $dipID;

        //     $stmt = $pdo->prepare($updateQuery);

        //     if ($stmt->execute($params)) {
        //         echo json_encode(["Status" => "Success"]);
        //     } else {
        //         $errorInfo = $stmt->errorInfo();
        //         echo json_encode(["error" => "Internal Server Error while updating event", "details" => $errorInfo]);
        //     }
        // }


        if ($_POST['action'] === "deletesociety") {
            $imgId = $_POST['SocietyID'] ?? '';

            $stmt = $pdo->prepare("SELECT * FROM societies WHERE id = ?");
            $stmt->execute([$imgId]);
            $image = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$image) {
                echo json_encode(["error" => "Society not found"]);
                exit;
            }

            $deleteStmt = $pdo->prepare("DELETE FROM societies WHERE id = ?");
            if ($deleteStmt->execute([$imgId])) {
                echo json_encode(["Status" => "Success"]);
            } else {
                echo json_encode(["error" => "Failed to delete image from database"]);
            }
        }
    }

    elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (!isset($_GET['action'])) {
            echo json_encode(["error" => "Action not specified"]);
            exit;
        }

        if ($_GET['action'] === "getallsocieties") {
            $getstmt = $pdo->prepare("SELECT * FROM societies");
            $getstmt->execute();
            $society = $getstmt->fetchAll(PDO::FETCH_ASSOC);

            if ($society) {
                echo json_encode(["Status" => "Success", "Result" => $society]);
            } else {
                echo json_encode(["Status" => "Error", "Result" => []]);
            }
        }

    } else {
        echo json_encode(["error" => "Invalid request method"]);
    }
?>
