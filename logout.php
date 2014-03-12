<?php
//this is here to test session stuffs

session_start();
session_destroy();

header("location:index.php");