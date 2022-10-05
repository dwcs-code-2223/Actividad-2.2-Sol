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

        $media_ponderada = calcularMediaPonderada($cal_ud5, $cal_ud6,
                $peso_ud5_eval, $peso_ud6_eval);//              

        echo "La media ponderada es: $media_ponderada";

        if ($cal_ud5 >= 4 && $cal_ud6 >= 4) {
            if ($media_ponderada >= 5) {
                $nota_eval = redondear($media_ponderada, $tareas_ap_alumno, MAX_TAREAS_NOW);
            } else {
                $nota_eval = calcularCalEvalEnFuncionTareas($media_ponderada, $tareas_ap_alumno, MAX_TAREAS_NOW);
            }
        } else {
            $nota_eval = calcularNotaEvalSuspensos($media_ponderada, $tareas_ap_alumno, MAX_TAREAS_NOW);
        }

        function calcularMediaPonderada(float $cal_ud_x, float $cal_ud_y, float $peso_ud_x, float $peso_ud_y): float {

            return $cal_ud_x * $peso_ud_x + $cal_ud_y * $peso_ud_y;
        }

        function calcularCalEvalEnFuncionTareas(float $media_ponderada,
                int $tareas_ap_alumno,
                int $tareas_hasta_ahora): int {

            $umbral_tareas = round($tareas_hasta_ahora / 2);
            if ($tareas_ap_alumno >= $umbral_tareas) {
                $nota_eval = round($media_ponderada);
            } else {
                //$nota_eval = floor($media_ponderada);
                $nota_eval = floor($media_ponderada);
                //var_dump($nota_eval);
              
            }

            return $nota_eval;
        }

        function terminaEn05(float $media_ponderada): bool {
            return (($media_ponderada - floor($media_ponderada)) == UMBRAL_REDONDEO);
        }

        function calcularNotaEvalSuspensos(float $media_ponderada, int $tareas_ap_alumno, int $max_tareas_ahora): int {
            if ($media_ponderada >= UMBRAL_APROBADO) {//4.5
                $nota_eval = MAX_SUSPENSOS; //4
            } else {
                //Repetimos la misma comprobación por si alumno tiene un 2.5
                $nota_eval = redondear($media_ponderada, $tareas_ap_alumno, MAX_TAREAS_NOW);
            }
            return $nota_eval;
        }

        function redondear(float $media_ponderada, int $tareas_ap_alumno, int $max_tareas_ahora) {
            if (!terminaEn05($media_ponderada)) {
                $nota_eval = round($media_ponderada);
            } else {
                //suspenso con 0.5 en parte decimal
                $nota_eval = calcularCalEvalEnFuncionTareas($media_ponderada, $tareas_ap_alumno, $max_tareas_ahora);
            }
            return $nota_eval;
        }
        ?>




        <table>
            <thead>
                <tr>
                    <th>Cal. UD5</th>
                    <th>Cal. UD6</th>
                    <th>Media ponderada (sin redondear)</th>
                    <th>Calificación entera 2ª eval.</th>
               
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $cal_ud5 ?></td>
                    <td><?php echo $cal_ud6 ?></td>
                    <td><?php echo $media_ponderada ?></td>
                    <td><?php echo $nota_eval; ?></td>

                </tr>
            </tbody>
        </table>


    </body>
</html>

