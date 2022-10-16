<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/post.php';
session_start();

$user = $_SESSION["user"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["title"]) && isset($_POST["content"])) {
        $title = $_POST["title"];
        $content = $_POST["content"];

        $output = json_decode(create_post($user['id'], $title, $content));

        header('Location: ../index.php');
    }
}
