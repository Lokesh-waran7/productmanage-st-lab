<?php
include 'db_connect.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Input Validation (a great place for Unit Tests!)
    $name = trim($_POST['name']);
    $quantity = trim($_POST['quantity']);
    $price = trim($_POST['price']);

    if (empty($name) || empty($quantity) || empty($price)) {
        $message = "<p style='color: red;'>All fields are required.</p>";
    } elseif (!is_numeric($quantity) || $quantity <= 0) {
        $message = "<p style='color: red;'>Quantity must be a positive number.</p>";
    } elseif (!is_numeric($price) || $price < 0) {
        $message = "<p style='color: red;'>Price must be a valid number.</p>";
    } else {
        // Prepare data for insertion
        $name = $conn->real_escape_string($name); // Basic security sanitization
        $quantity = (int)$quantity;
        $price = (float)$price;
        
        // 2. Database Insertion
        $sql = "INSERT INTO products (name, quantity, price) VALUES ('$name', '$quantity', '$price')";

        if ($conn->query($sql) === TRUE) {
            $message = "<p style='color: green;'>New product added successfully!</p>";
            // Redirect back to the main page to show the new product
            header("Location: index.php");
            exit();
        } else {
            $message = "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
    }
}

close_db_connection($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Product</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-container { width: 300px; padding: 15px; border: 1px solid #ccc; }
        label { display: block; margin-top: 10px; }
        input[type="text"] { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; }
        input[type="submit"] { margin-top: 20px; padding: 10px 15px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Add New Product</h1>
    <p><a href="index.php">Back to Inventory</a></p>
    
    <?php echo $message; // Display success or error messages ?>

    <div class="form-container">
        <form action="create_product.php" method="post">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="quantity">Quantity:</label>
            <input type="text" id="quantity" name="quantity" required>

            <label for="price">Price ($):</label>
            <input type="text" id="price" name="price" required>

            <input type="submit" value="Add Product">
        </form>
    </div>
</body>
</html>