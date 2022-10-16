<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/user.php';

function get_all_posts()
{
    global $bdd;

    $query = "SELECT * FROM `posts` ORDER BY `created_at` DESC";

    $stmt = $bdd->prepare($query);

    $stmt->execute();

    $posts = [];

    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $post) {
        $author = get_single_user($post['authorId']);

        array_push($posts, [
            'post' => $post,
            'author' => $author['user']
        ]);
    }

    return $posts;
}

function get_all_from_user($id)
{
    global $bdd;

    ['user_exists' => $user_exists] = is_user_existing($id);

    if (!$user_exists) {
        return json_encode(["message" => "The user doesn't exist."]);
    }

    $query = "SELECT * FROM `posts` WHERE `authorId` = :authorId";

    $stmt = $bdd->prepare($query);

    $stmt->execute([
        ':authorId' => $id
    ]);

    $posts = [];
    $author = get_single_user($id);

    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $post) {
        array_push($posts, $post);
    }

    return [
        'posts' => $posts,
        'author' => $author['user']
    ];
}

function create_post($id, $title, $content)
{
    global $bdd;

    $query = "INSERT INTO `posts` (`authorId`,`title`, `content`) VALUES(:authorId, :title, :content)";

    $stmt = $bdd->prepare($query);

    try {
        $stmt->execute([
            ':authorId' => $id,
            ':title' => $title,
            ':content' => $content,
        ]);

        return json_encode([
            'message' => 'The post has successfully been created.',
            'success' => true
        ]);
    } catch (Exception $e) {
        return json_encode(['message' => $e->getMessage()]);
    }
}

function delete($id)
{

    global $bdd;

    ['post_exists' => $post_exists, 'stmt' => $stmt] = is_post_existing($id);

    if (!$post_exists) {
        return json_encode([
            'message' => "The post does not exist."
        ]);
    }

    $query = "DELETE FROM `posts` WHERE `id` = :id";

    $stmt = $bdd->prepare($query);

    try {
        $stmt->execute([
            ':id' => $id
        ]);

        return json_encode([
            'message' => 'The post has been successfully deleted.',
            'success' => true
        ]);
    } catch (Exception $e) {
        return json_encode(['message' => $e->getMessage()]);
    }
}

function is_post_existing($id)
{

    global $bdd;

    $query = "SELECT * FROM `posts` WHERE `id` = :id";

    $stmt = $bdd->prepare($query);

    $stmt->execute([
        ':id' => $id
    ]);

    $post_exists = $stmt->rowCount() == 1;

    return [
        'post_exists' => $post_exists,
        'stmt' => $stmt
    ];
}
