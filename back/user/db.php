<?php
$string = file_get_contents('database.txt');
if ($string === false) {
    throw new \Exception('Cannot read json file!');
}

$db = json_decode($string, true);
if ($db === null) {
    throw new \Exception('Json file empty!');
}

function maxAttributeInArray($data_points, $value='id'){
    $max=0;
    foreach($data_points as $point){
        if($max < $point[$value]){
            $max = $point[$value];
        }
    }
    return $max;
}

function findObjectByValue($array, $value, $key='id'){
    foreach ($array as $element) {
        if ( $value == $element[$key] ) {
            return $element;
        }
    }
    return false;
}

function saveToFile($db) {
    file_put_contents('database.txt', json_encode($db));
}