<?php
include 'db_connect.php';

// Get the meal type from the query parameter (breakfast, lunch, dinner)
$meal_type = isset($_GET['meal_type']) ? $_GET['meal_type'] : 'breakfast';
$table = $meal_type . '_recipes'; // Dynamically set table name

// Get recipes from the selected table
$sql = "SELECT * FROM $table";
$result = mysqli_query($con, $sql);

echo "<h1>" . ucfirst($meal_type) . " Recipes</h1>";

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='recipe'>";
        echo "<h3>" . $row['name'] . "</h3>";
        echo "<p><strong>Ingredients:</strong><br>" . $row['ingredients'] . "</p>";
        echo "<p><strong>Instructions:</strong><br>" . $row['instructions'] . "</p>";
        echo "</div>";
    }
} else {
    echo "No recipes found!";
}
?>
