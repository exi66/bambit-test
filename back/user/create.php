<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    exit;
}

include 'db.php';

function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}

$error = array('errors' => array());

$email = $_POST['email'];
$name = clean($_POST['name']);
$password = $_POST['password'];

if (empty($email) || empty($name) || empty($password)) {
    $error['errors'][] = "All fields must be not empty";
} else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $error['errors'][] = "Invalid email format";
    if (findObjectByValue($db, $email, 'email'))
        $error['errors'][] = "This email has been already in use";
    if (strlen($password) < 5)
        $error['errors'][] = "Password length must be >= 6";
}

if (count($error['errors']) > 0) {
    echo json_encode($error);
    exit;
}

$id = maxAttributeInArray($db);
$user = array('id' => ++$id, 'email' => $email, 'name' => $name, 'password' => $password);

$db[] = $user;
saveToFile($db);
echo json_encode(array('success' => 'Добро пожаловать '.$name));
exit;
