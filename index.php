<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Animal Adoption System _ Assignment01</title>
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
    <!-- Parent Section for both Header and Register -->
    <div class="hero-section">

      <!-- Animal Registration Form -->
      <section class="register">
        <h1 class="adoption-statement">Give a Lifelong Friend a Home</h1>

        <div class="container">
          <h2>Register a New Animal</h2>

          <form method="POST" enctype="multipart/form-data">
            <div class="form-item">
              <label for="animalname">Animal Name:</label>
              <input type="text" id="animalname" name="animalname" required>
            </div>

            <div class="form-item">
              <label for="animalage">Age:</label>
              <input type="number" id="animalage" name="animalage" required>
            </div>

            <div class="form-item">
              <label>Animal Type:</label>
              <select name="type">
                <option value="Dog">Dog</option>
                <option value="Cat">Cat</option>
                <option value="Bird">Bird</option>
                <option value="Rabbit">Rabbit</option>
              </select>
            </div>


            <div class="form-item">
              <label for="animalsex">Sex:</label>
              <select name="animalsex" id="animalsex" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
            </div>

            <div class="form-item">
              <label for="animalimage">Animal Image:</label>
              <input type="file" id="animalimage" name="animalimage" accept="image/*" required>
            </div>

            <div class="form-item">
              <input type="submit" name="submitbtn" value="Register Animal">
            </div>
          </form>
        </div>
      </section>

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

      // Insert new animal record into database when form is submitted
      if (isset($_POST['submitbtn'])) {
        $animalname = $_POST['animalname'];
        $animalage = $_POST['animalage'];
        $animaltype = $_POST['type'];
        $animalsex = $_POST['animalsex'];

        // Handle image upload
        $image_path = 'uploads/' . basename($_FILES['animalimage']['name']);

        if (move_uploaded_file($_FILES['animalimage']['tmp_name'], $image_path)) {
          // Prepare and bind the SQL query to insert the data
          $request = $connection->prepare("INSERT INTO animals(name, age, type, sex, image_path) VALUES(?, ?, ?, ?, ?)");
          $request->bind_param("sisss", $animalname, $animalage, $animaltype, $animalsex, $image_path);

          // Execute the query and check if the data was inserted
          if ($request->execute()) {
            echo "<script>alert('Your animal has been successfully registered!'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
            exit();
          } else {
            echo "<script>alert('Error registering the animal.');</script>";
          }
        } else {
          echo "<script>alert('Failed to upload image.');</script>";
        }
      }

      // Delete an animal record when the delete button is clicked
      if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $delete = $connection->prepare("DELETE FROM animals WHERE id = ?");
        $delete->bind_param("i", $id);

        if ($delete->execute()) {
          echo "Delete Worked";

        } else {
          echo "Delete didnt Work";
        }
        header("Location: index.php");
      }

      // Retrieve all animal records from the database
      $sql = "SELECT * FROM animals";
      $listing = $connection->query($sql);
      ?>

      <!-- Display Animal Cards -->
      <section class="listing" id="list">
        <div class="container">
          <h2>Adopt a Friend Today!</h2>

          <div class="listing-grid">

            <?php
            while ($row = $listing->fetch_assoc()) {
              ?>

              <article class="animal-card">

                <a href="animal.php?id=<?php echo $row['id']; ?>" class="animal-link">

                  <!-- <h3>ID: <?php echo $row['id']; ?></h3> -->

                  <img src="<?php echo $row['image_path']; ?>" alt="Animal Image">
                  <h3>Name: <?php echo $row['name']; ?></h3>
                  <p>Age: <?php echo $row['age']; ?> years</p>
                  <p>Type: <?php echo $row['type']; ?></p>
                  <p>Sex: <?php echo ucfirst($row['sex']); ?></p>

                  <!-- Delete Button -->
                  <a href="javascript:void(0);" class="btn-delete"
                    onclick="confirmDelete(<?php echo $row['id']; ?>);">Delete</a>

                  <!-- Edit Button -->
                  <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
              </article>

            <?php } ?>

          </div>
        </div>
      </section>

      <script>
        function confirmDelete(id) {
          if (confirm(`Are you sure you want to delete this animal? : ${id}`)) {
            window.location.href = "index.php?delete=" + id;
          }
        }
      </script>

  </main>

  <footer>
  <img src="footer.png" alt="Image" class="footer-image">
  <div class="footer-text">
    <p>&copy; 2025 Best friends</p>
    </div>
  
  </footer>
  </div>

</body>

</html>