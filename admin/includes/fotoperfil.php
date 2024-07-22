<?php
    if (isset($row['photo'])) {
        if ($row['photo'] == "") {
            echo '<img src="../images/profile.jpg" alt="notificacion" height="40" width="40" class="img__perfil">';
        } else {
            echo '<img src="../images/'.$row['photo'].'" alt="notificacion" height="40" width="40" class="img__perfil">';
        }
    } else {       
        echo "";
    }
?>