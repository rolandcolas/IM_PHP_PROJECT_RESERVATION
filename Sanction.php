<?php
session_start(); // Make sure to start the session

// Include database connection
require('db.php');

// Get user ID from the session (ensure the user is logged in)
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];

    // Prepare a SQL query to get the sanctions for the logged-in user
    $stmt = $conn->prepare("SELECT name, id_number, reservation_type, violation, sanction FROM sanctions WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if sanctions were found for the user
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Name</th><th>ID number</th><th>Reservation Type</th><th>Violation</th><th>Sanction</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["id_number"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["reservation_type"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["violation"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["sanction"]) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No sanctions found for this user.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "You must be logged in to view sanctions.";
}
?>
