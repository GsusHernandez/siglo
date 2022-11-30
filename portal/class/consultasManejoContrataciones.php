<?php include ("../bd/consultasContrataciones.php");

if($_POST['exe'] == "añadirContratacion"){
    $tipoId = $_POST["ctTipo_id"];
    $identificacion = $_POST["ct_id"];
    $nombres = $_POST["ctNombres"];
    $apellidos = $_POST["ctApellidos"];
    $fInicio = $_POST["ctFechaInicio"];
    $fFin = $_POST["ctFechaFin"];
    $tipoContrato = $_POST["ctTipoContrato"];
    $fechaDevolucion = $_POST["ctfechaDevolucion"];
    $cargo = $_POST["ctCargo"];
    $salario = $_POST["ctSalario"];

    $variable = añadirContratacion($tipoId, $identificacion, $nombres, $apellidos, $fInicio, $fFin, $tipoContrato, $cargo, $salario);
    echo $variable;
}
?>