<?php
session_start();
include_once "./backend/db.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'Includes/header.php'; ?>
</head>

<body class="bg-black">
    <?php include 'Includes/navbar.php'; ?>




    <section class="relative">
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-rose-600 h-32 w-full"></div>
        <div class="relative z-10 max-w-screen-xl mx-auto px-4 py-28 md:px-8">
            <form action="./backend/post.php" method="POST" enctype="multipart/form-data" class="w-full mt-20 max-w-2xl mx-auto md:w-1/2 border border-rose-600 rounded-lg p-6 bg-black wow animate__animated animate__zoomIn">
                <h2 class="text-2xl text-rose-600 pb-3 font-semibold">
                    Pitch an Idea
                </h2>
                <?php if (isset($_GET['message'])) : ?>
                    <div id="alert-3" class="flex item-center bg-gradient-to-r from-rose-500 via-rose-600 to-rose-700 text-white p-2 rounded mt-2" role="alert">
                        <div class="ms-3 text-sm font-medium">
                            <?= htmlspecialchars($_GET['message']); ?>
                        </div>
                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 text-white p-1.5 inline-flex items-center justify-center alert-del h-8 w-8" data-dismiss-target="#alert-3" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                <?php endif; ?>
                <?php if (isset($_GET['error'])) : ?>
                    <div id="alert-4" role="alert" class="flex items-center bg-gradient-to-r from-red-500 via-red-600 to-red-700 text-white p-2 rounded my-2">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <div class="ms-3 text-sm font-medium">
                            <?= htmlspecialchars($_GET['error']); ?>
                        </div>
                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 text-white p-1.5 inline-flex items-center justify-center alert-del h-8 w-8" data-dismiss-target="#alert-4" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                <?php endif; ?>
                <div>
                    <div class="flex flex-col mb-3">
                        <label class="text-rose-600 mb-2" for="title-input">Title</label>
                        <input type="text" name="title" id="title-input" placeholder="Title"  required class="px-3 rounded-lg py-2 bg-gray-800 border focus:border-2 border-gray-900 focus:border-rose-500 focus:outline-none focus:bg-gray-800 text-white" />
                    </div>
                    <div class="flex flex-col mb-3">
                        <label class="text-rose-600 mb-2" for="message">Description</label>
                        <textarea rows="4" name="pitch" id="message" placeholder="Enter the description here" require class="px-3 rounded-lg py-2 bg-gray-800 border border-gray-900 focus:border-2 focus:border-rose-500 focus:outline-none focus:bg-gray-800 text-white"></textarea>
                    </div>
                    <div class="flex flex-col mb-3">
                        <label class="text-rose-600 mb-2">Image</label>
                        <label for="picture_file" class="flex mt-2 flex-col items-center justify-center w-full h-36 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-rose-600">
                            <div class="px-3 rounded-lg py-2 bg-rose-600 border border-rose-600 focus:border-2 focus:border-rose-500 focus:outline-none focus:bg-rose-800 text-white">
                                <svg class="w-8 h-8 mb-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-white"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-white">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                            </div>
                            <input id="picture_file" type="file" name="upload" class="hidden" required/>
                        </label>
                    </div>
                </div>
                <div class="w-full flex justify-center pt-3">
                    <button type="submit" name="submit" class="relative flex items-center px-6 py-3 overflow-hidden font-medium transition-all bg-rose-600 rounded-md group">
                        <span class="absolute top-0 right-0 inline-block w-4 h-4 transition-all duration-500 ease-in-out bg-rose-700 rounded group-hover:-mr-4 group-hover:-mt-4">
                            <span class="absolute top-0 right-0 w-5 h-5 rotate-45 translate-x-1/2 -translate-y-1/2 bg-white"></span>
                        </span>
                        <span class="absolute bottom-0 rotate-180 left-0 inline-block w-4 h-4 transition-all duration-500 ease-in-out bg-rose-800 rounded group-hover:-ml-4 group-hover:-mb-4">
                            <span class="absolute top-0 right-0 w-5 h-5 rotate-45 translate-x-1/2 -translate-y-1/2 bg-white"></span>
                        </span>
                        <span class="absolute bottom-0 left-0 w-full h-full transition-all duration-500 ease-in-out delay-200 -translate-x-full bg-rose-700 rounded-2xl group-hover:translate-x-0"></span>
                        <span class="absolute top-0 left-0 w-full h-full transition-all duration-500 ease-in-out delay-200 translate-x-full bg-rose-800 rounded-2xl group-hover:translate-x-0"></span>
                        <span class="relative w-full text-left text-white transition-colors duration-200 ease-in-out group-hover:text-white">Post Now</span>
                    </button>
                </div>
            </form>
        </div>
        </div>
        </div>
    </section>
    <Script>
        // Script For Close alert
        var alert_del = document.querySelectorAll('.alert-del');
        alert_del.forEach((x) =>
            x.addEventListener('click', function() {
                x.parentElement.classList.add('hidden');
            })
        );
    </Script>
    <?php include 'Includes/footer.php'; ?>
</body>

</html>