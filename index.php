<?php
    include_once "bootstrap.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
</head>
<style>
    a {
        text-decoration: none;
    }
</style>

<body>
        <ul>
            <li>
                <a href="./?path=project">Project</a>
            </li>
            <li>
                <a href="./?path=student">Student</a>
            </li>
        </ul>
<?php 
    $path = $_GET['path']??"project";
    if ($path == "project") {
        include("./src/project_view.php");
    } else if ($path == "student") {
        include("./src/student_view.php");
    }
?>
</body>

</html>