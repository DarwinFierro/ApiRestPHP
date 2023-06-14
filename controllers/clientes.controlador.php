<?php
class ControladorClientes{
    public function create(){
        $json=array(
            "detalle"=>"estas en la vista registro "
        );
    
        echo json_encode($json, true);
    }
}
?>