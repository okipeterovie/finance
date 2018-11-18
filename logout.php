<?php
session_start();
include_once ('functions.php');
session_unset();
session_destroy();
notSetSession();
?>