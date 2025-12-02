<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = htmlspecialchars(trim($_POST['customer_name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $product_name = htmlspecialchars(trim($_POST['product_name']));
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);

    if (empty($customer_name) || empty($email) || empty($product_name) || $quantity <= 0 || $price <= 0) {
        echo "All fields must be correctly filled.";
        exit;
    }

    $sql = "INSERT INTO orders (customer_name, email, product_name, quantity, price)
            VALUES (:customer_name, :email, :product_name, :quantity, :price)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':customer_name', $customer_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':product_name', $product_name);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':price', $price);

    if ($stmt->execute()) {
        echo "Order placed successfully!";
    } else {
        echo "Error placing the order.";
    }
}   
?>
