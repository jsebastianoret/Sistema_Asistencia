<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>
<?php
$image_array = [];
$document_array = [];

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM archivos WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $image_json = $row['images'];
        $document_json = $row['archivos'];

        $image_array = json_decode($image_json, true);
        $document_array = json_decode($document_json, true);
    } else {
        header('location: archivos.php');
    }
} else {
    header('location: archivos.php');
}
?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $archivos_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="content d-flex text-center justify-content-center my-auto">
            <form method="POST" action="includes/archivo_edit.php" enctype="multipart/form-data">
                <input type="hidden" name="archivo_id" value='<?php echo $id ?>'>

                <h2 class="fw-bold text-primary">
                    <i class="fas fa-file text-success me-3"></i>ARCHIVOS
                </h2>
                <?php foreach ($document_array as $document_filename) { ?>
                    <div class="fw-bolder">
                        <input type="hidden" name="existing_documents[]"
                            value="<?= htmlspecialchars($document_filename) ?>">
                        <a href="" class="text-decoration-none remove-document-link" data-type="document"
                            data-filename="<?= urlencode($document_filename) ?>">
                            <?= htmlspecialchars($document_filename) ?><i class="fas fa-times ms-2"></i>
                        </a>
                    </div>
                <?php } ?>
                <input class="form-control mt-3" type="file" id="documents" name="documents[]" multiple
                    onchange="previewFiles()">
                <input type="hidden" id="imageReference" name="imageReference[]">
                <div id="filePreviews" class="d-flex gap-4 justify-content-center my-4"></div>
                <button class="button-primary fs-6 mt-5" type="submit" name="edit">
                    <i class="fa-solid fa-file-pen fs-6 me-2"></i>Actualizar
                </button>
            </form>
        </div>

        <!-- FOOTER -->
        <?php include 'includes/footer.php'; ?>
    </div>

    <script src="js/scripts.js"></script>

    <script>
        function previewFiles() {
            var fileInput = document.getElementById('documents');
            var filePreviews = document.getElementById('filePreviews');
            var imageReferenceField = document.getElementById('imageReference');

            filePreviews.innerHTML = '';
            imageReferenceField.value = ''; // Limpia el campo

            var imageNames = [];

            for (var i = 0; i < fileInput.files.length; i++) {
                var file = fileInput.files[i];
                var extension = file.name.split('.').pop().toLowerCase();

                var extensionImages = {
                    'doc': 'word.png',
                    'docx': 'word.png',
                    'xls': 'excel.png',
                    'xlsx': 'excel.png',
                    'pdf': 'pdf.png',
                    'rar': 'rar.png',
                    'zip': 'zip.png'
                };

                var filePreview = document.createElement('img');
                filePreview.src = extensionImages.hasOwnProperty(extension) ? '../img/' + extensionImages[extension] : '';
                filePreview.alt = 'Vista previa de archivo';
                filePreview.style.maxWidth = '100px';
                filePreview.style.maxHeight = '100px';

                filePreviews.appendChild(filePreview);

                if (extensionImages.hasOwnProperty(extension)) {
                    imageNames.push(extensionImages[extension]);
                }
            }

            var imageNamesString = imageNames.join(',');

            // Verifica si imageNamesString está vacío y, si es así, asigna un valor por defecto
            if (imageNamesString === '') {
                imageNamesString = ' ';
            }

            imageReferenceField.value = imageNamesString;
        }
    </script>

    <script>
        $(document).ready(function () {
            $('.remove-document-link').on("click", function (e) {
                e.preventDefault();

                var filename = $(this).data('filename');
                var id_archivo = <?php echo $id; ?>;

                $.ajax({
                    url: 'eliminar-archivo-archivo.php?type=document&filename=' + filename + '&id=' + id_archivo,
                    type: 'GET',
                    success: function (response) {
                        if (response.includes('eliminado exitosamente')) {
                            $(e.target).parent().fadeOut();
                        } else {
                            alert('Error al eliminar el documento: ' + response);
                        }
                    },
                    error: function () {
                        alert('Error al comunicarse con el servidor.');
                    }
                });
            });
        });
    </script>
</body>

</html>