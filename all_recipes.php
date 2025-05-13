
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>All Recipes | BeRecipes</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet"/>
  <style>
    body, * { margin: 0; padding: 0; font-family: 'Montserrat', sans-serif; box-sizing: border-box; }
    header { background: #1c1b27; padding: 20px 10%; display: flex; justify-content: space-between; align-items: center; }
    .logo { color: #fff; font-size: 28px; font-weight: bold; }
    nav a { color: #ccc; text-decoration: none; margin: 0 10px; }
    nav a:hover, nav a.active { color: #fff; font-weight: bold; }
    .container { padding: 50px 10%; }
    h2 { margin-bottom: 20px; color: #2c2c2c; }
    .recipe-category { margin-bottom: 40px; }
    .recipe-category h3 { color: #444; margin-bottom: 10px; }
    .recipe-box { background: #f5f5f5; padding: 20px; border-radius: 10px; margin-bottom: 20px; }
    .recipe-box h4 { margin-bottom: 10px; }
    .recipe-box p { margin: 5px 0; }
    .btn-buy {
      background: #00c851;
      color: #fff;
      padding: 8px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .btn-update {
      background: #ffbb33;
      color: #fff;
      padding: 8px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 10px;
    }
    .btn-update:hover {
      background: #ff8800;
    }
    .recipe-actions {
      margin-top: 15px;
    }
  </style>
</head>
<body>
<header>
    <div class="logo">ChefDesk</div>
    <nav>
      <a href="index.html" class="active">Home</a>
      <a href="add_recipe.html">Add Recipe</a>
      <a href="search_recipe.php">Search Recipe</a>
      <a href="remove_recipe.php">Delete Recipe</a>
    </nav>
   <button class="btn-buy"onclick="window.location.href='all_recipes.php'">Explore Recipes</button>
  </header>

  <div class="container">
    <h2>All Recipes</h2>

    <?php
    // Database connection
    $con = mysqli_connect('localhost', 'root', '', 'recipe_db');
    if (!$con) {
        echo "<p>Failed to connect to the database.</p>";
        exit;
    }

    // Define recipe categories and their corresponding tables
    $categories = [
        "Breakfast Recipes" => "breakfast_recipes",
        "Lunch Recipes" => "lunch_recipes",
        "Dinner Recipes" => "dinner_recipes"
    ];

    // Loop through each category and fetch recipes
    foreach ($categories as $category_name => $table_name) {
        echo "<div class='recipe-category'>";
        echo "<h3>$category_name</h3>";

        $sql = "SELECT * FROM $table_name";
        $result = mysqli_query($con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='recipe-box'>";
                echo "<h4>" . htmlspecialchars($row['name']) . "</h4>";
                echo "<p><strong>Ingredients:</strong> " . nl2br(htmlspecialchars($row['ingredients'])) . "</p>";
                echo "<p><strong>Instructions:</strong> " . nl2br(htmlspecialchars($row['instructions'])) . "</p>";
                
                // Add Update button
                echo "<div class='recipe-actions'>";
                echo "<button class='btn-update' onclick=\"window.location.href='update_recipe.php?type=" . urlencode($table_name) . "&id=" . $row['recipe_id'] . "'\">Update Recipe</button>";
                echo "</div>";
                
                echo "</div>";
            }
        } else {
            echo "<p>No recipes found in this category.</p>";
        }

        echo "</div>";
    }

    mysqli_close($con);
    ?>
  </div>
</body>
</html>
