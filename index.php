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
    <!-- ====== Idea Section Start -->
    <section class="pt-20 pb-10 lg:pt-[120px] lg:pb-20 m-4">
        <div class="container mx-auto">
            <div class="flex flex-wrap justify-center -mx-4">
                <div class="w-full px-4">
                    <div class="mx-auto mb-[60px] text-center lg:mb-20">
                        <div class="space-y-5 max-w-4xl mx-auto text-center">
                            <h2 class=" text-xl sm:text-xl md:text-3xl lg:text-4xl xl:text-5xl font-extrabold text-white mx-auto wow animate__animated animate__zoomIn">
                                Welcome to
                                <span style="font-family: 'Elsie Swash Caps', serif; font-weight: 900; font-style: normal;"><span class="text-rose-400">IdeaPulse</span></span>
                            </h2>
                            <p class="max-w-2xl mx-auto text-gray-300">
                                Pitch or Pass?
                            </p>
                        </div>
                        <h2
                            class="mb-4 text-3xl font-bold text-rose-600 sm:text-4xl md:text-[40px] wow animate__animated animate__zoomIn">
                            You Decide.
                        </h2>
                        <a href="./post.php">
                            <button class="cursor-pointer inline-flex items-center rounded-full px-9 py-3 text-xl font-mono font-semibold text-rose-600 hover:text-white border-2 border-rose-600
                                    hover:bg-rose-600 transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-75 hover:bg-rose-600 duration-300  focus:bg-transparent">
                                PITCH
                            </button>
                        </a>
                        <div class="max-w-xl mt-2 mx-auto text-center">
                            <p class="text-base text-white ">
                                On IdeaPulse, users can pitch their innovative ideas and challenge others to vote on their potential—it's
                                an exciting pulse check on creativity! IdeaPulse is an interactive platform where users can share, explore,
                                and vote on compelling ideas submitted by others. The community's feedback helps highlight the most promising concepts,
                                making it a collaborative way to bring ideas to life.
                            </p>
                        </div>
                        <div class="max-w-xl mt-2 mx-auto text-center">
                            <?php if (isset($_GET['Message'])) : ?>
                                <div id="alert-1" class="flex item-center bg-gradient-to-r from-lime-500 via-lime-600 to-lime-700 text-white p-2 rounded mt-2" role="alert">
                                    <div class="ms-3 text-sm font-medium">
                                        <?= htmlspecialchars($_GET['Message']); ?>
                                    </div>
                                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 text-white p-1.5 inline-flex items-center justify-center alert-del h-8 w-8" data-dismiss-target="#alert-1" aria-label="Close">
                                        <span class="sr-only">Close</span>
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                    </button>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($_GET['Error'])) : ?>
                                <div id="alert-2" role="alert" class="flex items-center bg-gradient-to-r from-red-500 via-red-600 to-red-700 text-white p-2 rounded my-2">
                                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                    </svg>
                                    <div class="ms-3 text-sm font-medium">
                                        <?= htmlspecialchars($_GET['Error']); ?>
                                    </div>
                                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 text-white p-1.5 inline-flex items-center justify-center alert-del h-8 w-8" data-dismiss-target="#alert-2" aria-label="Close">
                                        <span class="sr-only">Close</span>
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class='grid gap-6 mt-16 sm:grid-cols-2 lg:grid-cols-3 mx-4 '>
                <?php
                function time_elapsed_string($datetime, $full = false)
                {
                    $now = new DateTime;
                    $ago = new DateTime($datetime);
                    $diff = $now->diff($ago);

                    $string = array(
                        'y' => 'year',
                        'm' => 'month',
                        'd' => 'day',
                        'h' => 'hour',
                        'i' => 'minute',
                        's' => 'second',
                    );

                    $result = array();
                    foreach ($string as $k => $v) {
                        if ($diff->$k) {
                            $result[] = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                        }
                    }

                    if (!$full) {
                        $result = array_slice($result, 0, 1);
                    }

                    return $result ? implode(', ', $result) . ' ago' : 'just now';
                }

                // Function to display facts
                function display_facts($pdo)
                {
                    $sql = "SELECT f.id, f.pitch, f.title, f.created_at, f.picture, u.full_name, u.image, u.university,
                        (SELECT COUNT(*) FROM votes WHERE fact_id = f.id) AS total_votes,
                        (SELECT COUNT(*) FROM votes WHERE fact_id = f.id AND vote_type = 'True') AS true_votes,
                        (SELECT COUNT(*) FROM votes WHERE fact_id = f.id AND vote_type = 'False') AS false_votes
                        FROM facts f
                        JOIN users u ON f.user_id = u.id
                        ORDER BY f.created_at DESC";

                    $stmt = $pdo->query($sql);

                    // Check if the query was successful
                    if (!$stmt) {
                        echo "Error: " . $pdo->errorInfo()[2];
                        return;
                    }

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        // Handle the image path, using a placeholder if no image exists
                        $imagePath = empty($row['image']) ? "./Images/placeholder.jpg" : "./Images/" . htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8');
                        // Handle the image path for the idea, using a placeholder if no image exists
                        $image = empty($row['picture']) ? "./Idea/placeholder.png" : "./Idea/" . htmlspecialchars($row['picture'], ENT_QUOTES, 'UTF-8');
                        // Calculate the elapsed time
                        $elapsedTime = time_elapsed_string($row['created_at']);
                        echo "
                <div class='w-full mb-8  mx-auto group border-2 duration-150 shadow-lg shadow-rose-600 border-rose-600 rounded-xl wow animate__animated animate__zoomIn'>
                    <div class='w-full mb-10'>
                        <div class='mb-8 max-h-[300px] flex-shrink-0 overflow-hidden rounded-xl'>
                            <img 
                                src='{$image}'
                                alt='image'
                                class='w-full h-full object-cover' />
                        </div>
                        <div class='flex items-center gap-x-3 mx-4'>
                            <div class='bg-white w-10 h-10 xs:h-6 xs:w-6 sm:h-10 sm:w-10 lg:h-20 lg:w-20 border-4 border-rose-600 rounded-full flex items-center justify-center'>
                                <img src='{$imagePath}' class='border-2 rounded-full object-cover w-full h-full' alt='User Image'>
                            </div>
                            <div>
                            <span class='block text-lg text-rose-600 font-medium'>{$row['full_name']}</span>
                            <h3 class='text-base text-white font-semibold mt-1'>{$row['university']}</h3>
                            </div>
                        </div>
                        <div class='mt-5 mx-4 mb-5 gap-6'>
                            <h3 class='mb-4 text-xl font-semibold text-rose-600  sm:text-2xl lg:text-xl xl:text-2xl'>
                                    {$row['title']}
                            </h3>
                            <span class='gap-2'>
                                <span class='text-white sm:text-sm my-5'>" . htmlspecialchars($row['pitch'], ENT_QUOTES, 'UTF-8') . "</span>
                            </span>
                        </div>
                        <div class='text-sm text-white flex items-center mx-4 gap-6'>
                            <span class='flex items-center gap-2'>
                                 <span>Total Reactions: <span>{$row['total_votes']}</span></span>
                            </span>
                            <span class='flex items-center gap-2'>
                                <span>Like: <span>{$row['true_votes']}</span></span>
                            </span>
                            <span class='flex items-center gap-2'>
                                <span>Dislike: <span>{$row['false_votes']}</span></span>
                            </span>
                        </div>
                        <div class='text-sm text-white mt-5 mx-4 flex items-center gap-6'>
                            <span class='flex items-center gap-2'>
                            <span class='py-2.5 text-center mb-2'>Vote</span>
                                <form method='POST' action='./backend/vote.php'>
                                    <input type='hidden' name='fact_id' value='{$row['id']}'>
                                        <button class='text-white bg-gradient-to-r from-lime-500 via-lime-600 to-lime-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-lime-300 dark:focus:ring-lime-800 shadow-lg shadow-lime-500/50 dark:shadow-lg dark:shadow-lime-800/80 font-medium rounded-lg text-sm px-3 lg:px-5 xl:px-5 md:px-4 py-2.5 text-center mr-2 mb-2' type='submit' name='vote' value='True'>
                                            <img src='./assets/up_vote.png' alt='up vote'> 
                                        </button>
                                        <button class='text-white bg-gradient-to-r from-red-500 via-red-600 to-red-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 shadow-lg shadow-red-500/50 dark:shadow-lg dark:shadow-red-800/80 font-medium rounded-lg text-sm px-3 lg:px-5 xl:px-5 md:px-4 py-2.5 text-center mr-2 ' type='submit' name='vote' value='False'>
                                            <img src='./assets/down_vote.png' alt='up vote'>
                                        </button>
                                </form>
                            </span>
                            <span class='flex items-center text-xs gap-2 ml-auto'>
                                <span>{$elapsedTime}</span>
                            </span>
                        </div>
                    </div>
                </div>";
                    }
                }
                // Call the function to display facts
                display_facts($pdo);
                ?>
            </div>
        </div>
    </section>
    <!-- ====== Idea Section End -->

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