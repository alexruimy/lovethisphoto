<?php
require_once("lib/images.php");

$image_id = $_GET['id'];
$vote = $_GET['v'];

if ($image_id && $vote) {

	$images = new Images();

	echo $images->vote($image_id,$vote);
}