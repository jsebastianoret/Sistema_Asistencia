<?php
include 'includes/header-practicante.php';

// Obtener el ID del empleado desde el formulario POST
$employee_id = $_POST['employee_id'];

// Obtener la posición del empleado
$position_sql = "SELECT position_id FROM employees WHERE employee_id = '$employee_id'";
$position_result = $conn->query($position_sql);
$row = $position_result->fetch_assoc();
$position_id = $row['position_id'];

// Consultas SQL para verificar si el empleado ha completado los Tests
$sql1 = "SELECT COUNT(*) AS count FROM respuestas_test r
         INNER JOIN preguntas_test p ON p.id = r.pregunta_id
         WHERE r.employee_id = (SELECT id FROM employees WHERE employee_id = '$employee_id') 
         AND p.test = 1";
$result1 = $conn->query($sql1);
$estado1 = $result1->fetch_assoc();

$sql2 = "SELECT COUNT(*) AS count FROM respuestas_test r
         INNER JOIN preguntas_test p ON p.id = r.pregunta_id
         WHERE r.employee_id = (SELECT id FROM employees WHERE employee_id = '$employee_id') 
         AND p.test = 2";
$result2 = $conn->query($sql2);
$estado2 = $result2->fetch_assoc();

$sql3 = "SELECT COUNT(*) AS count FROM respuestas_test r
         INNER JOIN preguntas_test p ON p.id = r.pregunta_id
         WHERE r.employee_id = (SELECT id FROM employees WHERE employee_id = '$employee_id') 
         AND p.test = 3";
$result3 = $conn->query($sql3);
$estado3 = $result3->fetch_assoc();

// Determinar el estado de los tests completados
$test1_completado = ($estado1['count'] > 0);
$test2_completado = ($estado2['count'] > 0);
$test3_completado = ($estado3['count'] > 0);

// Determinar a qué test enviar según la posición del empleado
$enviar_test1 = $position_id != 1;
$enviar_test2 = in_array($position_id, [2, 3, 4, 5, 6, 7, 8, 9, 10, 12]);
$enviar_test3 = in_array($position_id, [3, 4, 5, 6, 7, 8, 9, 10, 12]);

// Mostrar el mensaje de encuesta pendiente si corresponde
$mostrar_encuesta_pendiente = (!$test1_completado && $enviar_test1) || (!$test2_completado && $enviar_test2) ||
(!$test3_completado && $enviar_test3);
?>

<body class="bg-white d-flex">
    <?php if ($mostrar_encuesta_pendiente) { ?>
        <div class="test-info letraNavBar rounded-4 overflow-hidden shadow mx-auto my-auto" style="max-width: 630px;">
            <div class="test-title text-white p-4" style="background: #5eb130;">
                <h1 class="letraNavBar fs-5 text-center fw-bold m-0">ENCUESTA PENDIENTE</h1>
            </div>
            <div class="d-flex flex-column p-4">
                <p>Estimado colaborador, tiene encuesta(s) pendiente(s) por resolver. Recuerde que este proceso 
                    es importante, ya que nos ayuda a organizar planes de mejora en nuestros servicios.</p>
                <?php if ($enviar_test1 && !$test1_completado) { ?>
                    <div class="d-flex justify-content-between align-items-center gap-3 my-2">
                        <span>COMPETENCIAS DE LIDERAZGO ORGANIZACIONAL</span>
                        <form method="post" action="test.php?test=1">
                            <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">
                            <input type="submit" class="btn text-white letraNavBar rounded-pill px-4" value="Realizar encuesta"
                             style="background: #1e4da9;">
                        </form>
                    </div>
                <?php } ?>
                <?php if ($enviar_test2 && !$test2_completado) { ?>
                    <div class="d-flex justify-content-between align-items-center gap-3 my-2">
                        <span>ENCARGADOS DE GRUPOS</span>
                        <form method="post" action="test.php?test=2">
                            <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">
                            <input type="submit" class="btn text-white letraNavBar rounded-pill px-4" value="Realizar encuesta" 
                            style="background: #1e4da9;">
                        </form>
                    </div>
                <?php } ?>
                <?php if ($enviar_test3 && !$test3_completado) { ?>
                    <div class="d-flex justify-content-between align-items-center gap-3 my-2">
                        <span>EVALUACIÓN DE MANEJO DE CONFLICTOS</span>
                        <form method="post" action="test.php?test=3">
                            <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">
                            <input type="submit" class="btn text-white letraNavBar rounded-pill px-4" 
                            value="Realizar encuesta" style="background: #1e4da9;">
                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } else { ?>
        <script>
            const form = document.createElement('form');
            form.method = 'post';
            form.action = 'perfil-practicante.php';
            document.body.appendChild(form);

            const inputEmployeeId = document.createElement('input');
            inputEmployeeId.type = 'hidden';
            inputEmployeeId.name = 'employee_id';
            inputEmployeeId.value = '<?php echo $employee_id; ?>';

            form.appendChild(inputEmployeeId);
            form.submit();
        </script>
    <?php } ?>
</body>