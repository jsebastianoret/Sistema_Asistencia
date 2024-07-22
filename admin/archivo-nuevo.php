<?php include 'includes/session.php' ?>
<?php include 'includes/header.php' ?>

<body class="bg-white" onload="displayTime();" style="height: 100% !important;">
    <div class="content-wrapper">
        <?php $archivos_click = "clicked" ?>
        <?php include 'includes/navbar_sidebar.php' ?>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="content d-flex text-center justify-content-center my-auto">
            <form method="POST" action="includes/archivo_add.php" enctype="multipart/form-data">
                <h2 class="fw-bold text-primary">
                    <i class="fas fa-file text-success me-3"></i>ARCHIVOS
                </h2>
                <input class="form-control mt-2" type="file" id="documents" name="documents[]" multiple
                    onchange="previewFiles()" required>
                <input type="hidden" id="imageReference" name="imageReference">
                <div id="filePreviews" class="d-flex gap-4 justify-content-center my-4"></div>
                <button class="button-primary fs-6 mt-5" type="submit" name="add">
                    <i class="fa-solid fa-file-circle-plus fs-6 me-2"></i>Agregar Archivo(s)
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
            imageReferenceField.value = '';

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

            var imageNamesJSON = JSON.stringify(imageNames);
            imageReferenceField.value = imageNamesJSON;
        }
    </script>

</body>

</html>