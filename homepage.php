<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holy Cross of Davao College - Reservation System</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to the CSS file -->
</head>
<body>
    <header>
        <div class="container">
            <div class="logo-container">
                <img src="logo.png" alt="Holy Cross of Davao College Logo" class="logo">
                <img src="blabla.png" alt="Bachelor of Science Information Technology" class="text-logo"> <!-- Adding the text image -->
            </div>
            <nav>
                <a href="admin.php">ADMIN</a>
                <a href="homepage.php">HOME</a>
                <a href="#" id="reserveButton">RESERVE</a> <!-- Link changed to trigger modal -->
                <a href="sanctions.php">SANCTIONS</a>
                <a href="logout.php">LOGOUT</a>
            </nav>
        </div>
    </header>

    <main>
        <div class="message">
            NO RESERVATIONS YET
        </div>
    </main>

    <!-- Modal for Reserve -->
    <div id="reservationModal" class="modal">
        <div class="modal-content">
            <!-- Step 1: Reservation Details -->
            <div id="step1">
                <h2>Reservation</h2>
                <form id="reservationForm">
                    <label for="reservationType">Reservation type</label>
                    <select id="reservationType" name="reservationType">
                        <option value="Laboratory">Open Laboratory</option>
                        <option value="Manuscript">Manuscript</option>
                    </select>

                    <label for="reservationDate">Date</label>
                    <input type="date" id="reservationDate" name="reservationDate" required>

                    <label for="reservationTime">Time</label>
                    <input type="time" id="reservationTime" name="reservationTime" required>

                    <div class="modal-buttons">
                        <button type="button" id="cancelButton">Cancel</button>
                        <button type="button" id="nextStep">Next</button>
                    </div>
                </form>
            </div>

            <!-- Step 2: User Details -->
            <div id="step2" style="display:none;">
                <h2>User Information</h2>
                <form id="userForm">
                    <label for="studentName">Name</label>
                    <input type="text" id="studentName" name="studentName" required>

                    <label for="studentID">Student ID</label>
                    <input type="text" id="studentID" name="studentID" required>

                    <label for="studentYear">Year</label>
                    <select id="studentYear" name="studentYear">
                        <option value="1stYear">1st Year</option>
                        <option value="2ndYear">2nd Year</option>
                        <option value="3rdYear">3rd Year</option>
                        <option value="4thYear">4th Year</option>
                    </select>

                    <div class="modal-buttons">
                        <button type="button" id="backStep">Back</button>
                        <button type="submit">Submit</button>
                    </div>
                </form>
            </div>

            <!-- Confirmation message -->
            <div id="confirmationMessage" style="display:none;">
                <h2>Reservation Successful!</h2>
                <p>Your reservation has been successfully submitted.</p>
                <button id="closeModal">Close</button>
            </div>
        </div>
    </div>

    <script>
        // Handle multi-step modal and form submission via AJAX
        var modal = document.getElementById('reservationModal');
        var reserveButton = document.getElementById('reserveButton');
        var cancelButton = document.getElementById('cancelButton');
        var nextStep = document.getElementById('nextStep');
        var backStep = document.getElementById('backStep');
        var closeModalButton = document.getElementById('closeModal');

        var step1 = document.getElementById('step1');
        var step2 = document.getElementById('step2');
        var confirmationMessage = document.getElementById('confirmationMessage');
        
        // Show modal
        reserveButton.onclick = function() {
            modal.style.display = 'block';
        }

        // Cancel and close modal
        cancelButton.onclick = function() {
            modal.style.display = 'none';
            resetSteps();
        }

        // Navigate to step 2
        nextStep.onclick = function() {
            step1.style.display = 'none'; // Hide Step 1
            step2.style.display = 'block'; // Show Step 2
        }

        // Navigate back to step 1
        backStep.onclick = function() {
            step2.style.display = 'none'; // Hide Step 2
            step1.style.display = 'block'; // Show Step 1
        }

        // Close modal after confirmation
        closeModalButton.onclick = function() {
            modal.style.display = 'none';
            resetSteps(); // Reset to step 1 for the next reservation
        }

        // Reset steps for the modal
        function resetSteps() {
            step1.style.display = 'block';
            step2.style.display = 'none';
            confirmationMessage.style.display = 'none';
        }

        // AJAX form submission
        var userForm = document.getElementById('userForm');
        userForm.onsubmit = function(e) {
            e.preventDefault(); // Prevent form from submitting normally

            // Collect all form data
            var formData = new FormData(document.getElementById('reservationForm')); // Get data from step 1
            formData.append("studentName", document.getElementById('studentName').value); // Add user name
            formData.append("studentID", document.getElementById('studentID').value); // Add user ID
            formData.append("studentYear", document.getElementById('studentYear').value); // Add user year

            // Send AJAX request to reserve.php
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "reserve.php", true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    // Display confirmation message and hide step 2
                    step2.style.display = 'none';
                    confirmationMessage.style.display = 'block';
                } else {
                    console.error("Error submitting the form.");
                }
            };
            xhr.send(formData); // Send form data via POST
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
                resetSteps();
            }
        }
    </script>
</body>
</html>
