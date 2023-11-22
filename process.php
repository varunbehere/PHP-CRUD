<?php
include('dbconnection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"];

    if ($action == "add") {
        $userId = $_POST["userId"];
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $mobileNumber = $_POST["mobileNumber"];
        $email = $_POST["email"];
        $address = $_POST["address"];

        // Use prepared statement to prevent SQL injection
        $sql = "INSERT INTO tblusers (FirstName, LastName, MobileNumber, Email, Address) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sssds", $firstName, $lastName, $mobileNumber, $email, $address);

        if ($stmt->execute()) {
            // Redirect to a new page
            header("Location: success.html");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } elseif ($action == "update") {
        // Process the "Update User" form submission
        $userIdToUpdate = $_POST["userIdToUpdate"];
        $newFirstName = $_POST["newFirstName"];

        $sql = "UPDATE tblusers SET FirstName=? WHERE ID=?";
        
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $newFirstName, $userIdToUpdate);

        if ($stmt->execute()) {
            // Redirect to a new page
            header("Location: success.html");
            exit();
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        $stmt->close();
    } elseif ($action == "delete") {
        // Process the "Delete User" form submission
        $userIdToDelete = $_POST["userIdToDelete"];

        $sql = "DELETE FROM tblusers WHERE ID=?";
        
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $userIdToDelete);

        if ($stmt->execute()) {
            // Redirect to a new page
            header("Location: success.html");
            exit();
        } else {
            echo "Error deleting record: " . $stmt->error;
        }

        $stmt->close();
    }
}

$con->close();
?>
