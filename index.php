<?php
require_once "controllers/rutas.controlador.php";
require_once "controllers/cursos.controlador.php";
require_once "controllers/clientes.controlador.php";

$rutas = new ControladorRutas();
$rutas->inicio();
?>