<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $userEmail = filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL);
    $userPassword = $_POST['userPassword'];

    $userDataPath = "user_data.txt";
    $file = file_get_contents($userDataPath);
    $users = explode("\n", $file);
    $isLoggedIn = false;

    foreach ($users as $user) {
        $userData = json_decode($user, true);

        if ($userData && $userData['userEmail'] === $userEmail && $userData['userPassword'] === $userPassword) {
            $_SESSION['userEmail'] = $userEmail;
            $_SESSION['role'] = $userData['role'];
            $isLoggedIn = true;
            break;
        }
    }

    if ($isLoggedIn) {
        if ($_SESSION['role'] === 'admin') {
            header("location: ruleManagment.php");
            exit;
        } elseif ($_SESSION['role'] === 'manager') {
            header("location: management.php");
            exit;
        } else {
            header("location: userPage.php");
            exit;
        }
    } else {
        echo "Invalid credentials. Please try again.";
    }
}
?>
