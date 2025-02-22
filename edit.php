<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Animal Listing</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
</head>

<body>
    <header>
        <nav class="navbar">
            <a href="index.php">
                <img src="logo1.png" alt="Best Friend Animal Logo" class="logo">
            </a>
            <ul class="nav-links">
                <li><a href="#">Home</a></li>
                <li><a href="#list">Adopt</a></li>
                <li><a href="#">Donate</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            <div class="menu-toggle">&#9776;</div>
        </nav>
    </header>

    <main>
        <div class="hero-section">
            <section class="register">
                <h1 class="adoption-statement">Edit Animal Listing</h1>

                <div class="container">
                    <h2>Edit Animal Details</h2>

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

                    // Fetch the animal details based on the ID from the URL
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $sql = "SELECT * FROM animals WHERE id = $id";
                        $result = $connection->query($sql);
                        $row = $result->fetch_assoc();
                    }

                    // Handle form submission for updating the animal details
                    if (isset($_POST['updatebtn'])) {
                        $id = $_POST['id'];
                        $animalname = $_POST['animalname'];
                        $animalage = $_POST['animalage'];
                        $animaltype = $_POST['type'];
                        $animalsex = $_POST['animalsex'];

                        // Handle image upload if a new image is provided
                        if (!empty($_FILES['animalimage']['name'])) {
                            $image_path = 'uploads/' . basename($_FILES['animalimage']['name']);
                            move_uploaded_file($_FILES['animalimage']['tmp_name'], $image_path);
                        } else {
                            $image_path = $row['image_path'];
                        }

                        // Prepare and bind the SQL query to update the data
                        $request = $connection->prepare("UPDATE animals SET name=?, age=?, type=?, sex=?, image_path=? WHERE id=?");
                        $request->bind_param("sisssi", $animalname, $animalage, $animaltype, $animalsex, $image_path, $id);

                        // Execute the query and check if the data was updated
                        if ($request->execute()) {
                            echo "<script>alert('Animal details updated successfully!'); window.location.href='index.php';</script>";
                            exit();
                        } else {
                            echo "<script>alert('Error updating the animal details.');</script>";
                        }
                    }
                    ?>

                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                        <div class="form-item">
                            <label for="animalname">Animal Name:</label>
                            <input type="text" id="animalname" name="animalname" value="<?php echo $row['name']; ?>"
                                required>
                        </div>

                        <div class="form-item">
                            <label for="animalage">Age:</label>
                            <input type="number" id="animalage" name="animalage" value="<?php echo $row['age']; ?>"
                                required>
                        </div>

                        <div class="form-item">
                            <label>Animal Type:</label>
                            <select name="type">
                                <option value="Dog" <?php echo ($row['type'] == 'Dog') ? 'selected' : ''; ?>>Dog</option>
                                <option value="Cat" <?php echo ($row['type'] == 'Cat') ? 'selected' : ''; ?>>Cat</option>
                                <option value="Bird" <?php echo ($row['type'] == 'Bird') ? 'selected' : ''; ?>>Bird
                                </option>
                                <option value="Rabbit" <?php echo ($row['type'] == 'Rabbit') ? 'selected' : ''; ?>>Rabbit
                                </option>
                            </select>
                        </div>

                        <div class="form-item">
                            <label for="animalsex">Sex:</label>
                            <select name="animalsex" id="animalsex" required>
                                <option value="male" <?php echo ($row['sex'] == 'male') ? 'selected' : ''; ?>>Male
                                </option>
                                <option value="female" <?php echo ($row['sex'] == 'female') ? 'selected' : ''; ?>>Female
                                </option>
                            </select>
                        </div>

                        <div class="form-item">
                            <label for="animalimage">Animal Image:</label>
                            <input type="file" id="animalimage" name="animalimage" accept="image/*">
                            <img src="<?php echo $row['image_path']; ?>" alt="Current Image"
                                style="width: 100px; height: 100px;">
                        </div>

                        <div class="form-item">
                            <input type="submit" name="updatebtn" value="Update Animal">
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 Best friends</p>
    </footer>
</body>

</html>