<?php
session_start();
include_once "./db.php";

// Check if the user is logged in
if (isset($_SESSION['id'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['fact_id']) && isset($_POST['vote'])) {
        $fact_id = intval($_POST['fact_id']);
        $vote_type = $_POST['vote'];

        // Check if the user has already voted on this fact
        $check_vote_sql = "SELECT vote_type FROM votes WHERE user_id = :user_id AND fact_id = :fact_id";
        $stmt = $pdo->prepare($check_vote_sql);
        $stmt->execute(['user_id' => $_SESSION['id'], 'fact_id' => $fact_id]);

        if ($stmt->rowCount() > 0) {
            // Fetch the current vote type
            $existing_vote = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existing_vote['vote_type'] == $vote_type) {
                // The user is trying to vote for the same type, prevent this
                header("Location: ../index.php?Error=You have already voted this way on this fact.");
                exit();
            } else {
                // Update the vote type if it's different
                $update_vote_sql = "UPDATE votes SET vote_type = :vote_type WHERE user_id = :user_id AND fact_id = :fact_id";
                $stmt = $pdo->prepare($update_vote_sql);
                $stmt->execute([
                    'vote_type' => $vote_type,
                    'user_id' => $_SESSION['id'],
                    'fact_id' => $fact_id
                ]);

                if ($stmt) {
                    header("Location: ../index.php?Message=Vote updated successfully");
                    exit();
                } else {
                    header("Location: ../index.php?Error=Error updating vote.");
                    exit();
                }
            }
        } else {
            // Insert the new vote if none exists
            $vote_sql = "INSERT INTO votes (user_id, fact_id, vote_type) VALUES (:user_id, :fact_id, :vote_type)";
            $stmt = $pdo->prepare($vote_sql);
            $stmt->execute([
                'user_id' => $_SESSION['id'],
                'fact_id' => $fact_id,
                'vote_type' => $vote_type
            ]);

            if ($stmt) {
                header("Location: ../index.php?Message=Vote cast successfully");
                exit();
            } else {
                header("Location: ../index.php?Error=Error casting vote.");
                exit();
            }
        }

    } else {
        header("Location: ../index.php?Error=Invalid request!");
        exit();
    }
} else {
    header("Location: ../index.php?Error=Please login to vote!");
    exit();
}
