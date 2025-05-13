<?php
$HOSTNAME = 'localhost';
$USERNAME = 'root';
$PASSWORD = '';
$DATABASE = 'recipe_db'; // Use your database name here

$con = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipe_name = mysqli_real_escape_string($con, $_POST['recipe_name']);
    $recipe_type = mysqli_real_escape_string($con, $_POST['recipe_type']); // breakfast, lunch, dinner

    // Set the table based on type
    $table_name = '';
    if ($recipe_type === 'breakfast') {
        $table_name = 'breakfast_recipes';
    } elseif ($recipe_type === 'lunch') {
        $table_name = 'lunch_recipes';
    } elseif ($recipe_type === 'dinner') {
        $table_name = 'dinner_recipes';
    }

    if ($table_name != '') {
        $sql = "DELETE FROM $table_name WHERE name = '$recipe_name'";

        if (mysqli_query($con, $sql)) {
            echo "Recipe deleted successfully.";
        } else {
            echo "Error deleting recipe: " . mysqli_error($con);
        }
    } else {
        echo "Invalid recipe type.";
    }
}

mysqli_close($con);
?>
