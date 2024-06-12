<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proctoring Report</title>
   
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS -->
</head>
<body>
    <div class="sidebar">
        <img src="logo.png" alt="Logo" class="logo">
        <nav>
            <a href="#" class="active">Home</a>
        </nav>
        <div class="user-info">
            <img src="user-icon.jpg" alt="User Icon">
            <p>Hi, User</p>
        </div>
    </div>

   
    <main class="main-content">
        <h1>View Report</h1>
        <section class="candidate-id">
            <h3>Enter Candidate ID</h3>
            <form action="report.php" method="post">
                <input type="text" id="candidate_id" name="candidate_id" placeholder="Enter Candidate ID" required>
                <button type="submit" class="btn btn-primary" id="fetch_report_btn">Fetch Data</button>
                <br>
            </form>
        </section>
        <section class="user-info">
            <h2>Candidate Information</h2>
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th>Candidate Name</th>
                        <th>Examiner ID</th>
                        <th>Course Name</th>
                        <th>Batch</th>
                        <th>Time</th>
                        <th>Audio Model Result</th>
                        <th>Object Model Result</th>
                        <th>Headpose Model Result</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "online_exam_proctoring_db";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $candidate_id = $_POST['candidate_id'];

                        $sql = "SELECT 
                                    FULL_NAME as candidate_name, 
                                    EXAMINER_ID, 
                                    TITLE as course_name, 
                                    BATCH,
                                    TIMESTAMP,
                                    HEADPOSE_MODEL_RESULT,
                                    OBJECT_MODEL_RESULT,
                                    AUDIO_MODEL_RESULT
                                FROM view_report
                                WHERE candidate_id = '$candidate_id'";

                        $result = $conn->query($sql);

                        if (!$result) {
                            die("Invalid query: " . $conn->error);
                        }

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . $row["candidate_name"] . "</td>
                                        <td>" . $row["EXAMINER_ID"] . "</td>
                                        <td>" . $row["course_name"] . "</td>
                                        <td>" . $row["BATCH"] . "</td>
                                        <td>" . $row["TIMESTAMP"] . "</td>
                                        <td>" . $row["AUDIO_MODEL_RESULT"] . "</td>
                                        <td>" . $row["OBJECT_MODEL_RESULT"] . "</td>
                                        <td>" . $row["HEADPOSE_MODEL_RESULT"] . "</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No results found</td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
