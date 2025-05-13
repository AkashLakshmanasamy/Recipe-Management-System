<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Update Recipe | BeRecipes</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet"/>
  <style>
    body, * { margin: 0; padding: 0; font-family: 'Montserrat', sans-serif; box-sizing: border-box; }
    header { background: #1c1b27; padding: 20px 10%; display: flex; justify-content: space-between; align-items: center; }
    .logo { color: #fff; font-size: 28px; font-weight: bold; }
    nav a { color: #ccc; text-decoration: none; margin: 0 10px; }
    nav a:hover, nav a.active { color: #fff; font-weight: bold; }
    .container { padding: 50px 10%; }
    h2 { margin-bottom: 20px; color: #2c2c2c; }
    form { background: #f5f5f5; padding: 30px; border-radius: 10px; }
    label { display: block; margin-top: 15px; font-weight: 600; }
    input, textarea, select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
    button { margin-top: 20px; background: #00c851; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; }
    button:hover { background: #009944; }
    .btn-buy {
      background: #00c851;
      color: #fff;
      padding: 8px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .message {
      margin-bottom: 20px;
      padding: 15px;
      border-radius: 5px;
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
  </style>
</head>
<body>
<header>
    <div class="logo">ChefDesk</div>
    <nav>
      <a href="index.html">Home</a>
      <a href="add_recipe.html">Add Recipe</a>
      <a href="search_recipe.php">Search Recipe</a>
      <a href="remove_recipe.php">Delete Recipe</a>
    </nav>
    <button class="btn-buy" onclick="window.location.href='all_recipes.php'">Explore Recipes</button>
  </header>

  <div class="container">
    <h2>Update Recipe</h2>

    <?php
    // Database connection
    $con = mysqli_connect('localhost', 'root', '', 'recipe_db');
    if (!$con) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Check if we're viewing or updating a recipe
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['type']) && isset($_GET['id'])) {
        $table_name = $_GET['type'];
        $recipe_id = intval($_GET['id']);

        // Fetch the recipe
        $sql = "SELECT * FROM $table_name WHERE recipe_id = $recipe_id";
        $result = mysqli_query($con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $recipe = mysqli_fetch_assoc($result);
            
            // Display the form
            echo '<form action="update_recipe.php" method="post">';
            echo '<input type="hidden" name="table_name" value="' . htmlspecialchars($table_name) . '">';
            echo '<input type="hidden" name="recipe_id" value="' . htmlspecialchars($recipe_id) . '">';
            
            echo '<label for="name">Recipe Name:</label>';
            echo '<input type="text" name="name" value="' . htmlspecialchars($recipe['name']) . '" required>';
            
            echo '<label for="ingredients">Ingredients:</label>';
            echo '<textarea name="ingredients" rows="4" required>' . htmlspecialchars($recipe['ingredients']) . '</textarea>';
            
            echo '<label for="instructions">Instructions:</label>';
            echo '<textarea name="instructions" rows="4" required>' . htmlspecialchars($recipe['instructions']) . '</textarea>';
            
            echo '<button type="submit">Update Recipe</button>';
            echo '</form>';
        } else {
            echo '<div class="message error">Recipe not found.</div>';
        }
    } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle form submission
        $table_name = $_POST['table_name'];
        $recipe_id = intval($_POST['recipe_id']);
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $ingredients = mysqli_real_escape_string($con, $_POST['ingredients']);
        $instructions = mysqli_real_escape_string($con, $_POST['instructions']);

        $sql = "UPDATE $table_name SET 
                name = '$name',
                ingredients = '$ingredients',
                instructions = '$instructions'
                WHERE recipe_id = $recipe_id";

        if (mysqli_query($con, $sql)) {
            echo '<div class="message success">Recipe updated successfully!</div>';
            // Show the form again with updated values
            echo '<form action="update_recipe.php" method="post">';
            echo '<input type="hidden" name="table_name" value="' . htmlspecialchars($table_name) . '">';
            echo '<input type="hidden" name="recipe_id" value="' . htmlspecialchars($recipe_id) . '">';
            
            echo '<label for="name">Recipe Name:</label>';
            echo '<input type="text" name="name" value="' . htmlspecialchars($name) . '" required>';
            
            echo '<label for="ingredients">Ingredients:</label>';
            echo '<textarea name="ingredients" rows="4" required>' . htmlspecialchars($ingredients) . '</textarea>';
            
            echo '<label for="instructions">Instructions:</label>';
            echo '<textarea name="instructions" rows="4" required>' . htmlspecialchars($instructions) . '</textarea>';
            
            echo '<button type="submit">Update Recipe</button>';
            echo '</form>';
        } else {
            echo '<div class="message error">Error updating recipe: ' . mysqli_error($con) . '</div>';
        }
    } else {
        echo '<div class="message error">Invalid request.</div>';
    }

    mysqli_close($con);
    ?>
  </div>
</body>
</html>