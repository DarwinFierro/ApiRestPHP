<?php

class ControladorCurso{
    public function index(){
        $json=array(
            "detalle"=>"estas en la vista cursos"
        );
    
        echo json_encode($json, true);
    }

    public function create(){
        $json=array(
            "detalle"=>"estas en la vista create de cursos"
        );
    
        echo json_encode($json, true);
    }

    public function show($id){
        $json=array(
            "detalle"=>"este es el curso con el id: ".$id
        );
    
        echo json_encode($json, true);
    }

    public function update($id){
        $json=array(
            "detalle"=>"Moodifico el curso con el id: ".$id
        );
    
        echo json_encode($json, true);
    }

    public function delete($id){
        $json=array(
            "detalle"=>"Elimino el curso con el id: ".$id
        );
    
        echo json_encode($json, true);
    }
}
    
?>