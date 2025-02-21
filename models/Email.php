<?php
    require_once("class.phpmailer.php");
    include("C:/xampp/htdocs/PERSONAL_HelpDesk/models/class.smtp.php");
    
    require_once("../config/conexion.php");
    require_once("../models/Ticket.php");
    
    class Email extends PHPMailer{
        protected $gCorreo = '';
        protected $gContrasena = '';

        public function ticket_abierto($ticket_id){
            $ticket = new Ticket();
            $datos = $ticket -> listar_ticket_x_id($ticket_id);
            foreach ($datos as $row) {
                $id = $row["ticket_id"];
                $usu = $row["usu_nom"];
                $titulo = $row["ticket_titulo"];
                $categoria = $row["cat_nom"];
                $correo = $row["usu_correo"];
            }

            $this->IsSMTP();
            /* $this->Host = 'smtp.office365.com'; *///Aqui el server
            $this->Host = 'mail.diinsel.com';
            $this->Port = 587;//Aqui el puerto
            $this->SMTPAuth = true;
            $this->Username = $this->gCorreo;
            $this->Password = $this->gContrasena;
            $this->From = $this->gCorreo;
            $this->SMTPSecure = 'tls';
            $this->FromName = $this->tu_nombre = "Ticket Abierto ".$id;
            $this->CharSet = 'UTF8';
            $this->addAddress($correo);
            $this->WordWrap = 50;
            $this->IsHTML(true);
            $this->Subject = "Ticket Abierto";
            //Igual//
            $cuerpo = file_get_contents('../public/NuevoTicket.html'); /* Ruta del template en formato HTML */
            /* parametros del template a remplazar */
            $cuerpo = str_replace("xnroticket", $id, $cuerpo);
            $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
            $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
            $cuerpo = str_replace("lblCate", $categoria, $cuerpo);

            $this->Body = $cuerpo;
            $this->AltBody = strip_tags("Ticket Abierto");
            return $this->Send();
        }

        public function ticket_cerrado($ticket_id){
            $ticket = new Ticket();
            $datos = $ticket -> listar_ticket_x_id($ticket_id);
            foreach ($datos as $row) {
                $id = $row["ticket_id"];
                $usu = $row["usu_nom"];
                $titulo = $row["ticket_titulo"];
                $categoria = $row["cat_nom"];
                $correo = $row["usu_correo"];
            }

            $this->IsSMTP();
            /* $this->Host = 'smtp.office365.com'; *///Aqui el server
            $this->Host = 'mail.diinsel.com';
            $this->Port = 587;//Aqui el puerto
            $this->SMTPAuth = true;
            $this->Username = $this->gCorreo;
            $this->Password = $this->gContrasena;
            $this->From = $this->gCorreo;
            $this->SMTPSecure = 'tls';
            $this->FromName = $this->tu_nombre = "Ticket Cerrado ".$id;
            $this->CharSet = 'UTF8';
            $this->addAddress($correo);
            $this->WordWrap = 50;
            $this->IsHTML(true);
            $this->Subject = "Ticket Cerrado";
            //Igual//
            $cuerpo = file_get_contents('../public/CerradoTicket.html'); /* Ruta del template en formato HTML */
            /* parametros del template a remplazar */
            $cuerpo = str_replace("xnroticket", $id, $cuerpo);
            $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
            $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
            $cuerpo = str_replace("lblCate", $categoria, $cuerpo);

            $this->Body = $cuerpo;
            $this->AltBody = strip_tags("Ticket Cerrado");
            return $this->Send();
        }

        public function ticket_asignado($ticket_id){
            $ticket = new Ticket();
            $datos = $ticket -> listar_ticket_x_id($ticket_id);
            foreach ($datos as $row) {
                $id = $row["ticket_id"];
                $usu = $row["usu_nom"];
                $titulo = $row["ticket_titulo"];
                $categoria = $row["cat_nom"];
                $correo = $row["usu_correo"];
            }

            $this->IsSMTP();
            /* $this->Host = 'smtp.office365.com';*///Aqui el server
            $this->Host = 'mail.diinsel.com';
            $this->Port = 587;//Aqui el puerto
            $this->SMTPAuth = true;
            $this->Username = $this->gCorreo;
            $this->Password = $this->gContrasena;
            $this->From = $this->gCorreo;
            $this->SMTPSecure = 'tls';
            $this->FromName = $this->tu_nombre = "Ticket Asignado ".$id;
            $this->CharSet = 'UTF8';
            $this->addAddress($correo);
            $this->WordWrap = 50;
            $this->IsHTML(true);
            $this->Subject = "Ticket Asignado";
            //Igual//
            $cuerpo = file_get_contents('../public/AsignarTicket.html'); /* Ruta del template en formato HTML */
            /* parametros del template a remplazar */
            $cuerpo = str_replace("xnroticket", $id, $cuerpo);
            $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
            $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
            $cuerpo = str_replace("lblCate", $categoria, $cuerpo);

            $this->Body = $cuerpo;
            $this->AltBody = strip_tags("Ticket Asignado");
            return $this->Send();
        }

    }
?>
