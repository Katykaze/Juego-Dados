<?php
jugarDados();
function jugarDados()
{
    $arrayNombreJugadores = obtenerNombresDeJugadores();
    $cantidadDados = obtenerNumeroDeDadosFormulario();
    if (!esInicioDePartidaValido($arrayNombreJugadores, $cantidadDados)) {
        echo ("<script>window.location='p01_dados.html'</script>");
    } else {
        $dadosRepartidos = repartirDados($arrayNombreJugadores, $cantidadDados);
        $jugadoresYDados = array();
        //echo "<pre>";var_dump($dadosRepartidos);echo "</pre>";
        for ($i = 0; $i < count($arrayNombreJugadores); $i++) {
            $jugadoresYDados[$arrayNombreJugadores[$i]] = $dadosRepartidos[$i];
        }
        imprimirJugadoresYSusDados($jugadoresYDados);
        generarPuntuacionesGanadores($jugadoresYDados);
    }
}
function generarPuntuacionesGanadores($jugadoresYDados)
{
    $ganador = "";
    $puntacionesTodosJugadores = array();
    foreach ($jugadoresYDados as $keys => $values) {
        $puntuacion = 0;
        foreach ($values as $dado) {
            $puntuacion += $dado;
            if (count(array_unique($values)) == 1) {
                $puntuacion = 100;
                $ganador .= $keys;
            }
        }
        array_push($puntacionesTodosJugadores, $puntuacion);
        echo $keys . " = " . $puntuacion . "<br>";
    }
    //echo "<pre>";var_dump($puntacionesTodosJugadores);echo "</pre>";
    $repeticiones = array_count_values($puntacionesTodosJugadores);
    //echo "<pre>";var_dump($repeticiones);echo "</pre>";
    $puntuacionGanadora = max($puntacionesTodosJugadores);
    echo "Puntuacion  Ganadora = " . $puntuacionGanadora . "<br>";
    foreach ($repeticiones as $keys => $values) {
        if ($keys == $puntuacionGanadora) {
            echo "Cantidad de ganadores = " . $values . "<br>";
        }
    }
    $arrayNombreJugadores = obtenerNombresDeJugadores();
    for ($i = 0; $i < count($puntacionesTodosJugadores); $i++) {
        $jugadoresYPuntuaciones[$arrayNombreJugadores[$i]] = $puntacionesTodosJugadores[$i];
    }
    //echo "<pre>";var_dump($jugadoresYPuntuaciones);echo "</pre>";
    foreach ($jugadoresYPuntuaciones as $keys => $values) {
        if ($puntuacionGanadora == $values) {
            $ganador .= $keys;
        }
    }
    echo "GANADOR = " . $ganador . " <br> ";
}
function repartirDados($arrayNombreJugadores, $cantidadDados)
{
    $dadosRepartidos = array();
    for ($i = 0; $i < count($arrayNombreJugadores); $i++) {
        array_push($dadosRepartidos, asignarCantidadDadosPorJugador($cantidadDados));
    }
    return $dadosRepartidos;
}
function asignarCantidadDadosPorJugador($cantidadDados)
{
    $dadosJugador = array();
    for ($i = 0; $i < $cantidadDados; $i++) {
        array_push($dadosJugador, rand(1, 6));
    }
    return $dadosJugador;
}
function obtenerNombresDeJugadores() //obtenerNombresDeJugadoresNombresDeJugadores
{
    $arrayNombreJugadores = array();
    $nombreJugador1 = test_input($_POST["jug1"]);
    $nombreJugador2 = test_input($_POST["jug2"]);
    $nombreJugador3 = test_input($_POST["jug3"]);
    $nombreJugador4 = test_input($_POST["jug4"]);
    array_push($arrayNombreJugadores, $nombreJugador1, $nombreJugador2, $nombreJugador3, $nombreJugador4);
    return $arrayNombreJugadores;
}
function esInicioDePartidaValido($arrayNombreJugadores, $cantidadDados) //esInicioDePartidaValido
{
    $contadorJugadores = 0;
    $valido = true;
    for ($i = 0; $i < count($arrayNombreJugadores); $i++) {
        if (!empty($arrayNombreJugadores[$i])) {
            $contadorJugadores++;
        }
    }
    if ($contadorJugadores > 4 || $contadorJugadores < 2) {
        $valido = false;
    }
    if ($valido && ($cantidadDados < 1 || $cantidadDados > 10)) {
        $valido = false;
    }
    return $valido;
}
function obtenerNumeroDeDadosFormulario()
{
    $cantidadDados = test_input($_POST["numdados"]); //obtenerNombresDeJugadoresNumeroDeDadosFormulario
    return $cantidadDados;
}
function imprimirJugadoresYSusDados($jugadoresYDados)
{
    echo "<h1> RESULTADO JUEGO </h1>";
    echo  "<table border ='1'>";
    foreach ($jugadoresYDados as $key => $values) {
        echo "<tr>";
        echo "<td>";
        echo "Los dados de " . $key . " son: ";
        echo "</td>";
        foreach ($values as $dado) {
            echo "<td><img src='./images/$dado.PNG'WIDTH='100' HEIGHT='100'></td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
