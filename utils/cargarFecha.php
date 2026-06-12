<?php
if (isset($_GET['desde'], $_GET['hasta'])) {
    $_SESSION['desde'] = $_GET['desde'];
    $_SESSION['hasta'] = $_GET['hasta'];
}

if (!isset($_SESSION['desde'])) {
    $_SESSION['desde'] = date('Y-m-01');
}

if (!isset($_SESSION['hasta'])) {
    $_SESSION['hasta'] = date('Y-m-t');
}

$inicio = $_SESSION['desde'];
$fin = $_SESSION['hasta'];
?>