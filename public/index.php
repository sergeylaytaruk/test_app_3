<?php
session_start();
if (empty($_SESSION['token'])) {
    include 'form_login.php';
} elseif ($_SESSION['token'] == 'IrinaPerepelica') {
    include 'page.php';
}
