<?php
include 'db_connect.php'; // Include connection file

// Fetch all products
$sql = "SELECT id, name, quantity, price FROM products ORDER BY id DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple Inventory - Home</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Product Inventory Management</h1>
    <p><a href="create_product.php">Add New Product</a></p>
    
    <h2>Current Products</h2>
    
    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>Quantity</th><th>Price</th></tr>";
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"]. "</td>";
            echo "<td>" . htmlspecialchars($row["name"]). "</td>";
            echo "<td>" . $row["quantity"]. "</td>";
            echo "<td>$" . number_format($row["price"], 2). "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No products found in the inventory.</p>";
    }
    
    close_db_connection($conn); // Close the connection
    ?>
</body>
</html>