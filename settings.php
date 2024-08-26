<?php
session_start();
include_once "./backend/db.php";

if (!isset($_SESSION['email'])) {
    header('Location:./index.php ');
    exit();
}

$id = $_SESSION['id'];

// Check if the delete button is clicked
if (isset($_POST['delete'])) {
    try {
        // Fetch the current image filename from the database before deleting the profile
        $stmt = $pdo->prepare("SELECT image FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && !empty($row['image'])) {
            $imagePath = "./Images/" . $row['image'];
            // Delete the image file from the directory if it exists
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Prepare SQL to delete the user's profile
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);

        // Destroy the session and redirect to the home page
        session_destroy();
        header('Location: ./index.php?message=Profile deleted successfully');
        exit();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

if (isset($_POST['submit'])) {
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $image = $_FILES["file-upload"]["name"] ?? '';

    // Initialize a variable to hold the hashed password
    $hashedPassword = '';

    // Check if password and confirm_password are not empty and are the same
    if (!empty($password) && !empty($confirm_password)) {
        if ($password !== $confirm_password) {
            header("Location: ./settings.php?error=Password and Confirm Password do not match");
            exit();
        }
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    }

    // Handle image upload
    if (!empty($image)) {
        $extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");

        // Check if the file is an actual image
        $check = getimagesize($_FILES['file-upload']["tmp_name"]);
        if ($check === false) {
            header("Location: ./settings.php?error=File is not an image.");
            exit();
        }

        // Check file size (e.g., 5MB)
        if ($_FILES['file-upload']['size'] > 5000000) {
            header("Location: ./settings.php?error=Sorry, your file is too large.");
            exit();
        }

        if (!in_array($extension, $allowed_extensions)) {
            header("Location: ./settings.php?error=Invalid format. Only jpg / jpeg/ png /gif format allowed");
            exit();
        } else {
            $imgnewfile = substr(md5($image), 0, 8) . time() . '.' . $extension;
            move_uploaded_file($_FILES["file-upload"]["tmp_name"], "./Images/" . $imgnewfile);
        }
    }

    // Update user data
    try {
        // Prepare the SQL query
        $sql = "UPDATE users SET full_name = :full_name, email = :email, image = :image";
        // If a new password is provided, add it to the SQL query
        if ($hashedPassword) {
            $sql .= ", password = :password";
        }
        $sql .= " WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $params = [
            'full_name' => $full_name,
            'email' => $email,
            'image' => $imgnewfile ?? $_SESSION['image'], // Use the existing image if no new image is uploaded
            'id' => $id
        ];
        if ($hashedPassword) {
            $params['password'] = $hashedPassword;
        }
        $stmt->execute($params);
        $_SESSION['full_name'] = $full_name;
        $_SESSION['email'] = $email;
        $_SESSION['image'] = $imgnewfile ?? $_SESSION['image'];
        header("Location: ./settings.php?message=Profile updated successfully");
        exit();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'Includes/header.php'; ?>
</head>

<body class="bg-black">
    <?php include 'Includes/navbar.php'; ?>
    <main class="mt-10 mb-20 divide-y max-w-2xl mx-auto p-4 space-y-3">
        <div class="px-4 py-5 duration-150 border-2 shadow-xl shadow-rose-600 border-rose-600 rounded-xl wow animate__animated animate__zoomIn">
            <div class="w-full px-6 pb-8 mt-8 sm:max-w-xl sm:rounded-lg">
                <h2 class="pl-6 text-2xl text-white font-bold sm:text-xl"> Profile Settings</h2>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="grid max-w-2xl mx-auto mt-8">
                        <div class="flex flex-col items-center space-y-5 sm:flex-row sm:space-y-0">
                            <?php
                            $Image = $_SESSION['image'];
                            $imagePath = (empty($Image)) ? "./Images/placeholder.jpg" : "./Images/" . htmlspecialchars($Image);
                            echo '<img id="cimg" class="object-cover w-40 h-40 p-1 rounded-full ring-2 ring-rose-600" src="' . $imagePath . '" alt="User Image">';
                            ?>
                            <div class="flex flex-col space-y-5 sm:ml-8">
                                <label for="dropzone-file" class="py-3.5 px-7 text-base cursor-pointer font-medium text-rose-100 focus:outline-none bg-rose-700 rounded-lg border border-rose-200 hover:bg-rose-600 focus:z-10 focus:ring-4 focus:ring-rose-200">
                                    <input id="dropzone-file" type="file" name="file-upload" onchange="displayImg(this)" class="hidden" />
                                    Change Image
                                </label>

                                <button type="button" onclick="deleteImg()" class="py-3.5 px-7 text-base font-medium text-rose-700 focus:outline-none bg-white rounded-lg border border-rose-200 hover:bg-rose-100 hover:text-[#202142] focus:z-10 focus:ring-4 focus:ring-rose-200">
                                    Delete Image
                                </button>
                            </div>
                        </div>
                        <div class="items-center mt-4 sm:mt-14 text-[#202142]">
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
                            <div class="flex flex-col items-center w-full my-2 space-x-0 space-y-2 sm:flex-row sm:space-x-4 sm:space-y-0 sm:mb-6">
                                <div class="w-full">
                                    <label for="first_name" class="block mb-2 text-sm font-medium text-rose-600">Full Name</label>
                                    <input type="text" id="first_name" name="full_name" class="bg-indigo-50 border border-rose-300 text-black text-sm rounded-lg block w-full p-2.5 " placeholder="Your first name" value="<?php echo $_SESSION['full_name']; ?>">
                                </div>

                                <div class="w-full">
                                    <label for="email" class="block mb-2 text-sm font-medium text-rose-600">Email</label>
                                    <input type="email" id="email" name="email" class="bg-indigo-50 border border-rose-300 text-black text-sm rounded-lg block w-full p-2.5 " placeholder="your.email@mail.com" value="<?php echo $_SESSION['email']; ?>">
                                </div>

                            </div>

                            <div class="flex flex-col items-center w-full mb-2 space-x-0 space-y-2 sm:flex-row sm:space-x-4 sm:space-y-0 sm:mb-6">
                                <div class="w-full">
                                    <div class='flex flex-col text-gray-600 py-2' x-data="{ show: true }">
                                        <div class="flex flex-col mb-3">
                                            <label for="password" class="block mb-2 text-sm font-medium text-rose-600">Password</label>
                                            <div class="relative mt-2">
                                                <!-- Password input field -->
                                                <input class="bg-indigo-50 border border-rose-300 text-black text-sm rounded-lg block w-full p-2.5" :type="show ? 'password' : 'text'" id="password" name="password" autocomplete="current-password" placeholder="Enter your password" />
                                                <!-- Toggle icons for showing/hiding password -->
                                                <div class="absolute inset-y-0 right-0 justify-center pr-3 flex items-center text-sm leading-5">
                                                    <!-- Eye icon when password is hidden (show=true) -->
                                                    <svg x-show="show" class="h-6 text-rose-600" fill="none" @click="show = !show" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"></path>
                                                    </svg>
                                                    <!-- Crossed eye icon when password is shown (show=false) -->
                                                    <svg x-show="!show" class="h-6 text-rose-600" fill="none" @click="show = !show" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                                        <path fill="currentColor" d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 a32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class='flex flex-col py-2' x-data="{ showConfirm: true }">
                                        <!-- Label for the confirm password input -->
                                        <div class="flex flex-col mb-3">
                                            <label for="confirm_password" class="block mb-2 text-sm font-medium text-rose-600">Confirm Password</label>
                                            <div class="relative mt-2">
                                                <!-- Confirm password input field with show/hide functionality -->
                                                <input class="bg-indigo-50 border border-rose-300 text-black text-sm rounded-lg block w-full p-2.5" :type="showConfirm ? 'password' : 'text'" id="confirm_password" name="confirm_password" autocomplete="new-confirm_password" placeholder="Repeat password" />
                                                <!-- Toggle icons for showing/hiding password -->
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                                                    <!-- Eye icon when password is hidden (showConfirm=true) -->
                                                    <svg x-show="showConfirm" class="h-6 text-rose-600" fill="none" @click="showConfirm = !showConfirm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z"></path>
                                                    </svg>

                                                    <!-- Crossed eye icon when password is shown (showConfirm=false) -->
                                                    <svg x-show="!showConfirm" class="h-6 text-rose-600" fill="none" @click="showConfirm = !showConfirm" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                                        <path fill="currentColor" d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 a32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-3 justify-center mt-2">
                                <button name="submit" class="relative flex items-center px-6 py-3 overflow-hidden font-medium transition-all bg-rose-600 rounded-md group">
                                    <span class="absolute top-0 right-0 inline-block w-4 h-4 transition-all duration-500 ease-in-out bg-rose-700 rounded group-hover:-mr-4 group-hover:-mt-4">
                                        <span class="absolute top-0 right-0 w-5 h-5 rotate-45 translate-x-1/2 -translate-y-1/2 bg-white"></span>
                                    </span>
                                    <span class="absolute bottom-0 rotate-180 left-0 inline-block w-4 h-4 transition-all duration-500 ease-in-out bg-rose-800 rounded group-hover:-ml-4 group-hover:-mb-4">
                                        <span class="absolute top-0 right-0 w-5 h-5 rotate-45 translate-x-1/2 -translate-y-1/2 bg-white"></span>
                                    </span>
                                    <span class="absolute bottom-0 left-0 w-full h-full transition-all duration-500 ease-in-out delay-200 -translate-x-full bg-rose-700 rounded-md group-hover:translate-x-0"></span>
                                    <span class="relative w-full text-left font-bold text-white transition-colors duration-200 ease-in-out group-hover:text-white">Save</span>
                                </button>
                                <button name="delete" class="relative flex items-center px-6 py-3 overflow-hidden font-medium transition-all bg-red-600 rounded-md group">
                                    <span class="absolute top-0 right-0 inline-block w-4 h-4 transition-all duration-500 ease-in-out bg-red-700 rounded group-hover:-mr-4 group-hover:-mt-4">
                                        <span class="absolute top-0 right-0 w-5 h-5 rotate-45 translate-x-1/2 -translate-y-1/2 bg-white"></span>
                                    </span>
                                    <span class="absolute bottom-0 rotate-180 left-0 inline-block w-4 h-4 transition-all duration-500 ease-in-out bg-red-800 rounded group-hover:-ml-4 group-hover:-mb-4">
                                        <span class="absolute top-0 right-0 w-5 h-5 rotate-45 translate-x-1/2 -translate-y-1/2 bg-white"></span>
                                    </span>
                                    <span class="absolute bottom-0 left-0 w-full h-full transition-all duration-500 ease-in-out delay-200 -translate-x-full bg-red-700 rounded-md group-hover:translate-x-0"></span>
                                    <span class="relative w-full text-left font-bold text-white transition-colors duration-200 ease-in-out group-hover:text-white">Delete Profile</span>
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <?php include 'Includes/scripts.php'; ?>
</body>
<?php include 'Includes/footer.php'; ?>

</html>