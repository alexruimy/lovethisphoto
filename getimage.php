<?php
require_once("lib/images.php");

$image_id = $_GET['id'];

$images = new Images();

echo $images->getImageById($image_id);
