<?php
include 'includes/session.php';

if (isset($_POST['employee_id'])) {
    include 'function_count_justified_and_unjustified_absences.php';
    $employee_id = $_POST['employee_id'];
    $result = cantFaltas($employee_id);
    echo $result;
}
?>