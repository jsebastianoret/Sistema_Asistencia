<?php include 'includes/header-practicante.php' ?>

<body class="bg-white">
   <?php $home_click = "clicked" ?>
   <?php include 'includes/fecha_actual.php' ?>
   <?php include 'includes/navbar-sidebar-practicante.php' ?>

   <?php if (isset($row['employee_id'])) { ?>
      <div id="home-practicante">
         <div class="publicaciones">
            <?php include 'includes/conn.php';

            $current_employee_id = $row['employee_id'];
            $getEmployeeIdSql = "SELECT id FROM employees WHERE employee_id = ?";
            $getEmployeeIdStmt = $conn->prepare($getEmployeeIdSql);
            $getEmployeeIdStmt->bind_param("s", $current_employee_id);
            $getEmployeeIdStmt->execute();
            $employeeIdResult = $getEmployeeIdStmt->get_result();
            $employeeIdRow = $employeeIdResult->fetch_assoc();

            $employeeId = $employeeIdRow['id'];

            $getEmployeeInfoSql = "SELECT negocio_id, employee_id FROM employees WHERE id = ?";
            $getEmployeeInfoStmt = $conn->prepare($getEmployeeInfoSql);
            $getEmployeeInfoStmt->bind_param("i", $employeeId);
            $getEmployeeInfoStmt->execute();
            $employeeInfoResult = $getEmployeeInfoStmt->get_result();
            $employeeInfoRow = $employeeInfoResult->fetch_assoc();

            $negocio_id = isset($employeeInfoRow['negocio_id']) ? $employeeInfoRow['negocio_id'] : null;

            $sql = "SELECT id, title, type, content, images, documents, views, reactions
                FROM publications
                WHERE
                    (privacy = 'GENERAL') OR
                    (privacy = 'UNIDAD' AND negocio_id = ?) OR
                    (privacy = 'PERSONA' AND negocio_id = ? AND employee_id = ?)
                ORDER BY publication_date DESC";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $negocio_id, $negocio_id, $employeeId);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($rowPb = $result->fetch_assoc()) {
               $id = $rowPb["id"];
               $type = $rowPb["type"];
               $title = $rowPb["title"];
               $content = $rowPb["content"];
               $images = json_decode($rowPb["images"]);
               $documents = json_decode($rowPb["documents"]);
               $numViews = $rowPb["views"];
               $numreactions = $rowPb["reactions"];

               $checkViewSql = "SELECT COUNT(*) as view_count FROM views WHERE employee_id = ? AND publication_id = ?";
               $checkViewStmt = $conn->prepare($checkViewSql);
               $checkViewStmt->bind_param("si", $employeeId, $id);
               $checkViewStmt->execute();
               $viewResult = $checkViewStmt->get_result();
               $viewRow = $viewResult->fetch_assoc();

               if ($viewRow['view_count'] == 0) {
                  $insertViewSql = "INSERT INTO views (employee_id, publication_id) VALUES (?, ?)";
                  $insertViewStmt = $conn->prepare($insertViewSql);
                  $insertViewStmt->bind_param("ss", $employeeId, $id);
                  $insertViewStmt->execute();

                  $numViews++;

                  $updateViewsSql = "UPDATE publications SET views = ? WHERE id = ?";
                  $updateViewsStmt = $conn->prepare($updateViewsSql);
                  $updateViewsStmt->bind_param("ii", $numViews, $id);
                  $updateViewsStmt->execute();
               } ?>
               <div class="festividades card" style="margin-bottom: 5%;">
                  <div class="home-head letraNavBar">
                     <?php echo $type; ?>
                  </div>
                  <h4 class="home-title letraNavBar">
                     <?php echo $title; ?>
                  </h4>
                  <div class="festividades-image">
                     <?php if (!empty($images)) {
                        foreach ($images as $image) { ?>
                           <img src="../images/<?php echo $image ?>" alt="Imagen" style="max-width: 400px; max-height: 500px;">
                        <?php } ?>
                     <?php } ?>
                  </div>
                  <div class="festividades-description letraNavBar">
                     <div class="letraNavBar">
                        <?php echo $content; ?>
                     </div>
                  </div>
                  <div class="festividades-documents">
                     <?php if (!empty($documents)) { ?>
                        <div class="archivos-adjuntos letraNavBar">Archivos adjuntos:</div>
                        <?php foreach ($documents as $document) {
                           $ext = pathinfo($document, PATHINFO_EXTENSION);
                           $icon = '';
                           switch ($ext) {
                              case 'docx':
                                 $icon = '<i class="fas fa-file-word"></i>';
                                 break;
                              case 'pdf':
                                 $icon = '<i class="fas fa-file-pdf"></i>';
                                 break;
                              case 'xlsx':
                                 $icon = '<i class="fas fa-file-excel"></i>';
                                 break;
                              default:
                                 $icon = '<i class="fas fa-file"></i>';
                           } ?>
                           <div class="document-container">
                              <a href="../documents/<?php echo $document; ?>" download class="document-link">
                                 <div class="document-info">
                                    <div class="document-box">
                                       <?php echo $icon; ?>
                                    </div>
                                    <div class="document-name letraNavBar">
                                       <?php echo $document; ?>
                                    </div>
                                    <div class="document-download">
                                       <i class="fas fa-download"></i>
                                    </div>
                                 </div>
                              </a>
                           </div>
                        <?php } ?>
                     <?php } ?>
                  </div>
                  <?php $commentsQuery = "SELECT id, id_employee, comentario FROM coments WHERE id_publication = '$id'";
                  $commentsResult = $conn->query($commentsQuery);

                  $commentEmployeeInfoQuery = "SELECT firstname, photo FROM employees WHERE employee_id = '$employeeId'";
                  $commentEmployeeInfoResult = $conn->query($commentEmployeeInfoQuery);

                  if ($commentEmployeeInfoResult->num_rows > 0) {
                     $commentEmployeeInfo = $commentEmployeeInfoResult->fetch_assoc();
                     $commentEmployeeFirstName = $commentEmployeeInfo["firstname"];
                     $commentEmployeePhoto = $commentEmployeeInfo["photo"];
                  } ?>
                  <div class="festividades-footer">
                     <div class="container-icon">
                        <i class="fas fa-eye"></i>
                        <span class="views-count letraNavBar">
                           <?php echo $numViews; ?>
                        </span> vistas
                     </div>
                     <div class="container-icon">
                        <i class="fas fa-smile"></i>
                        <span class="comments-count letraNavBar" data-id="<?php echo $id; ?>">
                           <?php echo $numreactions; ?>
                        </span>
                     </div>
                  </div>
                  <hr style="margin: 0.5rem;">
                  <div class="festividades-btns">
                     <div class="container-icon">
                        <?php
                        include 'includes/conn.php';

                        $checkQuery = "SELECT * FROM reactions WHERE employee_id = '$employeeId' AND publication_id = '$id'";
                        $checkResult = $conn->query($checkQuery);

                        if ($checkResult->num_rows > 0) {
                           $iconClass = 'fas fa-smile';
                        } else {
                           $iconClass = 'far fa-meh';
                        }
                        ?>
                        <a class="btn-icon smile-button letraNavBar" data-id="<?php echo $id; ?>"
                           data-employee-id="<?php echo $employeeId; ?>">
                           <i class="<?php echo $iconClass; ?>"></i> Me gusta
                        </a>
                     </div>
                     <div class="container-icon">
                        <a class="btn-icon letraNavBar" id="comment-icon-<?= $id; ?>">
                           <i class="fas fa-comment"></i> Comentar
                        </a>
                     </div>
                  </div>
                  <hr style="margin: 0.5rem;">
                  <div class="festividades-comments" id="comments-section-<?= $id; ?>">
                     <div class="container mt-3">
                        <h5 class="letraNavBar">Comentarios</h5>
                        <?php if ($commentsResult->num_rows > 0) {
                           while ($commentRow = $commentsResult->fetch_assoc()) {
                              $commentEmployeeId = $commentRow["id_employee"];
                              $commentContent = $commentRow["comentario"];
                              $commentId = $commentRow["id"];

                              $commentEmployeeInfoQuery = "SELECT firstname, photo FROM employees WHERE employee_id = '$commentEmployeeId'";
                              $commentEmployeeInfoResult = $conn->query($commentEmployeeInfoQuery);

                              if ($commentEmployeeInfoResult->num_rows > 0) {
                                 $commentEmployeeInfo = $commentEmployeeInfoResult->fetch_assoc();
                                 $commentEmployeeFirstName = $commentEmployeeInfo["firstname"];
                                 $commentEmployeePhoto = $commentEmployeeInfo["photo"];
                              } ?>
                              <div class="commentario">
                                 <div class="comment-avatar">
                                    <img src="../images/profile.jpg">
                                 </div>
                                 <div class="comment-details letraNavBar">
                                    <h6 class="comment-name">
                                       <?= $commentEmployeeFirstName; ?>
                                    </h6>
                                    <p class="comment-text">
                                       <?= $commentContent; ?>
                                    </p>
                                    <?php if ($commentEmployeeId === $empleado_id) { ?>
                                       <div class="comment-actions">
                                          <a href="#" class="edit-comment" data-comment-id="<?= $commentId; ?>">Editar</a>
                                          <a href="#" class="delete-comment" data-comment-id="<?= $commentId; ?>">Eliminar</a>
                                       </div>
                                    <?php } ?>
                                 </div>
                                 <div class="edit-form" id="edit-form-<?= $commentId; ?>" style="display: none;">
                                    <input type="text" class="edit-input" data-comment-id="<?= $commentId; ?>"
                                       value="<?= $commentContent; ?>">
                                    <button class="save-edit btn btn-primary" data-comment-id="<?= $commentId; ?>">Guardar</button>
                                    <button class="cancel-edit btn btn-secondary"
                                       data-comment-id="<?= $commentId; ?>">Cancelar</button>
                                 </div>
                              </div>
                           <?php } ?>
                        <?php } else { ?>
                           <p class="letraNavBar">No hay comentarios aún.</p>
                        <?php } ?>
                        <div class="letraNavBar media mt-3 d-flex">
                           <?php $Employee_Info_Query = "SELECT firstname, photo FROM employees WHERE employee_id = '$empleado_id'";
                           $Employee_Info_Result = $conn->query($Employee_Info_Query);

                           if ($Employee_Info_Result->num_rows > 0) {
                              $employeeInfo = $Employee_Info_Result->fetch_assoc();
                              $employeeFirstName = $employeeInfo["firstname"];
                              $employeePhoto = $employeeInfo["photo"];
                           } ?>

                           <img src="../images/profile.jpg" alt="">
                           <div class="media-body d-flex comment-input2">
                              <form method="POST" action="enviar-comentario.php" id="comment-form">
                                 <input type="hidden" name="employee_id" value="<?= $empleado_id; ?>">
                                 <input type="hidden" name="id_publicacion" value="<?= $id; ?>">
                                 <input type="hidden" name="id_employee" value="<?= $empleado_id; ?>">
                                 <input type="hidden" name="comment_employee_firstname"
                                    value="<?= $commentEmployeeFirstName; ?>">
                                 <input type="hidden" name="comment_employee_photo" value="<?= $commentEmployeePhoto; ?>">
                                 <div class="input-group">
                                    <input type="text" id="comment-input" name="comentario" class="form-control letraNavBar"
                                       placeholder="Comenta..." style="border: none;">
                                    <div class="input-group-append">
                                       <button type="submit" id="submit-comment" class="btn letraNavBar">
                                          <i class="fas fa-paper-plane"></i>
                                       </button>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            <?php } ?>
         </div>
         <div class="caldenario_home"
            style="background-color: white;box-shadow: 0 4px 4px 4px rgba(0, 0, 0, 0.1);border-radius: 12px;height: 400.6px;padding: inherit;width: 491.6px;">
            <div class="calendario-home card-body">
               <div>
                  <div class="d-flex" style="width: 420px;justify-content: space-between; align-items: center;">
                     <div class="letraNavBar colorletraperfil" id="month"
                        style="text-transform: uppercase;font-size: 24px;">
                     </div>
                     <form method="post" action="calendario-practicante.php" class="form_ver-mas">
                        <input type="hidden" name="employee_id" value="<?php echo $current_employee_id; ?>">
                        <button type="submit" class="enlaces__btn" id="button1">
                           <div class="ver-mas" style="width: 120px;height: 24px;padding-top: 0px;">
                              <a class="letraNavBar text-light">Ver más >></a>
                           </div>
                        </button>
                     </form>
                  </div>
                  <div>
                     <div class="letraNavBar calendar_date" id="dates"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   <?php } ?>

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
      document.addEventListener("DOMContentLoaded", function () {
         const commentIcons = document.querySelectorAll("[id^='comment-icon-']");

         commentIcons.forEach(commentIcon => {
            commentIcon.addEventListener("click", function () {
               const postId = commentIcon.id.split("-")[2];
               const commentsSection = document.getElementById(`comments-section-${postId}`);

               if (commentsSection.style.display === "none" || commentsSection.style.display === "") {
                  commentsSection.style.display = "block";
               } else {
                  commentsSection.style.display = "none";
               }
            });
         });
      });
   </script>
   <script>
      $(document).ready(function () {
         $('.delete-comment').click(function (e) {
            e.preventDefault();

            var commentId = $(this).data('comment-id');

            if (confirm('¿Estás seguro de que deseas eliminar este comentario?')) {
               $.ajax({
                  url: 'eliminar-comentario.php',
                  type: 'POST',
                  data: {
                     comment_id: commentId
                  },
                  success: function (response) {
                     location.reload();
                  },
                  error: function (xhr, status, error) {
                     console.log(error);
                     alert('Error al eliminar el comentario.');
                  }
               });
            }
         });
      });
   </script>
   <script>
      $(document).ready(function () {
         $(".edit-comment").click(function (e) {
            e.preventDefault();

            var commentId = $(this).data("comment-id");
            $("#edit-form-" + commentId).show();
         });

         $(".cancel-edit").click(function (e) {
            e.preventDefault();

            var commentId = $(this).data("comment-id");
            $("#edit-form-" + commentId).hide();
         });

         $(".save-edit").click(function (e) {
            e.preventDefault();

            var commentId = $(this).data("comment-id");
            var newContent = $(".edit-input[data-comment-id='" + commentId + "']").val();

            $.ajax({
               url: "editar-comentario.php",
               type: "POST",
               data: {
                  comment_id: commentId,
                  new_content: newContent
               },
               success: function (response) {
                  alert(response);
                  location.reload();
               },
               error: function (xhr, status, error) {
                  alert("Error al editar el comentario: " + error);
               }
            });
         });
      });
   </script>
   <script>
      $(document).ready(function () {
         $(document).on("click", ".smile-button", function () {
            var button = $(this);
            var id = button.data("id");
            var employeeId = button.data("employee-id");
            var isReacted = button.hasClass("reacted");

            $.ajax({
               type: "POST",
               url: "reactions.php",
               data: {
                  id: id,
                  employeeId: employeeId,
                  isReacted: isReacted
               },
               success: function (response) {
                  if (isReacted) {
                     button.find("i").toggleClass("fas fa-smile far fa-meh");
                  } else {
                     button.find("i").toggleClass("far fa-meh fas fa-smile");
                  }

                  button.toggleClass("reacted");

                  var reactionsCountElement = $(".comments-count[data-id='" + id + "']");
                  reactionsCountElement.text(response);
               },
               error: function (xhr, status, error) {
                  console.error("Error al realizar la solicitud Ajax: " + error);
               }
            });
         });
      });
   </script>
   <script src="../js/miniCalendario.js"></script>
</body>

</html>