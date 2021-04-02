<?php
    include_once "bootstrap.php";
    $projectRepository = $entityManager->getRepository('Project');
    $project = $projectRepository->findOneBy(array('id' => $_GET['id']));
    $studentRepository = $entityManager->getRepository('Student');
    $allStudents = $studentRepository->findAll();
    
?>
<form action="" method="POST">
    <input type="text" name="name1" value="<?php echo ($project->getName()) ?>">
<?php
    echo('<select name="myArr[]" multiple="multiple">');
    echo('<option type="checkbox">Remove all students</option>');
    foreach ($allStudents as $student) {
        
        echo ('<option type="checkbox" selected value="' . $student->getId() . '">' . $student->getName()??"" . '</option>');
    }
    // while($row = mysqli_fetch_assoc($allStudents)) {
    //     // $sql = "select * from project_student where project_id ='".$id."' and student_id = '".$row["id"]."'";
    //     // $exec = $conn->query($sql);
    //     $exist = mysqli_num_rows($exec) > 0?"selected":"";
    //     // echo ('<input type="checkbox" name="' . $row["id"] . '" '.$exist.' value="' . $row["id"] . '">' . $row["student_name"] . '</input>');
    //     echo ('<option type="checkbox" '.$exist.' value="' . $row["id"] . '">' . $row["student_name"] . '</option>');
    // }
    echo('</select>');
?>
    <input type="submit" value="Update">
</form>
