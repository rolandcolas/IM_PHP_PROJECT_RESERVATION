<?php
session_start(); // Start the session (if needed)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture the form data from the modal (both steps)
    $reservationType = $_POST['reservationType'];
    $reservationDate = $_POST['reservationDate'];
    $reservationTime = $_POST['reservationTime'];
    $studentName = $_POST['studentName'];
    $studentID = $_POST['studentID'];
    $studentYear = $_POST['studentYear'];

    // Check if all required fields are filled
    if (empty($reservationType) || empty($reservationDate) || empty($reservationTime) ||
        empty($studentName) || empty($studentID) || empty($studentYear)) {
        echo "Please fill in all fields.";
    } else {
        // Include the database connection
        require('db.php'); 

        // Prepare the SQL query to insert data
        $stmt = $conn->prepare("INSERT INTO reservations (reservation_type, reservation_date, reservation_time, student_name, student_id, student_year) VALUES (?, ?, ?, ?, ?, ?)");

        // Bind the parameters to prevent SQL injection
        $stmt->bind_param("ssssss", $reservationType, $reservationDate, $reservationTime, $studentName, $studentID, $studentYear);

        // Execute the query and check for success
        if ($stmt->execute()) {
            echo "Reservation successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();

        // Optionally redirect to a confirmation page or show success message
        echo "Reservation successful! You reserved a $reservationType on $reservationDate at $reservationTime.<br>";
        echo "Name: $studentName<br>";
        echo "Student ID: $studentID<br>";
        echo "Year: $studentYear";
    }
}
?>
