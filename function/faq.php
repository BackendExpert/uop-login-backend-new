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

        if ($_POST['action'] === "createfaq") {
            $Question = $_POST['question'] ?? '';
            $Answer = $_POST['answer'] ?? '';
            $Link = $_POST['link'] ?? '';
            

            $newststmt = $pdo->prepare("INSERT INTO faq(question, answer, link)
            VALUES (?, ?, ?)");

            if ($newststmt->execute([$Question, $Answer, $Link, ])) {
                echo json_encode(["Status" => "Success"]);
            } else {
                $errorInfo = $newststmt->errorInfo();
                echo json_encode(["error" => "Internal Server Error while Creating NEWS", "details" => $errorInfo]);
            }
        }

        // if ($_POST['action'] === "updateNotice") {
        //     if (empty($_POST['noticeName']) && empty($_POST['noticeDesc']) && empty($_POST['noticeLink']) && empty($_POST['noticeDate'])) {
        //         echo json_encode(["error" => "At least one field is required to update"]);
        //         exit;
        //     }
        //     $noticeID = $_POST['NoticeID'];

        //     $noticeName = $_POST['noticeName'] ?? '';
        //     $noticeDesc = $_POST['noticeDesc'] ?? '';
        //     $noticeLink = $_POST['noticeLink'] ?? '';
        //     $noticeDate = $_POST['noticeDate'] ?? '';


        //     $updateQuery = "UPDATE notice SET ";
        //     $params = [];
        

        //     if ($noticeName) {
        //         $updateQuery .= "notice_title = ?, ";
        //         $params[] = $noticeName;
        //     }
        
        //     if ($noticeDesc) {
        //         $updateQuery .= "notice_desc = ?, ";
        //         $params[] = $noticeDesc;
        //     }
        
        //     if ($noticeLink) {
        //         $updateQuery .= "notice_link = ?, ";
        //         $params[] = $noticeLink;
        //     }
        
        //     if ($noticeDate) {
        //         $updateQuery .= "notice_date = ?, ";
        //         $params[] = $noticeDate;
        //     }
        

        //     $updateQuery = rtrim($updateQuery, ', ') . " WHERE notice_id = ?";
        //     $params[] = $noticeID; 

        //     $stmt = $pdo->prepare($updateQuery);

        //     if($stmt->execute($params)){
        //         echo json_encode(["Status" => "Success"]);
        //     }
        //     else{
        //         echo json_encode(["error" => "Internal Server Error while updating event"]);
        //     }
        // }   
        
        if ($_POST['action'] === "deletefaq") {
            $FAQid = $_POST['FAQID'] ?? '';

            $stmt = $pdo->prepare("SELECT * FROM faq WHERE id = ?");
            $stmt->execute([$FAQid]);
            $image = $stmt->fetch(PDO::FETCH_ASSOC);
    

            $deleteStmt = $pdo->prepare("DELETE FROM faq WHERE id = ?");
            if ($deleteStmt->execute([$FAQid])) {
                echo json_encode(["Status" => "Success"]);
            } else {
                echo json_encode(["error" => "Failed to delete image from database"]);
            }
        }

        // if ($_POST['action'] === "acceptorrefusenotice") {
        //     $newsID = $_POST['noticeID'] ?? '';

        //     $stmt = $pdo->prepare("SELECT * FROM notice WHERE notice_id = ?");
        //     $stmt->execute([$newsID]);
        //     $news = $stmt->fetch(PDO::FETCH_ASSOC);

        //     if (!$news) {
        //         echo json_encode(["error" => "notice not found"]);
        //         exit;
        //     }

        //     $newStatus = ((int)$news['is_accepted'] === 1) ? 0 : 1;

        //     $updateStmt = $pdo->prepare("UPDATE notice SET is_accepted = ? WHERE notice_id = ?");
        //     $updateStmt->execute([$newStatus, $newsID]);

        //     echo json_encode(["Status" => "Success", "newStatus" => $newStatus]);
        // }

    }

    // Handle GET requests
    elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (!isset($_GET['action'])) {
            echo json_encode(["error" => "Action not specified"]);
            exit;
        }

        if ($_GET['action'] === "getallfaqs") {
            $getstmt = $pdo->prepare("SELECT * FROM faq");
            $getstmt->execute();
            $notice = $getstmt->fetchAll(PDO::FETCH_ASSOC);

            if ($notice) {
                echo json_encode(["Status" => "Success", "Result" => $notice]);
            } else {
                echo json_encode(["Status" => "Error", "Result" => []]);
            }
        }
    } else {
        echo json_encode(["error" => "Invalid request method"]);
    }
?>
