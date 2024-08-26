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
            <div class="w-full max-w-sm md:w-1/2 border border-rose-600 p-10 bg-black shadow-xl shadow-rose-600 border-rose-600 ">
                <h1 class="text-4xl p-4 text-center font-bold tracking-wide">
                    <span style="font-family: 'Elsie Swash Caps', serif; font-weight: 900; font-style: normal;"><span class="text-rose-400">IdeaPulse</span></span>
                </h1>
                <p class="text-center p-4 font-bold mb-3 text-white text-xl">Password Updated.</p>
                <a href="./login.php" class="text-white font-bold rounded-lg bg-gradient-to-r from-rose-500 via-rose-600 to-rose-700 hover:bg-gradient-to-br w-full my-5 p-2">Click here</a> to login.
            </div>
        </div>
    </section>

    <?php include 'Includes/scripts.php'; ?>
</body>

</html>