<?php

$db = new mysqli('localhost', 'root', '', 'clinica_dental');
$db->set_charset('utf8mb4');
session_start();

function auth() {
    if (empty($_SESSION['u'])) {
        header('Location: login.php');
        exit;
    }
}
