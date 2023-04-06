<?php
    // Database configuration
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "inventory";

    try {
        // Create a new connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            echo "Connected successfully<br>";
        }

        // Create operation using prepared statement
        $stmt = $conn->prepare("INSERT INTO products (name, price, quantity) VALUES (?, ?, ?)");

        $name = "Product 1";
        $price = 10.99;
        $quantity = 5;

        $stmt->bind_param("sdi", $name, $price, $quantity);

        if ($stmt->execute()) {
            echo "New record created successfully<br>";
        } else {
            throw new Exception("Error: " . $stmt->error);
        }

        // Read operation
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "ID: " . $row["id"] . " - Name: " . $row["name"] . " - Price: " . $row["price"] . " - Quantity: " . $row["quantity"] . "<br>";
            }
        } else {
            echo "0 results<br>";
        }

        // Update operation using prepared statement
        $stmt = $conn->prepare("UPDATE products SET price = ? WHERE id = ?");

        $price = 9.99;
        $id = 1;

        $stmt->bind_param("di", $price, $id);

        if ($stmt->execute()) {
            echo "Record updated successfully<br>";
        } else {
            throw new Exception("Error updating record: " . $stmt->error);
        }

        // Delete operation using prepared statement
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");

        $id = 2;

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Record deleted successfully<br>";
        } else {
            throw new Exception("Error deleting record: " . $stmt->error);
        }

        // Close connection
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "<br>";
    }
?>

