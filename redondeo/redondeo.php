<html>
    <head>
        <title>Resultado cálculo 2ª evaluación</title>
        <link href="../css/estilos.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>

        <?php
        const PESO_UD5_CURSO = 0.15;
        const PESO_UD6_CURSO = 0.1;
        //otra forma de declarar constante
        define('MAX_TAREAS_NOW', 7);
        const UMBRAL_REDONDEO = 0.5;
        const UMBRAL_APROBADO = 4.5;
        const MAX_SUSPENSOS = 4;

        $peso_ud5_eval = PESO_UD5_CURSO / (PESO_UD5_CURSO + PESO_UD6_CURSO);
        $peso_ud6_eval = PESO_UD6_CURSO / (PESO_UD5_CURSO + PESO_UD6_CURSO);
        $umbral_tareas = round(MAX_TAREAS_NOW / 2);
        $mensaje = "";

        echo "El peso de la ud5 en la 2ª eval es: $peso_ud5_eval <br/>";
        echo "El peso de la ud6 en la 2ª eval es: $peso_ud6_eval <br/>";

        foreach ($_REQUEST as $clave => $valor) {
            echo "<strong>$clave</strong>: $valor <br/>";

            if ($clave === "cal_ud5") {
                $cal_ud5 = $valor;
            } elseif ($clave === "cal_ud6") {
                $cal_ud6 = $valor;
            } elseif ($clave === "tareas_ap_alumno") {
                $tareas_ap_alumno = $valor;
            }
        }

        $media_ponderada = $cal_ud5 * $peso_ud5_eval +
                $cal_ud6 * $peso_ud6_eval;

        echo "La media ponderada es: $media_ponderada";

        if ($cal_ud5 >= 4 && $cal_ud6 >= 4) {
            if ($media_ponderada >= 5) {
                //alumno/a aprobado
                if (
                        ($media_ponderada - floor($media_ponderada)) != UMBRAL_REDONDEO) {
                    $nota_eval = round($media_ponderada);
                } else {
                    //todo aprobado, 0.5 parte decimal
                    if ($tareas_ap_alumno >= $umbral_tareas) {
                        $nota_eval = round($media_ponderada);
                    } else {
                        $nota_eval = round($media_ponderada, 0, PHP_ROUND_HALF_DOWN);
                        //$nota_eval = floor($media_ponderada);
                    }
                }
            } elseif ($media_ponderada >= 4.5 && $media_ponderada < 5) {
                $mensaje = "La calificación dependerá del criterio del redondeo.";
            }
        } else {
            if ($media_ponderada >= UMBRAL_APROBADO) {//4.5
                $nota_eval = MAX_SUSPENSOS; //4
            } else {
                //Repetimos la misma comprobación por si alumno tiene un 2.5
                if (
                        ($media_ponderada - floor($media_ponderada)) != UMBRAL_REDONDEO) {
                    $nota_eval = round($media_ponderada);
                } else {
                    //todo aprobado, 0.5 parte decimal
                    if ($tareas_ap_alumno >= $umbral_tareas) {
                        $nota_eval = round($media_ponderada);
                    } else {
                        $nota_eval = round($media_ponderada, 0, PHP_ROUND_HALF_DOWN);
                        //$nota_eval = floor($media_ponderada);
                    }
                }
            }
        }
        ?>




        <table>
            <thead>
                <tr>
                    <th>Cal. UD5</th>
                    <th>Cal. UD6</th>
                    <th>Media ponderada (sin redondear)</th>
                    <th>Calificación entera 2ª eval.</th>
                    <th>Comentarios</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $cal_ud5 ?></td>
                    <td><?php echo $cal_ud6 ?></td>
                    <td><?php echo $media_ponderada ?></td>
                    <td><?php if($mensaje=="") {echo $nota_eval;} ?></td>
                    <td><?php echo $mensaje ?></td>
                </tr>
            </tbody>
        </table>


    </body>
</html>

