<?php
session_start();

$response = ['loggedIn' => false];

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $response['loggedIn'] = true;
}

header('Content-Type: application/json');
echo json_encode($response);
?>