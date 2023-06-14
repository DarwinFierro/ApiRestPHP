<?php
class ControladorClientes{
    public function create($datos)
    {
        /*=========================================
        Validando Nombre
        ===========================================*/
        if (isset($datos["nombre"]) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/', $datos["nombre"])) {
            $json = array(
                "status"=>404,
                "detalle" => "Error! en el campo nombre Solo estan permitidos letras"
            );

            echo json_encode($json, true);

            return;
        }

        /*=========================================
        Validando Apellido
        ===========================================*/

        if (isset($datos["apellido"]) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]+$/', $datos["apellido"])) {
            $json = array(
                "status"=>404,
                "detalle" => "Error! en el campo apellido Solo estan permitidos letras"
            );

            echo json_encode($json, true);

            return;
        }

        /*=========================================
        Validando email
        ===========================================*/
        if (isset($datos["email"]) && !preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $datos["email"])) {
            $json = array(
                "detalle" => "Error en el campo email"
            );

            echo json_encode($json, true);

            return;
        }
        /*=========================================
        Validando email repetido
        ===========================================*/
        $clientes=Cliente::validacionCorreo("clientes", "email", $datos["email"]);
        if ($clientes!=null) {
            $json = array(
                "detalle" => "Error! Correo ya registrado en la base de datos"
            );
    
            echo json_encode($json, true);
    
            return;
        }
        /*=========================================
        Generar Credenciales del cliente
        ===========================================*/
        $id_cliente=str_replace("$","c",crypt($datos["nombre"].$datos["apellido"].$datos["email"], '$2a$07$afartwetsdAD52356FEDGsfhsd$'));
        $llave_secreta=str_replace("$","c",crypt($datos["email"].$datos["apellido"].$datos["nombre"], '$2a$07$afartwetsdAD52356FEDGsfhsd$'));

        $datos=array(
            "nombre"=>$datos["nombre"], 
            "apellido"=>$datos["apellido"], 
            "email"=>$datos["email"],
            "id_cliente"=>$id_cliente,
            "llave_secreta"=>$llave_secreta
        );
       
        $create = Cliente::create("clientes",$datos);
        if ($create == "ok") {
            $json = array(
                "status"=>200,
                "detalle" => "se genero sus credenciales",
                "id_cliente" =>$id_cliente,
                "llave_secreta" => $llave_secreta
            );
    
            echo json_encode($json, true);
    
            return;
        }
    }
}