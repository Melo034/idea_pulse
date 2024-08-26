<?php
include_once "./backend/db.php";
?>
<nav class="bg-black">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="./index.php" class="flex items-center space-x-3 rtl:space-x-reverse">
            <span class="self-center text-xl sm:text-xl md:text-2xl lg:text-3xl xl:text-5xl font-semibold whitespace-nowrap">
                <span style="font-family: 'Elsie Swash Caps', serif; font-weight: 900; font-style: normal;">
                    <span class="text-rose-400">IdeaPulse</span>
                </span>
            </span>
        </a>

        <div class="flex items-center md:order-2 md:space-x-0 rtl:space-x-reverse">
            <?php if (isset($_SESSION['id'])) { ?>
                <h1 class="m-auto mr-2  lg:p-5 text-white text-xs sm:text-sm md:text-lg lg:text-xl xl:text-2xl">
                    <?php
                    // Only display the name if it exists and is not null
                    echo isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name'], ENT_QUOTES, 'UTF-8') : 'Guest';
                    ?>
                </h1>
                <div class="bg-white w-14 h-14 xs:h-10 xs:w-10 sm:h-14 sm:w-14 lg:h-24 lg:w-24 lg:h-24 lg:w-24 border-4 border-rose-600 rounded-full flex items-center justify-center">
                    <?php
                    if (empty($_SESSION['image'])) {
                        echo '<img class="rounded-full object-cover w-full h-full" src="./Images/placeholder.jpg" alt="Default Avatar">';
                    } else {
                        echo '<img class="rounded-full object-cover w-full h-full" src="./Images/' . htmlspecialchars($_SESSION['image']) . '" alt="User Image">';
                    }
                    ?>
                </div>

                <div>
                    <ul class="py-2 flex">
                        <li>
                            <a href="./settings.php" class="px-3 py-2 ml-2 sm:text-lg text-sm text-white hover:bg-rose-700 hover:rounded-lg">Settings</a>
                        </li>
                        <li>
                            <a href="./logout.php" class=" px-3 py-2 sm:text-lg text-sm text-white hover:bg-rose-700 hover:rounded-lg">LogOut</a>
                        </li>
                    </ul>
                </div>
            <?php } else { ?>
                <div>
                    <img src="./Images/placeholder.jpg" class="h-12 w-12 xs:h-12 xs:w-12 sm:h-12 sm:w-12 md:h-20 md:w-20 lg:h-20 lg:w-20 rounded-full object-cover mr-2 border-4 border-rose-600" alt="Default Avatar">
                </div>

                <div>
                    <ul class="py-2 flex">
                        <li>
                            <a href="./login.php" class=" px-4 py-2 sm:text-lg text-sm  text-white hover:bg-rose-700 hover:rounded-lg">Login</a>
                        </li>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>
</nav>