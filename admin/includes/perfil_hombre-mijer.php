<?php
    if ($row['negocio'] == 'DIGIMEDIA') {
        if($row['gender'] == 'Female') {
            echo '<img src="PERSONAJES/DIGIMEDIA MARKETING/DIGIMEDIA.webp">';
        } else {
            echo '<img src="PERSONAJES/DIGIMEDIA MARKETING/DIGIMEDIA HOMBRE.webp">';
        }
    }
    elseif ($row['negocio'] == 'NHL') {
        if($row['gender'] == 'Female') {
            echo '<img src="PERSONAJES/NHL SAC/NHL SAC ADMINS.webp">';
        } else {
            echo '<img src="PERSONAJES/NHL SAC/NHL SAC HOMBRE.webp">';
        }
    }
    elseif ($row['negocio'] == 'VAPING') {
        if($row['gender'] == 'Female') {
            echo '<img src="PERSONAJES/VAPING CLOUD/MUJER.webp">';
        } else {
            echo '<img src="PERSONAJES/VAPING CLOUD/HOMBRE VAPING.webp">';
        }
    }
    elseif ($row['negocio'] == 'YUNTAS') {
        if($row['gender'] == 'Female') {
            echo '<img src="PERSONAJES/YUNTAS PRODUCCIONES/YUNTAS.webp">';
        } else {
            echo '<img src="PERSONAJES/YUNTAS PRODUCCIONES/YUNTAS HOMBRE.webp">';
        }
    } else {
        if($row['gender'] == 'Female') {
            echo '<img src="PERSONAJES/VAPING CLOUD/MUJER.webp">';
        } else {
            echo '<img src="PERSONAJES/VAPING CLOUD/HOMBRE VAPING.webp">';
        }
    }
?>