<?php

class ControladorCurso{
    public function index($pagina){
        /*=========================================
        Validando Credenciales cliente
        ===========================================*/
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            if ((Cliente::validarCliente("clientes", $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) == null) {
                $json = array(
                    "status" => 404,
                    "detalle" => "Credenciales invalidas"
                );

                echo json_encode($json, true);
                return;
            } else {
                if ($pagina != null) {
                    $cantidad = 10;
                    $desde = ($pagina - 1) * $cantidad;

                    $cursos = Curso::index("cursos", $cantidad, $desde);
                    $json = array(
                        "status" => 200,
                        "total_registros" => count($cursos),
                        "detalle" => $cursos
                    );

                    echo json_encode($json, true);
                    return;
                } else {
                    $cursos = Curso::index("cursos", null, null);
                    $json = array(
                        "status" => 200,
                        "total_registros" => count($cursos),
                        "detalle" => $cursos
                    );

                    echo json_encode($json, true);
                    return;
                }
            }
        } else {
            $json = array(
                "status" => 404,
                "detalle" => "No hay Credenciales"
            );

            echo json_encode($json, true);
            return;
        }
    }

    public function create($datos){
        /*=========================================
        Validando Credenciales cliente
        ===========================================*/
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            if ((Cliente::validarCliente("clientes", $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) == null) {
                $json = array(
                    "status" => 404,
                    "detalle" => "Credenciales invalidas"
                );

                echo json_encode($json, true);
                return;
            } else {
                /*=============================================
                    Validar datos
                    =============================================*/
                foreach ($datos as $key => $valueDatos) {
                    if (isset($valueDatos) && !preg_match('/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $valueDatos)) {
                        $json = array(
                            "status" => 404,
                            "detalle" => "Error en el campo " . $key
                        );
                        echo json_encode($json, true);
                        return;
                    }
                }

                /*=============================================
                Validar que el titulo o la descripcion no estén repetidos
                =============================================*/
                $cursos = Curso::index("cursos", null, null);
                foreach ($cursos as $key => $value) {
                    if ($value->titulo == $datos["titulo"]) {
                        $json = array(
                            "status" => 404,
                            "detalle" => "El título ya existe en la base de datos"
                        );
                        echo json_encode($json, true);
                        return;
                    }

                    if ($value->descripcion == $datos["descripcion"]) {
                        $json = array(
                            "status" => 404,
                            "detalle" => "La descripción ya existe en la base de datos"
                        );
                        echo json_encode($json, true);
                        return;
                    }
                }

                $create = Curso::create("cursos", $datos);
                /*=============================================
                Respuesta del modelo
                =============================================*/
                if ($create == "ok") {
                    $json = array(
                        "status" => 200,
                        "detalle" => "Registro exitoso, su curso ha sido guardado"
                    );
                    echo json_encode($json, true);
                    return;
                }
            }
        } else {
            $json = array(
                "status" => 404,
                "detalle" => "No Envio Credenciales"
            );
            echo json_encode($json, true);
            return;
        }
    }

    public function show($id){
        /*=========================================
         Validando Credenciales cliente
         ===========================================*/
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            if ((Cliente::validarCliente("clientes", $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) == null) {
                $json = array(
                    "status" => 404,
                    "detalle" => "Credenciales invalidas"
                );

                echo json_encode($json, true);
                return;
            } else {
                $curso = Curso::show("cursos", $id);
                if (!empty($curso)) {
                    $json = array(
                        "status" => 200,
                        "detalle" => $curso
                    );

                    echo json_encode($json, true);
                    return;
                } else {
                    $json = array(
                        "status" => 404,
                        "detalle" => "No hay ningun curso registrado"
                    );

                    echo json_encode($json, true);
                    return;
                }
            }
        }
    }

    public function update($datos, $id){
        /*=========================================
         Validando Credenciales cliente
         ===========================================*/
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            if ((Cliente::validarCliente("clientes", $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) == null) {
                $json = array(
                    "status" => 404,
                    "detalle" => "Credenciales invalidas"
                );

                echo json_encode($json, true);
                return;
            } else {
                /*=============================================
                Validar datos
                =============================================*/
                foreach ($datos as $key => $valueDatos) {
                    if (isset($valueDatos) && !preg_match('/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $valueDatos)) {
                        $json = array(
                            "status" => 404,
                            "detalle" => "Error en el campo " . $key
                        );
                        echo json_encode($json, true);
                        return;
                    }
                }

                $update = Curso::update("cursos", $datos, $id);
                /*=============================================
                Respuesta del modelo
                =============================================*/
                if ($update == "ok") {
                    $json = array(
                        "status" => 200,
                        "detalle" => "Actualizacion exitoso, su curso ha sido Editado"
                    );
                    echo json_encode($json, true);
                    return;
                }
            }
        } else {
            $json = array(
                "status" => 404,
                "detalle" => "No Envio Credenciales"
            );
            echo json_encode($json, true);
            return;
        }
    }
    public function delete($id){
        /*=========================================
        Validando Credenciales cliente
        ===========================================*/
        $clientes = Cliente::index("clientes");
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            if ((Cliente::validarCliente("clientes", $_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) == null) {
                $json = array(
                    "status" => 404,
                    "detalle" => "Credenciales invalidas"
                );

                echo json_encode($json, true);
                return;
            } else {
                $delete = Curso::delete("cursos", $id);

                if ($delete == "ok") {
                    $json = array(
                        "status" => 200,
                        "detalle" => "Actualizacion exitoso, su curso ha sido Eliminado"
                    );
                    echo json_encode($json, true);
                    return;
                }
            }
        }
    }
}
?>