<?php

include "../config.php";
require '../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Determine action and data source (FormData vs JSON)
    $data = null;
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $source = $_POST;
    } else {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['action'])) {
            echo json_encode(["error" => "Action not specified"]);
            exit;
        }
        $action = $data['action'];
        $source = $data;
    }

    // LOGIN
    if ($action === "login") {
        $email = $source['email'];
        $password = $source['password'];

        $checkstmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $checkstmt->execute([$email]);
        $user = $checkstmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($user['is_active'] == 1) {
                if (password_verify($password, $user['password'])) {
                    $payload = [
                        'email' => $user['email'],
                        'exp' => time() + (60 * 60)
                    ];
                    $token = JWT::encode($payload, $secret_key, 'HS256');

                    echo json_encode([
                        "message" => "Login successful",
                        "username" => $user['username'],
                        "role" => $user['role'],
                        "email" => $user['email'],
                        "status" => "Success",
                        "token" => $token
                    ]);
                } else {
                    echo json_encode(["error" => "Invalid password"]);
                }
            } else {
                echo json_encode(["error" => "User account is not active"]);
            }
        } else {
            echo json_encode(["error" => "User not found"]);
        }
    }

    // PASSWORD UPDATE
    elseif ($action === "updatepassviadash") {
        $oldpass = $source['oldpass'];
        $newpass = $source['newpass'];
        $email = $source['updateUser'];

        if (strlen($newpass) < 8) {
            echo json_encode(["error" => "New password must be at least 8 characters long"]);
            exit;
        }

        $checkstmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $checkstmt->execute([$email]);
        $user = $checkstmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($oldpass, $user['password'])) {
                $hashedNewPass = password_hash($newpass, PASSWORD_DEFAULT);
                $updatestmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
                $updatestmt->execute([$hashedNewPass, $email]);
                echo json_encode(["Status" => "Success", "message" => "Password updated successfully"]);
            } else {
                echo json_encode(["error" => "Old password is incorrect"]);
            }
        } else {
            echo json_encode(["error" => "User not found"]);
        }
    }

    // REGISTER
    elseif ($action === "register") {
        $username = $source['username'];
        $email = $source['email'];
        $Faculty = $source['Faculty'];
        $password = $source['password'];
        $confirmPassword = $source['ConfirmPass'];
    
        // if (!str_ends_with($email, '@pdn.ac.lk')) {
        //     echo json_encode(["error" => "Only @pdn.ac.lk email addresses are allowed."]);
        //     exit;
        // }
    
        if (strlen($password) < 8) {
            echo json_encode(["error" => "Password must be at least 8 characters long."]);
            exit;
        }
    
        if ($password !== $confirmPassword) {
            echo json_encode(["error" => "Password and Confirm Password do not match."]);
            exit;
        }
    
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        $checkstmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $checkstmt->execute([$email]);
    
        if ($checkstmt->fetch(PDO::FETCH_ASSOC)) {
            echo json_encode(["error" => "User already registered."]);
        } else {
            // Insert user
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, Faculty) VALUES (?, ?, ?, ?)");
            $stmt->execute([$username, $email, $hashedPassword, $Faculty]);
    
            // Generate OTP
            function generateOTP($length = 8) {
                $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
                return substr(str_shuffle(str_repeat($chars, ceil($length / strlen($chars)))), 0, $length);
            }
    
            $otp = generateOTP();
            $hashedOTP = password_hash($otp, PASSWORD_DEFAULT);
            $gettime = date('Y-m-d H:i:s');
    
            // Store OTP in opt_tbl
            $otpstmt = $pdo->prepare("INSERT INTO opt_tbl (email, otp, gettime) VALUES (?, ?, ?)");
            $otpstmt->execute([$email, $hashedOTP, $gettime]);
    
            // Send email using PHPMailer
            require '../vendor/autoload.php'; // Make sure Composer's autoload is included
    
            $mail = new PHPMailer(true);
    
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'jehanweerasuriya@gmail.com'; // Replace with your email
                $mail->Password = 'lyizsmrwskhtqgcn'; // Gmail App password (not account password)
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
    
                // Recipients
                $mail->setFrom('jehanweerasuriya@gmail.com', 'University of Peradeniya Registation');
                $mail->addAddress($email);
    
                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Your Email Verification OTP';
                $mail->Body = "
                    <h3>Hello $username,</h3>
                    <p>Your OTP for email verification is: <strong>$otp</strong></p>
                    <p>Please use this OTP within the next 10 minutes.</p>
                    <br><p>Thank you,<br>PDN Registration System</p>
                ";
    
                $mail->send();
    
                echo json_encode([
                    "status" => "Success",
                    "message" => "✅ Registration successful! An OTP has been sent to your email. Please verify to activate your account."
                ]);
            } catch (Exception $e) {
                echo json_encode(["error" => "Registration success, but email failed to send. Error: {$mail->ErrorInfo}"]);
            }
        }
    }

    // VERIFY OTP
    elseif ($action === "verifyEmailOTP") {
        $email = $source['email'];
        $userOtp = $source['otp'];

        // Fetch the latest OTP record for this email
        $stmt = $pdo->prepare("SELECT otp, gettime FROM opt_tbl WHERE email = ? ORDER BY gettime DESC LIMIT 1");
        $stmt->execute([$email]);
        $otpRecord = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$otpRecord) {
            echo json_encode(["error" => "No OTP record found for this email."]);
            exit;
        }

        $hashedOtp = $otpRecord['otp'];
        $getTime = strtotime($otpRecord['gettime']);
        $now = time();

        // Check OTP expiry (10 mins)
        if ($now - $getTime > 600) {
            echo json_encode(["error" => "OTP has expired."]);
            exit;
        }

        // Verify OTP
        if (!password_verify($userOtp, $hashedOtp)) {
            echo json_encode(["error" => "Invalid OTP."]);
            exit;
        }

        // Update user status to active
        $updateUser = $pdo->prepare("UPDATE users SET isEmailVerfy = 1 WHERE email = ?");
        $updateUser->execute([$email]);

        $deleteOtp = $pdo->prepare("DELETE FROM opt_tbl WHERE email = ?");
        $deleteOtp->execute([$email]);
    
        echo json_encode([
            "status" => "Success",
            "message" => "🎉 Your email has been successfully verified!",
        ]);
    }


    elseif ($action === "forgetpass") {
        $email = $data['email'];

        // Check if email exists for 'forgetpass'
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() === 0) {
            echo json_encode(["error" => "No user found with this email."]);
            exit;
        }

        // Generate a 6-digit OTP
        $otp = rand(100000, 999999);
        $hashedOtp = password_hash($otp, PASSWORD_DEFAULT);

        // Store OTP in DB with timestamp
        $stmt = $pdo->prepare("INSERT INTO opt_tbl (email, otp, gettime) VALUES (?, ?, NOW())");
        $stmt->execute([$email, $hashedOtp]);

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'jehanweerasuriya@gmail.com'; // Replace with your email
            $mail->Password = 'lyizsmrwskhtqgcn'; // Gmail App password (not account password)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
    
            // Recipient details
            $mail->setFrom('jehanweerasuriya@gmail.com', 'University of Peradeniya Registation');
            $mail->addAddress($email); // Recipient email
    
            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body    = "Hello,<br><br>Your OTP code is: <b>$otp</b><br><br>This code will expire in 5 minutes.<br>If you didn't request this, please ignore this email.";
    
            // Send email
            $mail->send();
            echo json_encode(["status" => "Success", "message" => "✅ OTP has been sent to your email."]);
        } catch (Exception $e) {
            echo json_encode(["Error" => "Error sending OTP email: {$mail->ErrorInfo}"]);
        }

    }

    elseif ($action === "verifyEmailOTP") {
        $email = $source['email'];
        $userOtp = $source['otp'];
    
        // Fetch the latest OTP record for this email
        $stmt = $pdo->prepare("SELECT otp, gettime FROM otp_tbl WHERE email = ? ORDER BY gettime DESC LIMIT 1");
        $stmt->execute([$email]);
        $otpRecord = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$otpRecord) {
            echo json_encode(["error" => "No OTP record found for this email."]);
            exit;
        }

        $hashedOtp = $otpRecord['otp'];
        $getTime = strtotime($otpRecord['gettime']);
        $now = time();
    
        // Check OTP expiry (5 mins)
        if ($now - $getTime > 300) {  // 5 minutes in seconds
            echo json_encode(["error" => "OTP has expired."]);
            exit;
        }
    
        // Verify OTP
        if (!password_verify($userOtp, $hashedOtp)) {
            echo json_encode(["error" => "Invalid OTP."]);
            exit;
        }

        // Optionally, delete OTP after successful verification
        $deleteOtp = $pdo->prepare("DELETE FROM otp_tbl WHERE email = ?");
        $deleteOtp->execute([$email]);

        // Respond with success message
        echo json_encode([
            "status" => "Success",
            "message" => "🎉 OTP verified successfully. You can now reset your password."
        ]);
    }

    elseif ($action === "updatePassword") {
        $email = $source['email'];
        $newPassword = $source['password'];
    
        // Ensure the new password is not empty
        if (empty($newPassword)) {
            echo json_encode(["error" => "Password cannot be empty."]);
            exit;
        }
    
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
    
        // Update the password in the database
        $updatePassword = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
        $updatePassword->execute([$hashedPassword, $email]);
    
        // Check if the update was successful
        if ($updatePassword->rowCount() > 0) {
            echo json_encode([
                "status" => "Success",
                "message" => "Your password has been successfully updated!",
            ]);
        } else {
            // If no rows are affected, this means either the email doesn't exist or something went wrong
            echo json_encode(["error" => "Failed to update password. Please try again."]);
        }
    }


    // ACCEPT OR REFUSE ACCOUNT
    elseif ($action === "acceptrefuseaccount") {
        $UserEmail = $source['UserEmail'] ?? '';

        if (empty($UserEmail)) {
            echo json_encode(["Error" => "UserEmail not provided"]);
            exit;
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$UserEmail]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo json_encode(["Error" => "User not found"]);
            exit;
        }

        $newStatus = ((int)$user['is_active'] === 1) ? 0 : 1;

        $updateStmt = $pdo->prepare("UPDATE users SET is_active = ? WHERE email = ?");
        $updateStmt->execute([$newStatus, $UserEmail]);

        echo json_encode(["Status" => "Success", "newStatus" => $newStatus]);
    }

    // INVALID ACTION
    else {
        echo json_encode(["Error" => "Invalid action"]);
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['action'])) {
        echo json_encode(["error" => "Action not specified"]);
        exit;
    }

    if ($_GET['action'] === "getuserbyemail") {
        $userID = $_GET['userID'];

        $getstmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $getstmt->execute([$userID]);
        $user = $getstmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo json_encode(["Status" => "Success", "Result" => $user]);
        } else {
            echo json_encode(["Status" => "Error", "Result" => null]);
        }
    }

    elseif ($_GET['action'] === "getallusers") {
        $getstmt = $pdo->prepare("SELECT * FROM users");
        $getstmt->execute();
        $users = $getstmt->fetchAll(PDO::FETCH_ASSOC);

        if ($users) {
            echo json_encode(["Status" => "Success", "Result" => $users]);
        } else {
            echo json_encode(["Status" => "Error", "Result" => null]);
        }
    }

} else {
    echo json_encode(["error" => "Invalid request method"]);
}
