<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/user.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $output = json_decode(login($email, $password));
    }
    if ($output->success) {
        header("Location: ../index.php");
    }
}
include $_SERVER['DOCUMENT_ROOT'] . '/shared/header.php';
?>

<div class="w-full h-full flex flex-col justify-center items-center mt-auto">
    <div class="bg-white rounded-lg p-12 w-1/3 min-w-[512px] flex flex-col items-center">
        <h2 class="text-purple-500 text-4xl">Welcome</h2>
        <form id="login-form" method="POST" class="w-full flex flex-col gap-5 mt-10">
            <input name="email" type="email" placeholder="Email" class="block w-full placeholder:text-purple-500 text-purple-700 border-2 border-grey-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-2 focus:border-purple-500">
            <div class="flex items-center w-full relative">
                <input name="password" type="password" placeholder="Password" class="block w-full placeholder:text-purple-500 text-purple-700 border-2 border-grey-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-2 focus:border-purple-500">
            </div>
            <span id="login-form-message"></span>
            <button class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                Log in
            </button>
        </form>
    </div>
    <p class="mt-2">Don't have an account ?<a href="./signup.php" class="text-purple-500 hover:underline ml-1">Register at</a>
    </p>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/shared/footer.php';
?>