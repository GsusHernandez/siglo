<?php 
function añadirContratacion($tipoId, $identificacion, $nombres, $apellidos, $fInicio, $fFin, $tipoContrato, $cargo, $salario){
    global $con;
    
    $queryAgregarCon = mysqli_query($con, "INSERT INTO usuarios(tipo_doc, identificacion, nombres, apellidos, vigente) VALUES ($tipoId, $identificacion, $nombres, $apellidos)");

    if(g)
}
?>