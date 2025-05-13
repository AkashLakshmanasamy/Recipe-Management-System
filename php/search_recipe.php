<?php
include('db_connect.php');
session_start();

$meal_type = $_POST['meal_type'];
$keyword = $_POST['keyword'];

$table_name = $meal_type . "_recipes";

$sql = "SELECT * FROM $table_name WHERE name LIKE '%$keyword%' OR ingredients LIKE '%$keyword%'";
$result = mysqli_query($con, $sql);

$recipes = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $recipes[] = $row;
    }
}

$_SESSION['search_results'] = $recipes;
mysqli_close($con);
header("Location: ../search_recipe.php");
exit;
?>
