<?php
require_once "controllers/rutas.controlador.php";
require_once "controllers/cursos.controlador.php";
require_once "controllers/clientes.controlador.php";
require_once "models/Cliente.model.php";
require_once "models/Curso.model.php";

$rutas = new ControladorRutas();
$rutas->inicio();
?>