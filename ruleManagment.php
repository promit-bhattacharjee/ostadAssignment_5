<?php
session_start();

function checkAdmin()
{
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        return true;
    } else {
        return false;
    }
}function updateUserRole($userEmail, $newRole)
{
    if (checkAdmin()) {
        $userDataPath = "user_data.txt";
        $json_data = file_get_contents($userDataPath);
        $users = explode(PHP_EOL, $json_data);
        $updatedUsers = [];
        foreach ($users as $user) {
            $data = json_decode($user, true);
            if ($data && $data['userEmail'] === $userEmail) {
                $data['role'] = $newRole;
                $user = json_encode($data);
            }
            $updatedUsers[] = $user;
        }
        file_put_contents($userDataPath, implode(PHP_EOL, $updatedUsers));

        echo "User role updated successfully.";
    } else {
        echo "Access denied. Only admins can update user roles.";
    }
}
function addUser($userName, $userEmail, $userPassword, $userRole)
{
    if (checkAdmin()) {
        echo "New user added successfully.";
    } else {
        echo "Access denied. Only admins can add new users.";
    }
}

function deleteUser($userEmail)
{
    if (checkAdmin()) {
        echo "User deleted successfully.";
    } else {
        echo "Access denied. Only admins can delete users.";
    }
}

if (checkAdmin()) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['updateRole']) && isset($_POST['userEmail'])) {
            $userEmail = $_POST['userEmail'];
            $newRole = $_POST['updateRole'];
            updateUserRole($userEmail, $newRole);
        } elseif (isset($_POST['userName']) && isset($_POST['userEmail']) && isset($_POST['userPassword']) && isset($_POST['userRole'])) {
            $userName = $_POST['userName'];
            $userEmail = $_POST['userEmail'];
            $userPassword = $_POST['userPassword'];
            $userRole = $_POST['userRole'];
            addUser($userName, $userEmail, $userPassword, $userRole);
        } elseif (isset($_POST['deleteUserEmail'])) {
            $userEmail = $_POST['deleteUserEmail'];
            deleteUser($userEmail);
        }
    }

    echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Rule Management</title>
        </head>
        <body>
            <h1>Welcome, Admin</h1>
            <h2>Rule Management Page</h2>
            <h3>Update User Role</h3>
            <form method='post' action=''>
                <input type='text' name='userEmail' placeholder='Enter user email'>
                <input type='text' name='updateRole' placeholder='Enter new role'>
                <input type='submit' value='Update User Role'>
            </form>
            <h3>Add New User</h3>
            <form method='post' action=''>
                <input type='text' name='userName' placeholder='Enter user name'>
                <input type='text' name='userEmail' placeholder='Enter user email'>
                <input type='password' name='userPassword' placeholder='Enter user password'>
                <input type='text' name='userRole' placeholder='Enter user role'>
                <input type='submit' value='Add User'>
            </form>
            <h3>Delete User</h3>
            <form method='post' action=''>
                <input type='text' name='deleteUserEmail' placeholder='Enter user email to delete'>
                <input type='submit' value='Delete User'>
            </form>
        </body>
        </html>";
} else {
    header("location: login.html");
    exit;
}
?>
