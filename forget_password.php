<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'Includes/header.php'; ?>
</head>

<body class="bg-black">
    <section class="text-rose-500">

        <!-- wrapper -->
        <div class="w-full h-screen flex flex-col relative space-y-8 h-screen p-5 lg:px-20 flex flex-col md:flex-row items-center justify-center">

            <form action="./backend/forget_password.php" method="POST" class="w-full max-w-sm md:w-1/2 border border-rose-600 p-10 bg-black shadow-xl shadow-rose-600 border-rose-600 ">
                <h1 class="text-4xl p-4 text-center font-bold tracking-wide">
                    <span style="font-family: 'Elsie Swash Caps', serif; font-weight: 900; font-style: normal;"><span class="text-rose-400">IdeaPulse</span></span>
                </h1>
                <div>
                    <div class="flex flex-col mb-3">
                        <label for="name">Email</label>
                        <input type="email" name="email" placeholder="Enter your email" class="mt-2 px-3 py-2 bg-gray-800 border rounded-lg border-gray-900 focus:border-rose-500 focus:outline-none focus:bg-gray-800 focus:text-rose-500" autocomplete="off">
                    </div>
                </div>
                <div class="justify-center pt-3 item-center flex ">
                    <button type="submit" name="submit" class="text-white bg-gradient-to-r from-rose-500 via-rose-600 to-rose-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-rose-300 dark:focus:ring-rose-800 shadow-lg shadow-rose-500/50 font-bold rounded-lg text-lg px-5 py-2 text-center mr-2 mb-2">
                        Request Password Reset
                    </button>
                </div>
            </form>
        </div>
    </section>

    <?php include 'Includes/scripts.php'; ?>
</body>

</html>