<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/user.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/post.php';

$user = $_SESSION["user"];

$posts = get_all_posts();

if (isset($_POST["signout"])) {
    logout();
    header('Location: pages/login.php');
}

include 'shared/header.php';
?>

<form method="POST">
    <button type="submit" name="signout" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">signout</button>
</form>

<div class="w-full py-20 min-h-full flex flex-col justify-center items-center">
    <div class="mt-10 bg-white rounded-lg p-5 w-1/2 min-w-[512px] flex flex-col items-center">
        <h2 class="text-purple-500 text-2xl">Welcome <?php echo $user["username"]; ?></h2>
        <form id="create-post-form" action="../config/create_post.php" method="POST" class="w-full flex flex-col gap-2">
            <div class="flex-col gap-5 items-center	justify-center">
                <input name="title" type="text" placeholder="Title" class="block w-full placeholder:text-purple-500 border-2 border-grey-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-2 focus:border-purple-500">
                <textarea name="content" type="text" placeholder="Content" class="block w-full placeholder:text-purple-500 border-2 border-grey-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-2 focus:border-purple-500"></textarea>
            </div>
            <span id="create-post-form-message"></span>
            <button class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                Publish
            </button>
        </form>
    </div>

    <div class="mt-10 flex flex-col gap-10 flex-1 w-1/2 min-w-[512px]">
        <?php foreach ($posts as $post) : ?>
            <div id="post-<?= $post['post']['id'] ?>" class="bg-purple-50 p-5 rounded-lg">
                <header class="flex gap-5">
                    <div>
                        <h3 class="text-lg text-purple-600"><?= $post['author']['username'] ?></h3>
                        <h4 class="text-gray-400 text-sm"><?= $post['post']['created_at'] ?></h4>
                    </div>
                    <div class="flex-1 flex justify-end">
                        <?php
                        if ($post['post']['authorId'] == $user['id']) :
                        ?>
                            <form action="../config/delete_post.php" method="POST">
                                <input type="hidden" name="postId" value="<?= $post['post']['id'] ?>">
                                <button type="submit" name="delete" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">delete</button>
                            </form>
                        <?php endif ?>
                    </div>
                </header>
                <h3 class="mt-3 text-lg text-purple-400"><?= $post['post']['title'] ?></h3>
                <p class="break-all mt-5 text-base">
                    <?= $post['post']['content'] ?>
                </p>
            </div>
        <?php endforeach ?>
    </div>
</div>

<?php
include 'shared/footer.php';
?>