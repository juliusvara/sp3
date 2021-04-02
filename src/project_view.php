<?php
include_once "bootstrap.php";

function redirect_to_root() {
    header("location:./?path=project");
}
if (isset($_POST['name']) != "") {
    $projectRepository = $entityManager->getRepository('Project');
    if (!$projectRepository->findOneBy(array('name' => $_POST['name']))) {
        $project = new Project();
        $project->setName($_POST['name']);
        $entityManager->persist($project);
        $entityManager->flush();
    }
}
if ($_GET['action'] == 'delete') {
    $projectRepository = $entityManager->getRepository('Project');
    $project = $projectRepository->findOneBy(array('id' => $_GET['id']));
    $entityManager->remove($project);
    $entityManager->flush();
    redirect_to_root();
}
if ($_GET['action'] == 'update') {
    if (isset($_POST['name1'])) {
        $projectRepository = $entityManager->getRepository('Project');
        $project = $projectRepository->findOneBy(array('id' => $_GET['id']));
        $project->setName($_POST['name1']);

        //     $sql = "update project set project_name ='" . $_POST['name1'] . "' where id =" . $_GET['id'];
        //     $conn->query($sql);
        $values = $_POST['myArr'];
        $students = array();
        $studentRepository = $entityManager->getRepository('Student');

        foreach ($values as $value) {
            $students[$value] = $studentRepository->findOneBy(array('id' => $value));
        }
        $flagToRemoveAllStudents = false;
        foreach ($values as $value) {
            if ($value == "Remove all students") {
                $flagToRemoveAllStudents = true;
                break;
            }
            // $sql = "select * from project_student where project_id=" . $_GET['id'] . " and student_id=" . $value;
            if (!in_array($students[$value], $project->getStudents())) {
                $project->addStudent($students[$value]);
            }
            // $result = $conn->query($sql);
            // if (mysqli_num_rows($result) === 0) {
            //     $sql = "insert into project_student (project_id, student_id) values (" . $_GET['id'] . ", " . $value . ")";
            //     $conn->query($sql);
            // }
        }
        // $sql = "select * from project_student where project_id=" . $_GET['id'];
        foreach ($project->getStudents() as $student) {
            if (!in_array($student, $students) || $flagToRemoveAllStudents) {
                $project->remStudent($student);
            }
        }
        // $result = $conn->query($sql);
        // while ($row = mysqli_fetch_assoc($result)) {
        //     if (!in_array($row['student_id'], $values) || $flagToRemoveAllStudents) {
        //         $sql = "delete from project_student where student_id = " . $row['student_id'] . " and project_id = " . $_GET['id'];
        //         $conn->query($sql);
        //     }
        // }
        $entityManager->persist($project);
        $entityManager->flush();
        redirect_to_root();
        // exit;
    }
}
?>
<table>
    <thead>
        <th>Id</th>
        <th>Project name</th>
        <th>Student name</th>
        <th>Actions</th>
    </thead>
    <?php
    $projectRepository = $entityManager->getRepository('Project');
    $projects = $projectRepository->findAll();
    foreach ($projects as $project) {
        $students = $project->getStudents();
        $studentNames = "";
        foreach ($students as $student) {
            $studentNames .= $student->getName() . ", ";
        }
        $studentNames = substr_replace($studentNames, "", -2);
    ?>
            <tr>
                <td><?php echo $project->getId() ?></td>
                <td><?php echo $project->getName() ?></td>
                <td><?php echo $studentNames ?></td>
                <td><button><a href='./?path=project&action=delete&id=<?php echo ($project->getId()) ?>'>Delete</a></button><button><a href="./?path=project&action=update&id=<?php echo ($project->getId()) ?>">Update</a></button></td>
            </tr>
    <?php }
    ?>
</table>
<form action="" method="POST">
    <input type="text" id="name" name="name" placeholder="add project">
    <input type="submit" value="add">
</form>
<?php
if ($_GET['action'] == 'update' && !isset($_POST['name1'])) {
    include("update_project.php");
}
?>