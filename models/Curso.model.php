
<?php 
    require_once "conexion.php";

    class Curso{
        static public function index($tabla, $cantidad, $desde){

            if ($cantidad !=null) {
                $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla LIMIT $desde, $cantidad");
                
            }else {
                $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS);
            $stmt->close();
            $stmt=null;
        
        }

        static public function create($tabla,$datos){
            $stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(titulo, descripcion, instructor, imagen, precio) 
            VALUES (:titulo, :descripcion, :instructor, :imagen, :precio)");

            $stmt->bindParam(":titulo", $datos["titulo"], PDO::PARAM_STR);
            $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
            $stmt->bindParam(":instructor", $datos["instructor"], PDO::PARAM_STR);
            $stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
            $stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);

            if ($stmt->execute()) {
                return "ok";
            }else {
                print_r(Conexion::conectar()->errorInfo());
            }
            
            $stmt->close();
            $stmt=null;
        }

        static public function show($tabla,$id){
            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id=:id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt->close();
            $stmt=null;
        }

        static public function update($tabla,$datos,$id){
            $stmt=Conexion::conectar()->prepare("UPDATE $tabla SET titulo=:titulo, descripcion=:descripcion, 
            instructor=:instructor, imagen=:imagen, precio=:precio WHERE id=:id");

            $stmt->bindParam(":titulo", $datos["titulo"], PDO::PARAM_STR);
            $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
            $stmt->bindParam(":instructor", $datos["instructor"], PDO::PARAM_STR);
            $stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
            $stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return "ok";
            }else {
                print_r(Conexion::conectar()->errorInfo());
            }
            
            $stmt->close();
            $stmt=null;
        }

        static public function delete($tabla,$id){
            $stmt=Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id=:id");

            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return "ok";
            }else {
                print_r(Conexion::conectar()->errorInfo());
            }
            
            $stmt->close();
            $stmt=null;
        }
    }
?>