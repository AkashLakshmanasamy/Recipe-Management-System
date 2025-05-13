<?php
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $ingredients = $_POST['ingredients'] ?? '';
    $instructions = $_POST['instructions'] ?? '';
    $meal_type = $_POST['meal_type'] ?? '';

    // Check for empty fields
    if (empty($name) || empty($ingredients) || empty($instructions) || empty($meal_type)) {
        header("Location: ../add_recipe.html?status=error");
        exit();
    }

    // Determine table name
    $table = '';
    if ($meal_type == 'breakfast') {
        $table = 'breakfast_recipes';
    } elseif ($meal_type == 'lunch') {
        $table = 'lunch_recipes';
    } elseif ($meal_type == 'dinner') {
        $table = 'dinner_recipes';
    } else {
        header("Location: ../add_recipe.html?status=error");
        exit();
    }

    // Insert query
    $sql = "INSERT INTO $table (name, ingredients, instructions) VALUES ('$name', '$ingredients', '$instructions')";

    if (mysqli_query($con, $sql)) {
        header("Location: ../add_recipe.html?status=success");
    } else {
        header("Location: ../add_recipe.html?status=error");
    }

    mysqli_close($con);
}
?>
