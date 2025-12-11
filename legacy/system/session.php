<?php
session_start();
include 'db.php';
ini_set("session.cookie_lifetime","86400");
ini_set("session.gc_maxlifetime","86400");
date_default_timezone_set('America/Argentina/Buenos_Aires');

if (!isset($_SESSION['user']['id']))
	header ("Location: ../login.php");

?>