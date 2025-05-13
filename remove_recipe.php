<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Remove Recipe | BeRecipes</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet"/>
  <style>
    body, * {
      margin: 0;
      padding: 0;
      font-family: 'Montserrat', sans-serif;
      box-sizing: border-box;
    }

    header {
      background: #1c1b27;
      padding: 20px 10%;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      color: #fff;
      font-size: 28px;
      font-weight: bold;
    }

    nav a {
      color: #ccc;
      text-decoration: none;
      margin: 0 10px;
    }

    nav a:hover, nav a.active {
      color: #fff;
      font-weight: bold;
    }

    .container { padding: 50px 10%; }

    h2 {
      margin-bottom: 20px;
      color: #2c2c2c;
    }

    form {
      background: #f5f5f5;
      padding: 30px;
      border-radius: 10px;
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: 600;
    }

    input, select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      margin-top: 20px;
      background: #ff4444;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 4px;
      cursor: pointer;
    }

    button:hover {
      background: #cc0000;
    }

    .message {
      margin-top: 20px;
      padding: 15px;
      border-radius: 5px;
      font-weight: bold;
    }

    .success {
      background: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .error {
      background: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }
    .btn-buy {
      background: #00c851;
      color: #fff;
      padding: 8px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
  </style>
</head>
<body>
<header>
    <div class="logo">ChefDesk</div>
    <nav>
      <a href="index.html" >Home</a>
      <a href="add_recipe.html">Add Recipe</a>
      <a href="search_recipe.php">Search Recipe</a>
      <a href="remove_recipe.php" class="active">Delete Recipe</a>
    </nav>
   <button class="btn-buy"onclick="window.location.href='all_recipes.php'">Explore Recipes</button>
  </header>

  <div class="container">
    <h2>Remove a Recipe by Name</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $recipe_name = $_POST['recipe_name'];
      $recipe_type = $_POST['recipe_type'];

      if (!empty($recipe_name) && !empty($recipe_type)) {
        // Connect to DB
        $con = mysqli_connect('localhost', 'root', '', 'recipe_db');

        if (!$con) {
          echo "<div class='message error'>Database connection failed.</div>";
        } else {
          // Escape string
          $recipe_name = mysqli_real_escape_string($con, $recipe_name);
          $table_name = "";

          if ($recipe_type == "breakfast") $table_name = "breakfast_recipes";
          else if ($recipe_type == "lunch") $table_name = "lunch_recipes";
          else if ($recipe_type == "dinner") $table_name = "dinner_recipes";

          // Attempt deletion
          $sql = "DELETE FROM $table_name WHERE name = '$recipe_name'";
          $result = mysqli_query($con, $sql);

          if ($result && mysqli_affected_rows($con) > 0) {
            echo "<div class='message success'>Recipe <strong>$recipe_name</strong> deleted successfully from <strong>$recipe_type</strong>.</div>";
          } else {
            echo "<div class='message error'>No recipe found with name <strong>$recipe_name</strong> in <strong>$recipe_type</strong>.</div>";
          }

          mysqli_close($con);
        }
      } else {
        echo "<div class='message error'>Please fill in all fields.</div>";
      }
    }
    ?>

    <form action="" method="post">
      <label for="recipe_name">Recipe Name:</label>
      <input type="text" name="recipe_name" required>

      <label for="recipe_type">Meal Type:</label>
      <select name="recipe_type" required>
        <option value="">Select type</option>
        <option value="breakfast">Breakfast</option>
        <option value="lunch">Lunch</option>
        <option value="dinner">Dinner</option>
      </select>

      <button type="submit">Delete Recipe</button>
    </form>
  </div>
</body>
</html>