<?php include 'includes/header-practicante.php'; ?>

<body class="bg-white">
    <?php $archivos_click = "clicked" ?>
    <?php include 'includes/fecha_actual.php' ?>
    <?php include 'includes/navbar-sidebar-practicante.php' ?>

    <div class="card w-75 mx-auto mt-5">
        <form class="form-inline d-flex">
            <input id="searchInput" style="margin-left: auto; max-width: 150px;"
                class="form-control form-control-sm mr-sm-2" type="search" placeholder="Buscar" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>

        <div class="container mt-3">
            <div class="embed-responsive embed-responsive-16by9">
                <div class="embed-responsive-item bg-secondary" style="height: 300px;"></div>
            </div>
        </div>
        <div class="row mt-5">
            <?php
            include 'includes/conn.php';

            $sql = "SELECT images, archivos FROM archivos";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4" style="margin-bottom: 20px;">';
                    echo '<div class="card-header" style="padding: 10px; background-color: #198754;">';
                    $images = json_decode($row["images"]);
                    if ($images) {
                        echo '<div style="display: flex; justify-content: center;">';
                        foreach ($images as $image) {
                            echo '<img src="../img/' . $image . '" alt="Imagen" style="max-width: 40px; max-height: 50px;">';
                        }
                        echo '</div>';
                    }
                    echo '</div>';
                    echo '<div class="card-body" style="padding: 10px; background-color: #1e3d8f;">';
                    $documents = json_decode($row["archivos"]);
                    if ($documents) {
                        foreach ($documents as $document) {
                            echo '<a href="../documents/' . $document . '" download style="color: white; font-weight: bold; text-decoration: none;">';
                            echo '<i class="fas fa-download"></i> ' . $document . '<br>';
                            echo '</a>';
                        }
                    }
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>

    </div>

    <script>
        let idPracticante = document.getElementById("idPracticante");
        if (idPracticante.value.length == 0) {
            window.location.href = "../index.php";
        }
    </script>
    <script>
        function salirMiPerfil() {
            Swal.fire({
                title: '¿Estás seguro de que quieres salir de tu perfil?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Salir de perfil'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../index.php";
                }
            })
        }
    </script>
    <script>
        function toggleButtonColor(event, buttonId) {
            event.preventDefault();
            const buttons = document.getElementsByClassName("enlaces");
            for (let i = 0; i < buttons.length; i++) {
                buttons[i].classList.remove("clicked");
            }
            const button = document.getElementById(buttonId);
            button.classList.add("clicked");
        }
    </script>
    <script>
        document.getElementById('searchInput').addEventListener('input', function () {
            var searchQuery = this.value.toLowerCase();
            var documentElements = document.querySelectorAll('.col-md-4');

            for (var i = 0; i < documentElements.length; i++) {
                var documentText = documentElements[i].innerText.toLowerCase();
                if (documentText.includes(searchQuery)) {
                    documentElements[i].style.display = 'block';
                } else {
                    documentElements[i].style.display = 'none';
                }
            }
        });
    </script>
</body>