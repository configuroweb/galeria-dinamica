<?php
include_once 'config/Database.php';
include_once 'class/Gallery.php';

$database = new Database();
$db = $database->getConnection();

$gallery = new Gallery($db);

if(!empty($_POST['action']) && $_POST['action'] == 'deleteImage') {
	$gallery->id = $_POST["id"];
	$gallery->delete();
}

?>