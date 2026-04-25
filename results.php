<?php // Andrew Pulliam - 04/25/2026 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
    <h1>Search Results</h1>
    <p>Andrew Pulliam</p>
    <p>April 25, 2026</p>
    
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $conn = mysqli_connect("localhost", "root", "mysql", "taus_data");

    if (!$conn) {
        echo '<div class="message error">Database connection failed: '
              . myqli_connect_error() . '</div>';
        exit;

    }

    $sql = "SELECT firstName, lastName, email FROM thl_student WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo '<div class="message">';
        echo 'Student found: ' . htmlspecialchars($row["firstName"])
            . ' ' . htmlspecialchars($row["lastName"]);
        echo '<br>Email: ' .htmlspecialchars($row["email"]);
        echo '</div>';
    } else {
        echo '<div class="message error">';
        echo 'No student was found with that email address';
        echo '</div>';
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

}
?>

    <p><a href="index.php">&larr; Back to search</a></p>
</body>
</html>