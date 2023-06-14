<?php
class Conexion{
    static public function conectar(){
        try{
            $link = new PDO("mysql:local=localhost;dbname=apidrest","root","");
            $link->exec("set names utf8");
            return $link;
        }catch(Exception $e){
            print "¡Error BD!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
?>