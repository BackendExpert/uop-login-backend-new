<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET");
header("Content-Type: application/json");

include "../config.php";

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['action'])) {
        echo json_encode(["error" => "Action not specified"]);
        exit;
    }

    if ($_POST['action'] === "createNEWS") {
        $newsName = $_POST['newsName'] ?? '';
        $newsDesc = $_POST['newsDesc'] ?? '';
        $newsLink = $_POST['newsLink'] ?? '';
        $newsDate = $_POST['newsDate'] ?? '';
        $newsAddby = $_POST['newsAddby'] ?? '';

        $target_dir = "uploads/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file1 = "";
        $target_file2 = "";
        $target_file3 = "";

        if (!empty($_FILES['newsImg']['name'])) {
            $filename1 = basename($_FILES["newsImg"]["name"]);
            $upload_path1 = $target_dir . $filename1;
            if (!move_uploaded_file($_FILES["newsImg"]["tmp_name"], $upload_path1)) {
                echo json_encode(["error" => "Image 1 upload failed"]);
                exit;
            }
            $target_file1 = $upload_path1;
        }

        if (!empty($_FILES['newsImg2']['name'])) {
            $filename2 = basename($_FILES["newsImg2"]["name"]);
            $upload_path2 = $target_dir . $filename2;
            if (!move_uploaded_file($_FILES["newsImg2"]["tmp_name"], $upload_path2)) {
                echo json_encode(["error" => "Image 2 upload failed"]);
                exit;
            }
            $target_file2 = $upload_path2;
        }

        if (!empty($_FILES['newsImg3']['name'])) {
            $filename3 = basename($_FILES["newsImg3"]["name"]);
            $upload_path3 = $target_dir . $filename3;
            if (!move_uploaded_file($_FILES["newsImg3"]["tmp_name"], $upload_path3)) {
                echo json_encode(["error" => "Image 3 upload failed"]);
                exit;
            }
            $target_file3 = $upload_path3;
        }

        $newststmt = $pdo->prepare("INSERT INTO news 
            (news_title, news_desc, news_link, news_img, img2, img3, news_date, is_active, addby) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $params = [
            $newsName,
            $newsDesc,
            $newsLink,
            $target_file1 ?: '',
            $target_file2 ?: '',
            $target_file3 ?: '',
            $newsDate,
            0,
            $newsAddby
        ];

        if ($newststmt->execute($params)) {
            echo json_encode(["Status" => "Success"]);
        } else {
            $errorInfo = $newststmt->errorInfo();
            echo json_encode(["error" => "Internal Server Error while Creating NEWS", "details" => $errorInfo]);
        }
    }

    if ($_POST['action'] === "updateNEWS") {
        if (empty($_POST['newsName']) && empty($_POST['newsDesc']) && empty($_POST['newsLink']) && empty($_POST['newsDate']) &&
            empty($_FILES['newsImg']['name']) && empty($_FILES['newsImg2']['name']) && empty($_FILES['newsImg3']['name'])) {
            echo json_encode(["error" => "At least one field is required to update"]);
            exit;
        }

        $newsID = $_POST['NEWSid'];

        $newsName = $_POST['newsName'] ?? '';
        $newsDesc = $_POST['newsDesc'] ?? '';
        $newsLink = $_POST['newsLink'] ?? '';
        $newsDate = $_POST['newsDate'] ?? '';

        $target_dir = "uploads/";

        $target_file1 = $target_file2 = $target_file3 = "";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (!empty($_FILES['newsImg']['name'])) {
            $target_file1 = $target_dir . basename($_FILES["newsImg"]["name"]);
            if (!move_uploaded_file($_FILES["newsImg"]["tmp_name"], $target_file1)) {
                echo json_encode(["error" => "Image 1 upload failed"]);
                exit;
            }
        }

        if (!empty($_FILES['newsImg2']['name'])) {
            $target_file2 = $target_dir . basename($_FILES["newsImg2"]["name"]);
            if (!move_uploaded_file($_FILES["newsImg2"]["tmp_name"], $target_file2)) {
                echo json_encode(["error" => "Image 2 upload failed"]);
                exit;
            }
        }

        if (!empty($_FILES['newsImg3']['name'])) {
            $target_file3 = $target_dir . basename($_FILES["newsImg3"]["name"]);
            if (!move_uploaded_file($_FILES["newsImg3"]["tmp_name"], $target_file3)) {
                echo json_encode(["error" => "Image 3 upload failed"]);
                exit;
            }
        }

        $updateQuery = "UPDATE news SET ";
        $params = [];

        if ($newsName) {
            $updateQuery .= "news_title = ?, ";
            $params[] = $newsName;
        }

        if ($newsDesc) {
            $updateQuery .= "news_desc = ?, ";
            $params[] = $newsDesc;
        }

        if ($newsLink) {
            $updateQuery .= "news_link = ?, ";
            $params[] = $newsLink;
        }

        if ($newsDate) {
            $updateQuery .= "news_date = ?, ";
            $params[] = $newsDate;
        }

        if ($target_file1) {
            $updateQuery .= "news_img = ?, ";
            $params[] = $target_file1;
        }

        if ($target_file2) {
            $updateQuery .= "img2 = ?, ";
            $params[] = $target_file2;
        }

        if ($target_file3) {
            $updateQuery .= "img3 = ?, ";
            $params[] = $target_file3;
        }

        $updateQuery = rtrim($updateQuery, ', ') . " WHERE id = ?";
        $params[] = $newsID;

        $stmt = $pdo->prepare($updateQuery);

        if ($stmt->execute($params)) {
            echo json_encode(["Status" => "Success"]);
        } else {
            echo json_encode(["error" => "Internal Server Error while updating news"]);
        }
    }

    if ($_POST['action'] === "deletenews") {
        $imgId = $_POST['Imgeid'] ?? '';

        $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
        $stmt->execute([$imgId]);
        $image = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$image) {
            echo json_encode(["error" => "Image not found"]);
            exit;
        }

        foreach (['news_img', 'img2', 'img3'] as $imgField) {
            if (!empty($image[$imgField]) && file_exists($image[$imgField])) {
                unlink($image[$imgField]);
            }
        }

        $deleteStmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
        if ($deleteStmt->execute([$imgId])) {
            echo json_encode(["Status" => "Success"]);
        } else {
            echo json_encode(["error" => "Failed to delete news from database"]);
        }
    }

    if ($_POST['action'] === "acceptorrefuse") {
        $newsID = $_POST['newsID'] ?? '';

        $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
        $stmt->execute([$newsID]);
        $news = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$news) {
            echo json_encode(["error" => "News not found"]);
            exit;
        }

        $newStatus = ((int)$news['is_active'] === 1) ? 0 : 1;

        $updateStmt = $pdo->prepare("UPDATE news SET is_active = ? WHERE id = ?");
        $updateStmt->execute([$newStatus, $newsID]);

        echo json_encode(["Status" => "Success", "newStatus" => $newStatus]);
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['action'])) {
        echo json_encode(["error" => "Action not specified"]);
        exit;
    }

    if ($_GET['action'] === "getallNEWS") {
        $getstmt = $pdo->prepare("SELECT * FROM news");
        $getstmt->execute();
        $news = $getstmt->fetchAll(PDO::FETCH_ASSOC);

        if ($news) {
            echo json_encode(["Status" => "Success", "Result" => $news]);
        } else {
            echo json_encode(["Status" => "Error", "Result" => []]);
        }
    }
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
