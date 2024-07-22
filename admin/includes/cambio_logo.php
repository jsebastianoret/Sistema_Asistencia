<?php
if (isset($row['negocio'])) {
    if ($row['negocio'] == 'DIGIMEDIA') {
        echo '<img class="logo" src="LOGO/DIGIMEDIA - COLOR (1).png" alt="logo" height="80">';
    }
    elseif ($row['negocio'] == 'NHL') {
        echo '<img class="logo" src="LOGO/LOGO-NHL.webp" alt="logo" height="80">';
    }
    elseif ($row['negocio'] == 'VAPING') {
        echo '<img class="logo" src="LOGO/VAPING - VERTICAL (1).png" alt="logo" height="80">';
    }
    elseif ($row['negocio'] == 'YUNTAS') {
        echo '<img class="logo" src="LOGO/YUNTAS - COLOR.png" alt="logo" height="80">';
    } else {
        echo '<img class="logo" src="LOGO/LOGO-NHL.webp" alt="logo" height="80">';
    }
} else {
    echo "";
}
?>