<?php

// Run this script to sync the database with the gallery directory

require_once("lib/images.php");

$images = new Images();

$images->scan();