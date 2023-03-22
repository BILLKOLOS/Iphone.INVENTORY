<?php
// Connect to the database
$conn = mysqli_connect("localhost", "username", "password", "inventory");

// Check if the connection was successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Get the current inventory levels
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
  // Loop through each row
  while ($row = mysqli_fetch_assoc($result)) {
    // Check if the inventory level is low
    if ($row['quantity'] < 5) {
      // Send an email notification to the admin
      $to = "admin@example.com";
      $subject = "Low inventory alert";
      $message = "The inventory level for " . $row['model'] . " is low. Current quantity: " . $row['quantity'];
      $headers = "From: webmaster@example.com\r\n";
      mail($to, $subject, $message, $headers);
    }
  }
}

// Add a product to the cart
if (isset($_POST['add_to_cart'])) {
  // Get the product ID and quantity from the form
  $product_id = $_POST['product_id'];
  $quantity = $_POST['quantity'];

  // Check if the product ID and quantity are valid
  if (!is_numeric($product_id) || !is_numeric($quantity) || $quantity <= 0) {
    // Display an error message
    echo "Invalid input";
  } else {
    // Check if the product is in stock
    $sql = "SELECT * FROM products WHERE id = $product_id AND quantity >= $quantity";
    $result = mysqli_query($conn, $sql);

    // Check if there are any results
    if (mysqli_num_rows($result) > 0) {
      // Add the product to the cart
      $_SESSION['cart'][$product_id] = $quantity;
      echo "Product added to cart";
    } else {
      // Display an error message
      echo "Product is out of stock";
    }
  }
}

// Update the inventory level
if (isset($_POST['update_inventory'])) {
  // Get the product ID and new quantity from the form
  $product_id = $_POST['product_id'];
  $new_quantity = $_POST['new_quantity'];

  // Check if the product ID and new quantity are valid
  if (!is_numeric($product_id) || !is_numeric($new_quantity) || $new_quantity < 0) {
    // Display an error message
    echo "Invalid input";
  } else {
    // Update the inventory level in the database
    $sql = "UPDATE products SET quantity = $new_quantity WHERE id = $product_id";
    $result = mysqli_query($conn, $sql);

    // Check if the update was successful
    if ($result) {
      echo "Inventory level updated";
    } else {
      echo "Error updating inventory level: " . mysqli_error($conn);
    }
  }
}

// Close the database connection
mysqli_close($conn);
?>

