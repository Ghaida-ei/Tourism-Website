<?php
include_once 'Database.php';

if(isset($_POST['save'])) {
    $first_name = $_POST['first_name'];

    $conn = new mysqli($servername, $username, $password, $dbname); // Establish the database connection

    // Check if the user already exists
    $check_query = "SELECT * FROM employee WHERE first_name = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $first_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result !== false && $result->num_rows > 0) {
        echo "User already registered!";
    } else {
        // User doesn't exist, proceed to insert
        $sql = "INSERT INTO employee (first_name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $first_name);

        if ($stmt->execute()) {
            echo "New record created successfully!";
        } else {
            echo "Error: " . $sql . mysqli_error($conn);
        }
    }

    
    mysqli_close($conn);
}
?>

