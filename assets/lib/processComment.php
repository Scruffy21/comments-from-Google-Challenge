<?php 
require 'details.php';

$ip = $_SERVER["REMOTE_ADDR"];
if ($locate = json_decode(file_get_contents("https://www.iplocate.io/api/lookup/{$ip}"), true)) {
    if  (!empty($locate["country"])) {
        $country = $locate["country"];
        $flag = strtolower($locate["country_code"]);  
    }
    else {
        $country = "Unknown country";
        $flag = "xx";
    }
}
else {
    $country = "Unknown country";
    $flag = "xx";
}

$timestamp = time();

if (! empty($_FILES)) {
    $img = $_FILES["photo"];
    $path = $img["name"];
    $path = str_replace(" ", "_", $path);
    if (strlen($path) > 50) {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $nm = pathinfo($path, PATHINFO_FILENAME);
        $path = substr($nm, 0, 50) . "." . $ext;
    }
 

    $photo = "uploads/" . $timestamp . "_" . $path;


    if (! move_uploaded_file($img["tmp_name"], "../../" . $photo)) {
        echo "Error while moving file";
    }
}
else {
    $photo = "uploads/recipient-badge.png";
}

$name = $_POST["name"];
$comment = nl2br($_POST["comment"], false);
$website = $_POST["website"];


$conn = new mysqli($servername, $username, $password, $dbName);
if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO comments (`Name`, `Website`, `Comment`, `Photo`, `Flag`, `Country`, `Time`) VALUES (?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("ssssssi", $name, $website, $comment, $photo, $flag, $country, $timestamp);

//if query successful
if ($stmt->execute()) {

    //dealing with time and date
    $dateTime = date_create();
    date_timestamp_set($dateTime, $timestamp);
    date_timezone_set($dateTime, timezone_open('Europe/Warsaw'));
    $time = $dateTime->format('H:i');
    $date = $dateTime->format('d.m.Y');
    $arr = array(
        "name" => $name,
        "website" => $website,
        "comment" => $comment,
        "photo" => $photo,
        "flag" => $flag,
        "country" => $country,
        "time" => $time,
        "date" => $date
    );
    echo json_encode($arr);
}

else {
    echo mysqli_error($conn);
}




$conn->close();




?>