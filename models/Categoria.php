<?php
    class Categoria extends Conectar{ 
        public function get_categoria(){
            $conectar = parent::conexion();
            parent::set_name();
            /* $sql = "call sp_tm_categoria_get_categoria()"; */
            $sql = "SELECT * FROM tm_categoria WHERE estado=1;";
            $sql = $conectar -> prepare($sql);
            $sql -> execute();
            return $resultado = $sql -> fetchAll();
        }
    }
?>


