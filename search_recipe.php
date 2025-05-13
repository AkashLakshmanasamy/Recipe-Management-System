<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Search Recipe | BeRecipes</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet"/>
  <style>
    body, * { margin: 0; padding: 0; font-family: 'Montserrat', sans-serif; box-sizing: border-box; }
    header { background: #1c1b27; padding: 20px 10%; display: flex; justify-content: space-between; align-items: center; }
    .logo { color: #fff; font-size: 28px; font-weight: bold; }
    nav a { color: #ccc; text-decoration: none; margin: 0 10px; }
    nav a:hover, nav a.active { color: #fff; font-weight: bold; }
    .container { padding: 50px 10%; }
    h2 { margin-bottom: 20px; color: #2c2c2c; }
    form { background: #f5f5f5; padding: 30px; border-radius: 10px; margin-bottom: 30px; }
    label { display: block; margin-top: 15px; font-weight: 600; }
    input, select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; }
    button { margin-top: 20px; background: #00c851; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; }
    button:hover { background: #009944; }
    .result-box { background: #f0f0f0; padding: 20px; border-radius: 10px; margin-top: 20px; }
    .result-box h3 { margin-bottom: 10px; }
    .no-result { color: #888; font-style: italic; }
    .highlight { background-color: #d4edda; padding: 5px; border-radius: 5px; }
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
      <a href="search_recipe.php" class="active">Search Recipe</a>
      <a href="remove_recipe.php">Delete Recipe</a>
    </nav>
   <button class="btn-buy"onclick="window.location.href='all_recipes.php'">Explore Recipes</button>
  </header>

  <div class="container">
    <h2>Search for a Recipe</h2>
    <form action="php/search_recipe.php" method="post">
      <label for="meal_type">Meal Type:</label>
      <select name="meal_type" required>
        <option value="">Select type</option>
        <option value="breakfast">Breakfast</option>
        <option value="lunch">Lunch</option>
        <option value="dinner">Dinner</option>
      </select>

      <label for="keyword">Recipe Name or Ingredient:</label>
      <input type="text" name="keyword" placeholder="Enter keyword...">

      <button type="submit">Search</button>
    </form>

    <?php
    session_start();
    if (isset($_SESSION['search_results'])) {
        $results = $_SESSION['search_results'];
        unset($_SESSION['search_results']);

        if (count($results) > 0) {
            echo '<h3>Search Results:</h3>';
            foreach ($results as $row) {
                echo '<div class="result-box">';
                echo '<h3>' . htmlspecialchars($row["name"]) . '</h3>';
                echo '<strong>Ingredients:</strong><br>' . nl2br(htmlspecialchars($row["ingredients"])) . '<br><br>';
                echo '<strong>Instructions:</strong><br>' . nl2br(htmlspecialchars($row["instructions"])) . '';
                echo '</div>';
            }
        } else {
            echo '<p class="no-result">No recipes found.</p>';
        }
    }
    ?>
  </div>
</body>
</html>