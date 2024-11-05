<?php 
session_start(); // Start session to manage user login state
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy(); // Destroy the session to log out the user
    header("Location: index.php"); // Redirect to the index page
    exit();
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motor Shop Service Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Welcome to the Motor Shop Service Management System. Add a New Customer!</h1>

    <!-- User Authentication Links -->
    <div class="auth-links">
        <?php if ($isLoggedIn): ?>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! 
                <a href="?logout=true">Logout</a>
            </p>
        <?php else: ?>
            <p>
                <a href="register.php">Register</a> | 
                <a href="login.php">Login</a>
            </p>
        <?php endif; ?>
    </div>

    <form action="core/handleForms.php" method="POST">
        <p>
            <label for="firstName">First Name</label>
            <input type="text" name="firstName" required>
        </p>
        <p>
            <label for="lastName">Last Name</label>
            <input type="text" name="lastName" required>
        </p>
        <p>
            <label for="phoneNumber">Phone Number</label>
            <input type="text" name="phoneNumber" required>
        </p>
        <p>
            <label for="email">Email</label>
            <input type="email" name="email" required>
        </p>
        <p>
            <input type="submit" name="insertCustomerBtn" value="Add Customer">
        </p>
    </form>

    <?php $getAllCustomers = getAllCustomers($pdo); ?>
    <?php foreach ($getAllCustomers as $row) { ?>
    <div class="container" style="border-style: solid; width: 60%; margin-top: 20px; padding: 15px;">
        <h3>Customer ID: <?php echo htmlspecialchars($row['CustomerID']); ?></h3>
        <h3>First Name: <?php echo htmlspecialchars($row['FirstName']); ?></h3>
        <h3>Last Name: <?php echo htmlspecialchars($row['LastName']); ?></h3>
        <h3>Phone Number: <?php echo htmlspecialchars($row['PhoneNumber']); ?></h3>
        <h3>Email: <?php echo htmlspecialchars($row['Email']); ?></h3>
        <h3>Date Added: <?php echo htmlspecialchars(date("Y-m-d H:i:s", strtotime($row['DateAdded']))); ?></h3> <!-- Displaying Date Added -->

        <div class="editAndDelete" style="margin-top: 15px;">
            <a href="viewservices.php?customer_id=<?php echo $row['CustomerID']; ?>">View Services</a>
            <a href="editcustomer.php?customer_id=<?php echo $row['CustomerID']; ?>">Edit</a>
            <a href="deletecustomer.php?customer_id=<?php echo $row['CustomerID']; ?>">Delete</a>
        </div>
    </div> 
    <?php } ?>
</body>
</html>
