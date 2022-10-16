<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';


function get_all_user()
{
    global $bdd;

    $query = "SELECT * FROM 'users'";

    $stmt = $bdd->prepare($query);

    $stmt->execute();

    return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

function get_single_user($id)
{
    ['user_exists' => $user_exists, 'stmt' => $stmt] = is_user_existing($id);

    if ($user_exists) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'user' => $user,
            'success' => true
        ];
    } else {
        return json_encode(["message" => "The user doesn't exist"]);
    }
}

function create_user(
    $username,
    $email,
    $password,
) {

    global $bdd;

    $query = "SELECT `email` FROM `users` WHERE `email` = :email;";

    $stmt = $bdd->prepare($query);

    $stmt->execute([
        ":email" => $email,
    ]);

    $user = $stmt->fetch();

    if (!$user) {
        $query = "INSERT INTO `users` (`admin`, `username`, `email`, `password`) VALUES(:admin, :username, :email, :password)";

        $stmt = $bdd->prepare($query);

        try {
            $stmt->execute([
                ':admin' => 0,
                ':username' => $username,
                ':email' => $email,
                ':password' => password_hash(htmlspecialchars($password), PASSWORD_BCRYPT, ['cost' => 12]),
            ]);

            login($email, $password);

            return json_encode([
                'message' => 'The user has successfully been created',
                'success' => true
            ]);
        } catch (Exception $e) {
            return json_encode(['message' => $e->getMessage()]);
        }
    } else {
        return 'The user has already an account';
    }
}

function login($email, $password)
{
    global $bdd;

    $query = "SELECT * FROM `users` WHERE `email` = :email";

    $stmt = $bdd->prepare($query);

    try {
        $stmt->execute([
            ':email' => $email,
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return json_encode(['message' => "This account doesn't exist."]);
        }

        if (password_verify(htmlspecialchars($password), $user['password'])) {

            session_start();

            $_SESSION['user'] = $user;

            return json_encode([
                'message' => 'The user has successfully been logged in.',
                'success' => true
            ]);
        }

        return json_encode(['message' => "The password doesn't match."]);
    } catch (Exception $e) {
        return json_encode(['message' => $e->getMessage()]);
    }
}

function logout()
{
    session_unset();
    session_destroy();

    return json_encode(['message' => 'The user has successfully been logged out']);
}



function is_user_existing($id)
{
    global $bdd;

    $query = "SELECT * FROM `users` WHERE `id` = :id";

    $stmt = $bdd->prepare($query);

    $stmt->execute([
        ':id' => $id
    ]);

    $user_exists = $stmt->rowCount() == 1;

    return [
        'user_exists' => $user_exists,
        'stmt' => $stmt
    ];
}
