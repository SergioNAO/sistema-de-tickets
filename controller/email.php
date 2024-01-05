<?php
    require_once("../config/conexion.php");
    require_once("../models/Email.php");
    $email = new Email();

    switch($_GET["op"]){

        case "ticket_abierto":
            $email -> ticket_abierto($_POST["ticket_id"]);
        break;

        case "ticket_cerrado":
            $email -> ticket_cerrado($_POST["ticket_id"]);
        break;

        case "ticket_asignado":
            $email -> ticket_asignado($_POST["ticket_id"]);
        break;
    }

?>