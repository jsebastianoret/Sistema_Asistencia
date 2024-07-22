<?php
include 'includes/conn.php';
$id = $_POST['id'];
$employeeId = $_POST['employeeId'];

$checkQuery = "SELECT * FROM reactions WHERE employee_id = '$employeeId' AND publication_id = '$id'";
$checkResult = $conn->query($checkQuery);

if ($checkResult->num_rows === 0) {
    $insertQuery = "INSERT INTO reactions (employee_id, publication_id) VALUES ('$employeeId', '$id')";
    $insertResult = $conn->query($insertQuery);
} else {
    $deleteQuery = "DELETE FROM reactions WHERE employee_id = '$employeeId' AND publication_id = '$id'";
    $deleteResult = $conn->query($deleteQuery);
}
$countQuery = "SELECT COUNT(*) AS reaction_count FROM reactions WHERE publication_id = '$id'";
$countResult = $conn->query($countQuery);

if ($countResult) {
    $row = $countResult->fetch_assoc();
    $reactionCount = $row['reaction_count'];
    $updateQuery = "UPDATE publications SET reactions = '$reactionCount' WHERE id = '$id'";
    $updateResult = $conn->query($updateQuery);

    if ($updateResult) {
        echo $reactionCount;
    } else {
        echo "Error al actualizar la tabla publications: " . $conn->error;
    }
} else {
    echo "Error al contar las reacciones: " . $conn->error;
}
?>
