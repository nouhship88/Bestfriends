<?php
// Database connection settings
$server = "localhost";
$user = "root";
$pass = "";
$db = "bestfriebds";

// Create the connection
$connection = new mysqli($server, $user, $pass, $db);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get the animal id from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query to fetch the animal details
    $query = "SELECT * FROM animals WHERE id = $id";
    $result = $connection->query($query);

    // If the animal exists
    if ($result->num_rows > 0) {
        $animal = $result->fetch_assoc();
    } else {
        // If no animal found with the given ID
        echo "Animal not found!";
        exit();
    }
} else {
    echo "Invalid request!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Animal Details</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
<header>
    <nav class="navbar">
      <a href="index.php">
        <img src="logo1.png" alt="Best Friend Animal Logo" class="logo">
      </a>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="#list">Adopt</a></li>
        <li><a href="#">Donate</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
      <div class="menu-toggle">&#9776;</div>
    </nav>
  </header>

    <main>
        <section class="animal-details">
            <div class="container">
                <h1><?php echo $animal['name']; ?></h1>
                <img src="<?php echo $animal['image_path']; ?>" alt="Animal Image" style="width: 300px; height: 300px;">
                <p><strong>Age:</strong> <?php echo $animal['age']; ?> years</p>
                <p><strong>Type:</strong> <?php echo $animal['type']; ?></p>
                <p><strong>Sex:</strong> <?php echo ucfirst($animal['sex']); ?></p>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Best friends</p>
    </footer>
</body>

</html>
