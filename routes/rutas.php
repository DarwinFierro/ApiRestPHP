<?php 

    $arrayRutas = explode("/", $_SERVER['REQUEST_URI']);

    if (count(array_filter($arrayRutas))==2) {

        /*=========================================
        Cuando no se hace ninguna peticion a la Api
        ===========================================*/
        $json=array(
            "detalle"=>"no encontrado"
        );
    
        echo json_encode($json, true);
        return;
    }else {
        /*=========================================
        Cuando pasamos solo un indice en el array $arrayRutas
        ===========================================*/
        if (count(array_filter($arrayRutas))==3) {

            /*=========================================
            Cuando hago peticiones desde cursos
            ===========================================*/
            if (array_filter($arrayRutas)[3]=="cursos") {
                switch($_SERVER['REQUEST_METHOD']){
                    /*=========================================
                    Peticion GET
                    ===========================================*/
                    case 'GET': 
                        if(isset($_GET["pagina"]) && is_numeric($_GET["pagina"])){
                            $cursos=new ControladorCurso();
                            $cursos->index($_GET["pagina"]);
                        }else {
                            $cursos = new ControladorCurso();
                            $cursos->index(null);
                        }
                        
                    break;
                    /*=========================================
                    Peticion POST
                    ===========================================*/
                    case 'POST':
                        $datos=array(
                            "titulo"=>$_POST["titulo"], 
                            "descripcion"=>$_POST["descripcion"], 
                            "instructor"=>$_POST["instructor"],
                            "imagen"=>$_POST["imagen"], 
                            "precio"=>$_POST["precio"]
                        );
                        $cursos = new ControladorCurso();
                        $cursos->create($datos);
                    break;
                }
            }

            /*=========================================
            Cuando hago peticiones desde registro
            ===========================================*/
            if (array_filter($arrayRutas)[3]=="registro") {
                switch($_SERVER['REQUEST_METHOD']){
                    /*=========================================
                    Peticion POST
                    ===========================================*/
                    case 'POST':
                        $datos=array(
                            "nombre"=>$_POST["nombre"], 
                            "apellido"=>$_POST["apellido"], 
                            "email"=>$_POST["email"]);
                        $clientes = new ControladorClientes();
                        $clientes->create($datos);
                    break;
                }
            }
        }else {
            /*=========================================
            Cuando hago peticiones desde cursos con un id
            ===========================================*/
            if (array_filter($arrayRutas)[3]=="cursos" && is_numeric(array_filter($arrayRutas)[4])) {
                switch($_SERVER['REQUEST_METHOD']){
                    /*=========================================
                    Peticion GET
                    ===========================================*/
                    case 'GET': 
                        $cursos = new ControladorCurso();
                        $cursos->show(array_filter($arrayRutas)[4]);
                    break;
                    /*=========================================
                    Peticion PUT
                    ===========================================*/
                    case 'PUT': 
                        $datos=array();
                        parse_str(file_get_contents('php://input'), $datos);
                        $cursos = new ControladorCurso();
                        $cursos->update($datos,array_filter($arrayRutas)[4]);
                    break;
                    /*=========================================
                    Peticion DELETE
                    ===========================================*/
                    case 'DELETE': 
                        $cursos = new ControladorCurso();
                        $cursos->delete(array_filter($arrayRutas)[4]);
                    break;
                        
                }
            }
        }
    }
?>