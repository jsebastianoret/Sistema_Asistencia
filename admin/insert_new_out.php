<?php
include 'includes/session.php';

if (isset($_POST['employee_id']) && isset($_POST['new_out'])) {
    $employeeId = $_POST['employee_id'];
    $newDateOut = $_POST['new_out'];

    $sql = "UPDATE employees SET date_out_new='$newDateOut' WHERE id='$employeeId'";
    $query = $conn->query($sql);

} else {
    echo json_encode(['error' => 'Datos insuficientes']);
}
?>
