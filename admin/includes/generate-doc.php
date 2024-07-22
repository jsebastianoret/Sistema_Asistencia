<?php
$employeeId = $_POST['id'];
include 'session.php';
date_default_timezone_set('America/Lima');
require('fpdf/fpdf.php');

$fechaActual = date('Y-m-d');


function formatDateSpanishFPDF($fecha) {
  $meses = array(
    1 => 'enero',
    2 => 'febrero',
    3 => 'marzo',
    4 => 'abril',
    5 => 'mayo',
    6 => 'junio',
    7 => 'julio',
    8 => 'agosto',
    9 => 'septiembre',
    10 => 'octubre',
    11 => 'noviembre',
    12 => 'diciembre'
  );

  $fecha_partes = explode('-', $fecha);
  $dia = $fecha_partes[2];
  $mes = $meses[(int)$fecha_partes[1]];
  $anio = $fecha_partes[0];

  // Concatenate directly for full month name
  $fechaFormateada = $dia . " de " . $mes . " del " . $anio;

  return $fechaFormateada;
}

// 3. Use the custom function to format the date
$fechaFormateada = formatDateSpanishFPDF($fechaActual);

// Conexión a la base de datos
$servername = "localhost";
$username = "ghxumdmy_asistencia";
$password = "ghxumdmy_asistencia";
$dbname = "ghxumdmy_asistencia";
$conn = new mysqli($servername, $username, $password, $dbname);
// Cerrar la conexión a la base de datos
$employee_data = getEmployeeData($employeeId, $conn);

 // Validar la recuperación de datos del empleado
 if ($employee_data) {
  // Formar el nombre completo
  $practicante_name = $employee_data['firstname'] . ' ' . $employee_data['lastname'];

  // Obtener la unidad de negocio y el área
  $unidad_negocio = $employee_data['unidad_negocio'];
  $area = $employee_data['area'];


}


// Función para obtener información del empleado
function getEmployeeData($id, $conn) {
  $sql = "SELECT employees.firstname, employees.lastname, negocio.nombre_negocio AS unidad_negocio,
  position.description AS area
  FROM employees
  LEFT JOIN negocio ON negocio.id = employees.negocio_id
  LEFT JOIN position ON position.id = employees.position_id
  WHERE employees.id = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $id);

  if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      return $result->fetch_assoc();
    } else {
      return false;
    }
  } else {
    echo "Error executing query: " . $stmt->error;
    return false;
  }
}

// Función para generar un memorando
function generateMemorandum($pdf, $employee_data) {

  $fechaActual = date('Y-m-d');
  //$pdf->Image('documents/images/logo.png', 5, 5, 45, 45 );

  //$pdf->Image('documents/images/logo.png', 5, 5, 45, 45);

  switch ($employee_data['unidad_negocio']) {
    case 'TAMI':
      $pdf->Image('documents/images/tami.png', 5, 5, 40, 45);
      break;
    case 'DIGIMEDIA':
      $pdf->Image('documents/images/digimedia.png', 5, 5, 35, 45);
      break;
      case 'YUNTAS':
        $pdf->Image('documents/images/yuntas.png', 5, 5, 40, 45);
        break;
    default:
      // Usar el logo por defecto
      $pdf->Image('documents/images/logo.png', 5, 5, 45, 45);
      break;
  }

// **Imagen 2: Imagen decorativa**
$pdf->Image('documents/images/fondo.png', 40, 0, 170, 55);
$pdf->AddFont('DejaVuSans','', 'DejaVuSans.php');
// **Estilos del título**
$pdf->SetFont('Arial', '', 12);

$pdf->SetTextColor(0, 0, 0);



// **Posicionamiento del título**
$pdf->SetXY(10, 35);

// **Imprimimos el título**
$pdf->Cell(0, 10, 'CARTA DE ADVERTENCIA', 10, 10, 'C');


// **Posicionamiento del texto "Asunto: Inasistencias"**
$pdf->SetXY(145, 53);

// **Estilo del texto "Asunto: Inasistencias"**
$pdf->SetFont('Arial', '', 11);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0, 5, 'Lima, ' . formatDateSpanishFPDF($fechaActual), 0, 1, 'L');


// **Posicionamiento del texto "Asunto: Inasistencias"**
$pdf->SetXY(145, 60);

// **Estilo del texto "Asunto: Inasistencias"**
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetTextColor(0, 0, 0);

// **Imprimimos el texto "Asunto: Inasistencias"**
$pdf->Cell(0, 5, 'Asunto: Inasistencias', 0, 1, 'L');




// **Estilos del párrafo**
$pdf->SetFont('Arial', '', 12); // Ajustar a 'B' para negrita

$pdf->SetFontSize(12); // Ajustar tamaño de letra
$pdf->SetLeftMargin(20); // Ajustar margen izquierdo
$pdf->SetRightMargin(5);
$pdf->SetAutoPageBreak(false); // Desactivar salto de página automático

// **Establecer codificación UTF-8**
//$pdf->AddFont('Arial', '', 'arialuni.ttf', true); // Cargar fuente Arial con soporte UTF-8
//$pdf->SetDisplayMode('utf8'); // Establecer modo de visualización UTF-8

// **Contenido del párrafo**
$pdf->SetTextColor(0, 0, 0); // Negro
$pdf->SetFillColor(255, 255, 255); // Blanco

$pdf->Ln(8); // Salto de línea con interlineado de 2

$pdf->MultiCell(180, 7, 'Estimada ' . $employee_data['firstname'] . ' ' . $employee_data['lastname'] . ' de la unidad de negocio de ' . $employee_data['unidad_negocio'] . ' del area de ' . $employee_data['area'] . '.', 0, 1, 'J');
$pdf->Ln(5); // Salto de línea con interlineado de 2
$pdf->MultiCell(180, 7, 'Por la presente le comunicamos que hemos observado que su desempeno dentro de la empresa ha sido deficiente debido a:', 0, 1, 'J');

$pdf->Ln(7); // Salto de línea con interlineado de 2

$pdf->SetLeftMargin(30); // Aumentar sangría para las viñetas


$pdf->Cell(5, 8, '-', 0, 0, 'L'); // Primera celda a la izquierda
$pdf->Multicell(165, 8, 'Tener faltas y no justificarlas con el encargado del area.', 0, 1, 'L');
$pdf->Ln(5); // Salto de línea con interlineado de 2
$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->Cell(5, 8, '-', 0, 0, 'L'); // Primera celda a la izquierda
$pdf->SetXY($x + 5, $y); // Posiciona la segunda celda a la derecha de la primera
$pdf->MultiCell(165, 8, 'Su ausencia sin previo aviso para la realizacion de labores ha generado interrupciones en el flujo de trabajo, retrasos en proyectos y una carga adicional de trabajo para el resto del equipo.', 0, 1, 'L');


$pdf->SetLeftMargin(20); // Ajustar margen izquierdo
$pdf->SetRightMargin(5);
$pdf->SetTextColor(0, 0, 0); // Rojo
$pdf->SetFillColor(255, 255, 255); // Blanco
$pdf->Ln(7);
$pdf->MultiCell(180, 7, 'Le recordamos asumir sus funciones, tareas y actividades asignadas con puntualidad y eficacia, caso contrario procederemos a suspenderlo(a) de sus funciones como se estipula en el Articulo 17 del Reglamento Interno de la empresa.', 0, 1, 'J');


//$pdf->Cell(0, 5, 'Le recordamos asumir sus funciones, tareas y actividades asignadas con puntualidad y eficacia, caso contrario procederemos a suspenderlo(a) de sus funciones como se estipula en el Artículo 17 del Reglamento Interno de la empresa.', 0, 1, 'L');
$pdf->SetLeftMargin(20); // Ajustar margen izquierdo
$pdf->SetRightMargin(5);
$pdf->Ln(5); // Salto de línea con interlineado de 2
$pdf->MultiCell(180, 10, 'Sin otro particular, nos despedimos de usted esperando que mejore su desempeno.', 0, 1, 'J');

$pdf->Ln(5); // Salto de línea con interlineado de 2

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 5, 'Atentamente,', 0, 1, 'L');

$pdf->Ln(5); // Salto de línea con interlineado de 1


$pdf->Image('documents/images/firma1.png', 40, 215, 30, 0); // Reemplazar 'image.jpg' con la ruta real a la imagen

// **Posicionamiento del texto "Asunto: Inasistencias"**
$pdf->SetXY(20, 255);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(55, 5, 'Juan Carlos Molina Orrego', 0, 1, 'L');

$pdf->Cell(55, 5, 'Gerente general', 0, 1, 'L');

$pdf->Cell(55, 5, 'DNI: 10299631', 0, 1, 'L');

$pdf->Image('documents/images/firma2.png', 145, 215, 65, 0); // Reemplazar 'image.jpg' con la ruta real a la imagen

$pdf->SetXY(145, 255);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(55, 5, 'Shirley Cubas Zeta', 0, 1, 'L');
$pdf->Ln(2); // Salto de línea con interlineado de 1
$pdf->SetXY(145, 260);

$pdf->Cell(55, 5, 'Comunicacion Interna', 0, 1, 'L');
$pdf->Ln(2); // Salto de línea con interlineado de 1
$pdf->SetXY(145, 265);

$pdf->Cell(55, 5, 'DNI: 73024703', 0, 1, 'L');
}

// Función para generar una carta de despido
function generateTerminationLetter($pdf, $employee_data) {
  $fechaActual = date('Y-m-d');
  
  switch ($employee_data['unidad_negocio']) {
    case 'TAMI':
      $pdf->Image('documents/images/tami.png', 5, 5, 40, 45);
      break;
    case 'DIGIMEDIA':
      $pdf->Image('documents/images/digimedia.png', 5, 5, 35, 45);
      break;
      case 'YUNTAS':
        $pdf->Image('documents/images/yuntas.png', 5, 5, 40, 45);
        break;
    default:
      // Usar el logo por defecto
      $pdf->Image('documents/images/logo.png', 5, 5, 45, 45);
      break;
  }

// **Imagen 2: Imagen decorativa**
$pdf->Image('documents/images/fondo.png', 40, 0, 170, 55);
$pdf->AddFont('DejaVuSans','', 'DejaVuSans.php');
// **Estilos del título**
$pdf->SetFont('Arial', '', 12);

$pdf->SetTextColor(0, 0, 0);



// **Posicionamiento del título**
$pdf->SetXY(10, 35);

// **Imprimimos el título**
$pdf->Cell(0, 10, 'CARTA DE DESPIDO', 10, 10, 'C');


// **Posicionamiento del texto "Asunto: Inasistencias"**
$pdf->SetXY(145, 53);

// **Estilo del texto "Asunto: Inasistencias"**
$pdf->SetFont('Arial', '', 11);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(0, 5, 'Lima, ' . formatDateSpanishFPDF($fechaActual), 0, 1, 'L');


// **Posicionamiento del texto "Asunto: Inasistencias"**
$pdf->SetXY(145, 60);

// **Estilo del texto "Asunto: Inasistencias"**
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetTextColor(0, 0, 0);

// **Imprimimos el texto "Asunto: Inasistencias"**
$pdf->Cell(0, 5, 'Asunto: Suspension total', 0, 1, 'L');




// **Estilos del párrafo**
$pdf->SetFont('Arial', '', 12); // Ajustar a 'B' para negrita

$pdf->SetFontSize(12); // Ajustar tamaño de letra
$pdf->SetLeftMargin(20); // Ajustar margen izquierdo
$pdf->SetRightMargin(5);
$pdf->SetAutoPageBreak(false); // Desactivar salto de página automático

// **Establecer codificación UTF-8**
//$pdf->AddFont('Arial', '', 'arialuni.ttf', true); // Cargar fuente Arial con soporte UTF-8
//$pdf->SetDisplayMode('utf8'); // Establecer modo de visualización UTF-8

// **Contenido del párrafo**
$pdf->SetTextColor(0, 0, 0); // Negro
$pdf->SetFillColor(255, 255, 255); // Blanco

$pdf->Ln(8); // Salto de línea con interlineado de 2

$pdf->MultiCell(180, 7, 'Estimada ' . $employee_data['firstname'] . ' ' . $employee_data['lastname'] . ' de la unidad de negocio de ' . $employee_data['unidad_negocio'] . ' del area de ' . $employee_data['area'] . '.', 0, 1, 'J');
$pdf->Ln(5); // Salto de línea con interlineado de 2

$pdf->MultiCell(180, 10, 'Por la presente le comunicamos que hemos observado que su desempeno dentro de la empresa no ha mejorado a pesar de haberle hecho alcance de sus deficiencias. Usted reincidio en: Deficiencia en el desempeno laboral lo cual genero retrasos en la gestion de la unidad y no subio sus actividades correspondientes a la plataforma Trello desde el 27 de diciembre del 2023. Por tales motivos nos vemos en la obligacion de prescindir de sus servicios. En consecuencia, desde el dia 28 de febrero del 2024 quedara extinta la relacion laboral que se tenia entre su persona y la empresa Neonhouseled S.A.C.', 0, 1, 'J');



$pdf->SetLeftMargin(30); // Aumentar sangría para las viñetas

//$pdf->Cell(0, 5, 'Le recordamos asumir sus funciones, tareas y actividades asignadas con puntualidad y eficacia, caso contrario procederemos a suspenderlo(a) de sus funciones como se estipula en el Artículo 17 del Reglamento Interno de la empresa.', 0, 1, 'L');
$pdf->SetLeftMargin(20); // Ajustar margen izquierdo
$pdf->SetRightMargin(5);
$pdf->Ln(5); // Salto de línea con interlineado de 2
$pdf->MultiCell(180, 10, 'Sin otro particular, nos despedimos de usted agradeciendo su tiempo invertido en la empresa.', 0, 1, 'J');

$pdf->Ln(5); // Salto de línea con interlineado de 2

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 5, 'Atentamente,', 0, 1, 'L');

$pdf->Ln(5); // Salto de línea con interlineado de 1


$pdf->Image('documents/images/firma1.png', 40, 215, 30, 0); // Reemplazar 'image.jpg' con la ruta real a la imagen

// **Posicionamiento del texto "Asunto: Inasistencias"**
$pdf->SetXY(20, 255);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(55, 5, 'Juan Carlos Molina Orrego', 0, 1, 'L');

$pdf->Cell(55, 5, 'Gerente general', 0, 1, 'L');

$pdf->Cell(55, 5, 'DNI: 10299631', 0, 1, 'L');

$pdf->Image('documents/images/firma2.png', 145, 215, 65, 0); // Reemplazar 'image.jpg' con la ruta real a la imagen

$pdf->SetXY(145, 255);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(55, 5, 'Shirley Cubas Zeta', 0, 1, 'L');
$pdf->Ln(2); // Salto de línea con interlineado de 1
$pdf->SetXY(145, 260);

$pdf->Cell(55, 5, 'Comunicacion Interna', 0, 1, 'L');
$pdf->Ln(2); // Salto de línea con interlineado de 1
$pdf->SetXY(145, 265);

$pdf->Cell(55, 5, 'DNI: 73024703', 0, 1, 'L');
}
function insertMemorandumData($employeeId, $documentType, $filePath) {
  $servername = "localhost";
$username = "ghxumdmy_asistencia";
$password = "ghxumdmy_asistencia";
$dbname = "ghxumdmy_asistencia";
$conn = new mysqli($servername, $username, $password, $dbname);
$fechaActual = date('Y-m-d H:i:s'); // 'Y-m-d' for date, 'H:i:s' for time

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error); // Handle connection failure
}
  $sql = "INSERT INTO memorandums (fecha, employee_id, tipo, document) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ssss', $fechaActual, $employeeId, $documentType, $filePath);

  // Execute the query and handle success/error
  if ($stmt->execute()) {
    $_SESSION['success'] = 'Memorandum registrado exitosamente'; // Set success message
  } else {
    $_SESSION['error'] = 'Error al registrar el memorandum: ' . $stmt->error; // Set error message
  }

  $stmt->close();
  $conn->close();
}

function insertDespidoData($employeeId, $documentType, $filePath) {
  $servername = "localhost";
  $username = "ghxumdmy_asistencia";
  $password = "ghxumdmy_asistencia";
  $dbname = "ghxumdmy_asistencia";

  // Connect to database
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Handle connection failure
  }

  $fechaActual = date('Y-m-d H:i:s');

  $sql = "INSERT INTO memorandums (fecha, employee_id, tipo, document) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('ssss', $fechaActual, $employeeId, $documentType, $filePath);

  // Execute the query and handle success/error
  if ($stmt->execute()) {
    $_SESSION['success'] = 'Carta de despido registrado exitosamente'; // Set success message
  } else {
    $_SESSION['error'] = 'Error al registrar la carta de despido: ' . $stmt->error; // Set error message
  }

  $stmt->close();
  $conn->close();
}


$documentPath = $filePath; // Ejemplo: documents/memorandums/memorandum_586_2024-03-22.pdf
$documentUrl = $_SERVER['DOCUMENT_ROOT'] . '/' . $documentPath;

// Comprobar si el archivo existe antes de acceder
if (file_exists($documentUrl)) {
  // Puedes usar $documentUrl para mostrar, descargar o realizar otras acciones en el documento
  // Ejemplo: mostrar el PDF en el navegador
  header('Content-type: application/pdf');
  readfile($documentUrl);
} else {
  echo "Error: Documento no encontrado.";
}



// Procesar la solicitud
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $documentType = $_POST['documento_tipo'];
  $employeeId = $_POST['id'];

  // Validar la entrada del usuario
  if (empty($documentType) || !in_array($documentType, ['memorandum', 'carta_despido'])) {
    echo 'Invalid document type selected.';
    exit;
  }

  $conn->close();

  // Crear un nuevo documento PDF
  $pdf = new FPDF();
  $pdf->AddPage();

  // Seleccionar la función de generación de contenido según el tipo de documento
  switch ($documentType) {
    case 'memorandum':
      generateMemorandum($pdf, $employee_data);
      break;
    case 'carta_despido':
      generateTerminationLetter($pdf, $employee_data);
      break;
  }

  // Output the PDF and capture the generated path
  $generatedFilePath = 'documents/' . $documentType . '_' . $employee_data['firstname'] . ' ' . $employee_data['lastname'] . '_' . $fechaActual. '.pdf';
  $pdf->Output($generatedFilePath, 'F'); // Save to file system

  // Update $filePath with the generated path
  $filePath = $generatedFilePath;

  // Insert data to the database functions with the updated $filePath
  switch ($documentType) {
    case 'memorandum':
      insertMemorandumData($employeeId, $documentType, $filePath);
      
      break;
    case 'carta_despido':
      insertDespidoData($employeeId, $documentType, $filePath);
      break;
  }
  
} 


else {
  echo 'Invalid request method.';
}


header('location: ../practicantes.php');
?>
