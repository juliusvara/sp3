<?php
    include_once "bootstrap.php";
    $studentRepository = $entityManager->getRepository('Student');
    $student = $studentRepository->findOneBy(array('id' => $_GET['id']));
    $projectRepository = $entityManager->getRepository('Project');
    $allProjects = $projectRepository->findAll();
?>
<form action="" method="POST">
    <input type="text" name="name1" value="<?php echo ($student->getName()) ?>">
<?php
    echo('<select name="myArr">');
    foreach ($allProjects as $project) {
        $exist = $student->getProject()==$project?"selected":"";
        echo ('<option type="checkbox" '.$exist.' value="' . $project->getId() . '">' . $project->getName() . '</option>');
    }
    echo('</select>');
?>
    <input type="submit" value="Update">
</form>