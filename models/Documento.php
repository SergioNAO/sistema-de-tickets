<?php
    class Documento extends Conectar{
        
        public function insert_documento($ticket_id,$doc_nom){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="INSERT INTO td_documento (doc_id,ticket_id,doc_nom,fecha_crea,estado) VALUES (null,?,?,now(),1);";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(1,$ticket_id);
            $sql->bindParam(2,$doc_nom);
            $sql->execute();
        }

        public function get_documento_x_ticket($ticket_id){
            $conectar= parent::conexion();
            /* consulta sql */
            $sql="SELECT * FROM td_documento WHERE ticket_id=?";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(1,$ticket_id);
            $sql->execute();
            return $resultado = $sql->fetchAll(pdo::FETCH_ASSOC);
        }
    }
?>