<?php
    class Ticket extends Conectar{   
        public function insert_ticket($usu_id,$cat_id,$ticket_titulo,$ticket_descripcion){
            $conectar = parent::conexion();
            parent::set_name();
            /*$sql = "call sp_Ticket_insert_ticket(?,?,?,?)"; */
            $sql = "INSERT INTO tm_ticket(ticket_id,usu_id,cat_id,ticket_titulo,ticket_descripcion,ticket_estado,fecha_crear,usuario_asignado,fecha_asignacion,estado) VALUES (NULL,?,?,?,?,'Abierto',now(),NULL,NULL, '1')";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1,$usu_id);
            $sql -> bindValue(2,$cat_id);
            $sql -> bindValue(3,$ticket_titulo);
            $sql -> bindValue(4,$ticket_descripcion);
            $sql -> execute();

            $sql1="SELECT last_insert_id() AS 'ticket_id';";
            $sql1=$conectar->prepare($sql1);
            $sql1->execute();
            return $resultado=$sql1->fetchAll(pdo::FETCH_ASSOC);
        }

        public function listar_ticket_x_usu($usu_id){
            $conectar = parent::conexion();
            parent::set_name();
            /* $sql = "call sp_Ticket_listar_ticket_x_usu(?)";*/
            $sql = "SELECT
                tm_ticket.ticket_id,
                tm_ticket.usu_id,
                tm_ticket.cat_id,
                tm_ticket.ticket_titulo,
                tm_ticket.ticket_descripcion,
                tm_ticket.ticket_estado,
                tm_ticket.fecha_crear,
                tm_ticket.usuario_asignado,
                tm_ticket.fecha_asignacion,
                tm_usuarios.usu_nom,
                tm_usuarios.usu_ape,
                tm_categoria.cat_nom
                FROM
                tm_ticket
                INNER JOIN tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
                INNER JOIN tm_usuarios on tm_ticket.usu_id = tm_usuarios.usu_id
                WHERE
                tm_ticket.estado = 1
                AND tm_usuarios.usu_id=?;"; 
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $usu_id);
            $sql -> execute();
            return $resultado = $sql -> fetchAll();

        }

        public function listar_ticket_x_id($ticket_id){
            $conectar= parent::conexion();
            parent::set_name();
            /* $sql="call sp_Ticket_listar_ticket_x_id(?)"; */
            $sql="SELECT 
                tm_ticket.ticket_id,
                tm_ticket.usu_id,
                tm_ticket.cat_id,
                tm_ticket.ticket_titulo,
                tm_ticket.ticket_descripcion,
                tm_ticket.ticket_estado,
                tm_ticket.fecha_crear,
                tm_usuarios.usu_nom,
                tm_usuarios.usu_ape,
                tm_usuarios.usu_correo,
                tm_categoria.cat_nom
                FROM 
                tm_ticket
                INNER join tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
                INNER join tm_usuarios on tm_ticket.usu_id = tm_usuarios.usu_id
                WHERE
                tm_ticket.estado = 1
                AND tm_ticket.ticket_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $ticket_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function listar_ticket(){
            $conectar = parent::conexion();
            parent::set_name();
            /* $sql = "call sp_Ticket_listar_ticket()"; */
            $sql = "SELECT
                tm_ticket.ticket_id,
                tm_ticket.usu_id,
                tm_ticket.cat_id,
                tm_ticket.ticket_titulo,
                tm_ticket.ticket_descripcion,
                tm_ticket.ticket_estado,
                tm_ticket.fecha_crear,
                tm_ticket.usuario_asignado,
                tm_ticket.fecha_asignacion,
                tm_usuarios.usu_nom,
                tm_usuarios.usu_ape,
                tm_categoria.cat_nom
                FROM
                tm_ticket
                INNER JOIN tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
                INNER JOIN tm_usuarios on tm_ticket.usu_id = tm_usuarios.usu_id
                WHERE
                tm_ticket.estado = 1;";
            $sql = $conectar -> prepare($sql);
            $sql -> execute();
            return $resultado = $sql -> fetchAll();

        }

        public function listar_ticketdetalle_x_ticket($ticket_id){
            $conectar = parent::conexion();
            parent::set_name();
            /* $sql = "call sp_Ticket_listar_ticketdetalle_x_ticket(?)"; */
            $sql = "SELECT 
                td_ticketdetalle.ticketd_id,
                td_ticketdetalle.ticketd_descripcion,
                td_ticketdetalle.fecha_crear,
                tm_usuarios.usu_nom,
                tm_usuarios.usu_ape,
                tm_usuarios.rol_id
                FROM 
                td_ticketdetalle 
                INNER JOIN tm_usuarios on td_ticketdetalle.usu_id = tm_usuarios.usu_id
                WHERE 
                ticket_id = ?";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $ticket_id);
            $sql -> execute();
            return $resultado = $sql -> fetchAll();

        }

        public function insert_ticketdetalle($ticket_id,$usu_id,$ticketd_descripcion){
            $conectar = parent::conexion();
            parent::set_name();
            /* $sql = "call sp_Ticket_insert_ticketdetalle(?,?,?)"; */
            $sql = "INSERT INTO td_ticketdetalle (ticketd_id, ticket_id, usu_id, ticketd_descripcion, fecha_crear, estado) VALUES (NULL,?,?,?,now(), '1');";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $ticket_id);
            $sql -> bindValue(2, $usu_id);
            $sql -> bindValue(3, $ticketd_descripcion);
            $sql -> execute();
            return $resultado = $sql -> fetchAll();

        }

        public function insert_ticketdetalle_cerrar($ticket_id,$usu_id){
            $conectar = parent::conexion();
            parent::set_name();
            /* $sql = "call sp_Ticket_insert_ticketdetalle_cerrar(?, ?)"; */
            $sql = "INSERT INTO td_ticketdetalle (ticketd_id, ticket_id, usu_id, ticketd_descripcion, fecha_crear, estado) VALUES (NULL,?,?,'Ticket Cerrado...',now(), '1');";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $ticket_id);
            $sql -> bindValue(2, $usu_id);
            $sql -> execute();
            return $resultado = $sql -> fetchAll();

        }

        public function update_ticket($ticket_id){
            $conectar = parent::conexion();
            parent::set_name();
            /* $sql = "call sp_Ticket_update_ticket(?)"; */
            $sql = "UPDATE tm_ticket
                    SET
                        ticket_estado = 'Cerrado'
                    WHERE
                        ticket_id = ? ";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $ticket_id);
            $sql -> execute();
            return $resultado = $sql -> fetchAll();

        }

        public function update_ticket_asignacion($ticket_id,$usuario_asignado,){
            $conectar = parent::conexion();
            parent::set_name();
            $sql = "UPDATE tm_ticket
                    SET
                        usuario_asignado = ?,
                        fecha_asignacion = now()
                    WHERE
                        ticket_id = ? "; 
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $usuario_asignado);
            $sql -> bindValue(2, $ticket_id);
            $sql -> execute();
            return $resultado = $sql -> fetchAll();
        }

        public function get_ticket_total(){
            $conectar = parent::conexion();
            parent::set_name();
            /* $sql = "call sp_Ticket_get_ticket_total()"; */
            $sql = "SELECT COUNT(*) AS TOTAL FROM tm_ticket;";
            $sql = $conectar -> prepare($sql);
            $sql -> execute();
            return $resultado = $sql -> fetchAll();
        }

        public function get_ticket_totalabierto(){
            $conectar = parent::conexion();
            parent::set_name();
            /* $sql = "call sp_Ticket_get_ticket_totalabierto()"; */
            $sql = "SELECT COUNT(*) AS TOTAL FROM tm_ticket WHERE ticket_estado='Abierto';";
            $sql = $conectar -> prepare($sql);
            $sql -> execute();
            return $resultado = $sql -> fetchAll();
        }

        public function get_ticket_totalcerrado(){
            $conectar = parent::conexion();
            parent::set_name();
            /* $sql = " call sp_Ticket_get_ticket_totalcerrado()"; */
            $sql = "SELECT COUNT(*) AS TOTAL FROM tm_ticket WHERE ticket_estado='Cerrado';";
            $sql = $conectar -> prepare($sql);
            $sql -> execute();
            return $resultado = $sql -> fetchAll();
        }

        public function get_ticket_grafico(){
            $conectar= parent::conexion();
            parent::set_name();
            /* $sql="call sp_Ticket_get_ticket_grafico()"; */
            $sql="SELECT tm_categoria.cat_nom as nom,COUNT(*) AS total
                        FROM   tm_ticket  JOIN  
                            tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id  
                        WHERE    
                        tm_ticket.estado = 1
                        GROUP BY 
                        tm_categoria.cat_nom 
                        ORDER BY total DESC;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        } 

        public function reabrir_ticket($ticket_id){
            $conectar = parent::conexion();
            parent::set_name();
            $sql = "UPDATE tm_ticket
                    SET
                        ticket_estado = 'Abierto'
                    WHERE
                        ticket_id = ? ";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $ticket_id);
            $sql -> execute();
            return $resultado = $sql -> fetchAll();

        }
        
        public function insert_ticketdetalle_reabrir($ticket_id,$usu_id){
            $conectar = parent::conexion();
            parent::set_name();
            $sql = "INSERT INTO td_ticketdetalle (ticketd_id, ticket_id, usu_id, ticketd_descripcion, fecha_crear, estado) VALUES (NULL,?,?,'Ticket Reabierto...',now(), '1');";
            $sql = $conectar -> prepare($sql);
            $sql -> bindValue(1, $ticket_id);
            $sql -> bindValue(2, $usu_id);
            $sql -> execute();
            return $resultado = $sql -> fetchAll();

        }
    }
?>