<?php
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipe_id = intval($_POST['recipe_id']);
    $meal_type = $_POST['meal_type'];

    // Select table name based on meal type
    if ($meal_type === 'breakfast') {
        $table = "breakfast_recipes";
    } elseif ($meal_type === 'lunch') {
        $table = "lunch_recipes";
    } elseif ($meal_type === 'dinner') {
        $table = "dinner_recipes";
    } else {
        header("Location: ../remove_recipe.php?status=error");
        exit();
    }

    // Perform deletion
    $sql = "DELETE FROM `$table` WHERE recipe_id = $recipe_id";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_affected_rows($con) > 0) {
        header("Location: ../remove_recipe.php?status=success&meal=$meal_type");
    } else {
        header("Location: ../remove_recipe.php?status=notfound&meal=$meal_type");
    }

    mysqli_close($con);
}
?>
