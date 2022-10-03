<html>
    <head>
        <title>Tipos de variables </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/estilos.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>



        <?php
        /*
         * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
         * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
         */
//$variable = null;
        $variable = 122.34343;
//$variable = '122.34343';
//$variable = TruE;
//$variable = -7;
        ?>

        <table>
            <thead>

                <tr>
                    <th>
                        <?php echo "\$variable=" . var_export($variable, TRUE);
                        ?>
                    </th>
                </tr>
            </thead>
            <tbody>

                <tr><td>
                        <?php
                        echo "La \$variable está definida y es diferentes de null? " . var_export(isset($variable), true);
                        ?>
                    </td>
                </tr>   <tr><td>
                        <?php echo "La \$variable es null?: " . var_export(is_null($variable), true); ?>
                    </td>
                </tr>   <tr><td> <?php echo "El tipo de \$variable es:" . gettype($variable); ?>
                    </td>
                </tr>   <tr><td> <?php echo "El resultado de var_dump(\$variable) es: ", var_dump($variable); ?>
                    </td>
                </tr>   <tr><td> <?php
                        echo "El resultado de var_export(\$variable) es: ", var_export($variable);
                        ?>
                    </td>
                </tr>
            </tbody></table>
    </body>
</html>