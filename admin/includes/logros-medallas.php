<?php
    $notaSemanal = $promedioTotal;//$promedioTotal
            
    $barraMedalla = 0;
    $barraMedalla2 = 0;
    $barraMedalla3 = 0;
    $barraMedalla4 = 0;

    $colorcircle = 0;
    $colorcircle2 = 0;
    $colorcircle3 = 0;
    $colorcircle4 = 0;

    $obtenido = "";
    $obtenido2 = "";
    $obtenido3 = "";
    $obtenido4 = "";

    $medallaObtenida = "";

    if ($notaSemanal <= 5 ) {
        $barraMedalla = ($notaSemanal*61)/5;
        if ($notaSemanal >= 5) {
            $colorcircle = "background-color: #1e4da9;";
            $obtenido = "Obtenido";
        } else {
            $colorcircle = "";
        }
    } elseif ($notaSemanal > 5 && $notaSemanal <= 10) {
        $barraMedalla = 61;
        $notaSemanal2 = $notaSemanal-5;
        $barraMedalla2 = ($notaSemanal2*61)/5;
        if ($notaSemanal >= 5) {
            $colorcircle = "background-color: #1e4da9;";
            $obtenido = "Obtenido";
            if ($notaSemanal >= 10) {
                $colorcircle2 = "background-color: #1e4da9;";
                $obtenido2 = "Obtenido";
            }
        }
    } elseif ($notaSemanal > 10 && $notaSemanal<= 15) {
        $barraMedalla = 61;
        $barraMedalla2 = 61;
        $notaSemanal3 = $notaSemanal-10;
        $barraMedalla3 = ($notaSemanal3*61)/5;
        if ($notaSemanal >= 10) {
            $colorcircle = "background-color: #1e4da9;";
            $colorcircle2 = "background-color: #1e4da9;";
            $obtenido = "Obtenido";
            $obtenido2 = "Obtenido";
            if ($notaSemanal >= 15) {
                $colorcircle3 = "background-color: #1e4da9;";
                $obtenido3 = "Obtenido";
            }
        }
    } elseif ($notaSemanal > 15) {
        $barraMedalla = 61;
        $barraMedalla2 = 61;
        $barraMedalla3 = 61;
        $notaSemanal4 = $notaSemanal-15;
        $barraMedalla4 = ($notaSemanal4*61)/5;
        if ($notaSemanal >= 15) {
            $colorcircle = "background-color: #1e4da9;";
            $colorcircle2 = "background-color: #1e4da9;";
            $colorcircle3 = "background-color: #1e4da9;";
            $obtenido = "Obtenido";
            $obtenido2 = "Obtenido";
            $obtenido3 = "Obtenido";
            if ($notaSemanal >= 20) {
                $barraMedalla4 = 61;
                $colorcircle4 = "background-color: #1e4da9;";
                $obtenido4 = "Obtenido";
            }
        }
    } 
    else {
        $barraMedalla = 0;
    }

    if ($notaSemanal >= 5 && $notaSemanal < 10) {
        $medallaObtenida = '<div class="circle-logro" style="background-color: #1e4da9;"><img class="imagen-logro"  src="../img/bronce-insignia.webp"></img></div>';
    } elseif ($notaSemanal >= 10 && $notaSemanal < 15) {
        $medallaObtenida = '<div class="circle-logro2" style="background-color: #1e4da9;"><img class="imagen-logro"  src="../img/plata-insignia_1.webp"></div>';
    } elseif ($notaSemanal >= 15 && $notaSemanal < 20) {
        $medallaObtenida = '<div class="circle-logro2" style="background-color: #1e4da9;"><img class="imagen-logro"  src="../img/oro-insignia_1.webp"></div>';
    } elseif ($notaSemanal >= 20) {
        $medallaObtenida = '<div class="circle-logro2" style="background-color: #1e4da9;"><img class="imagen-logro"  src="../img/maxima-insignia.webp"></div>';
    } else {
        $medallaObtenida = '';
    }
?>