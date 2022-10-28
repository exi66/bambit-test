<?php

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    exit;
}

if (empty($_POST['__method']) || empty($_POST['id'])) exit;
if ($_POST['__method'] !== 'DELETE') exit;


$id = $_POST['id'];

$db = array_filter($db, static function($element) use ($id) {
    return $element['id'] != $id;
});

saveToFile($db);

echo json_encode(array('success' => 'Deleted '.$id));
//exit;