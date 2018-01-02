<?php session_start();
require_once 'appcore/users.php';

logout_user();
header('Location:index.php');
