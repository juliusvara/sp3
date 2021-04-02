<?php
    include_once "bootstrap.php";
    function redirect_to_root() {
        header("location:./?path=student");
    }
    if(isset($_POST['name']) != "") {
        $studentRepository = $entityManager->getRepository('Student');
        if (!$studentRepository->findOneBy(array('name' => $_POST['name']))) {
            $student = new Student();
            $student->setName($_POST['name']);
            $entityManager->persist($student);
            $entityManager->flush();
        }
    }
    if ($_GET['action'] == 'delete') {
        $studentRepository = $entityManager->getRepository('Student');
        $student = $studentRepository->findOneBy(array('id' => $_GET['id']));
        $entityManager->remove($student);
        $entityManager->flush();
        redirect_to_root();
    }
    if ($_GET['action'] == 'update') {
        $studentRepository = $entityManager->getRepository('Student');
        $student = $studentRepository->findOneBy(array('id' => $_GET['id']));

        if(isset($_POST['name1'])) {
            // $sql = "update student set student_name ='".$_POST['name1']."' where id =" .$_GET['id'];
            // $conn->query($sql);
            $student->setName($_POST['name1']);
            if (isset($_POST['myArr'])) {
                $projectRepository = $entityManager->getRepository('Project');
                $project = $projectRepository->findOneBy(array('id' => $_POST['myArr']));
                $student->setProject($project);
            } else {
                $student->setProject(null);
            }
            $entityManager->persist($student);
            $entityManager->flush();
            redirect_to_root();
        }    
    }
?>
<table>
    <thead>
        <th>Id</th>
        <th>Student name</th>
        <th>Project name</th>
        <th>Actions</th>
    </thead>
    <?php
    $studentRepository = $entityManager->getRepository('Student');
    $students = $studentRepository->findAll();
    foreach ($students as $student) {
        
        ?>
        <tr>
            <td><?php echo $student->getId()?></td>
            <td><?php echo $student->getName()?></td>
            <td><?php echo $student->getProject()?$student->getProject()->getName()??"":"" ?></td>
            <td><button><a href='./?path=student&action=delete&id=<?php echo($student->getId())?>'>Delete</a></button><button><a href="./?path=student&action=update&id=<?php echo($student->getId())?>">Update</a></button></td>
        </tr>
            <?php 
    }
?>
</table>
<form action="" method="POST">
    <input type="text" id="name" name="name" placeholder="add student">
    <input type="submit" value="add">
</form>
<?php 
    if ($_GET['action'] == 'update' && !isset($_POST['name1'])) {
        include("./src/update_student.php");
    }
?>
