<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/post.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $postId = $_POST['postId'];

    if ($postId) {
        delete($postId);
        header('Location: ../index.php');
    }
}
