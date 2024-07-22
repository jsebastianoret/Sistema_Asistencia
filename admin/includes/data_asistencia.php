<?php
include 'conn.php';

$current_date = date('Y-m-d');
$current_date >= '2023-03-24'
    ? $add_time = '00:05:00'
    : $add_time = '00:15:00';

$table = "employees";
$id = "";
if (isset($_POST['paid'])) {
    $table = "papelera";
    $id = "WHERE e.id = {$_POST['paid']}";
} else if (isset($_POST['id'])) {
    $id = "WHERE e.id = {$_POST['id']}";
}

$sql = "SELECT a.*, e.*, n.*, p.*, e.employee_id AS empid,
    CASE WHEN ADDTIME(s.time_in, '$add_time') >= a.time_in THEN 1
    WHEN ADDTIME(s.time_in, '$add_time') <= a.time_in THEN 0
    END AS status_v1, a.id AS attid
FROM attendance a
RIGHT JOIN $table e ON e.id = a.employee_id
LEFT JOIN position p ON p.id = e.position_id
LEFT JOIN negocio n ON n.id = e.negocio_id
LEFT JOIN schedules s ON s.id = e.schedule_id
$id
ORDER BY a.date DESC, a.time_in DESC";
$query = $conn->query($sql);

if (isset($_POST['id']) || isset($_POST['paid'])) {
    $row = $query->fetch_all(MYSQLI_ASSOC);
    echo json_encode($row);
}
?>