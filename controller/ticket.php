<?php
    require_once("../config/conexion.php");
    require_once("../models/Ticket.php");
    $ticket = new Ticket;
    
    require_once("../models/Usuario.php");
    $usuario = new Usuario;

    require_once("../models/Documento.php");
    $documento = new Documento;

    switch($_GET["op"]){
        case "insert":
            $datos=$ticket->insert_ticket($_POST["usu_id"],$_POST["cat_id"],$_POST["ticket_titulo"],$_POST["ticket_descripcion"]);
            if (is_array($datos)==true and count($datos)>0){
                foreach ($datos as $row){
                    $output["ticket_id"] = $row["ticket_id"];

                    if (empty($_FILES['files']['name'])) {
                        
                    } else {
                        $countfiles = count($_FILES['files']['name']);
                        $ruta = "../public/document/".$output["ticket_id"]."/";
                        $files_arr = array();

                        if (!file_exists($ruta)) {
                            mkdir($ruta, 0777, true);
                        }

                        for ($index=0; $index < $countfiles; $index++) { 
                            $doc1 = $_FILES['files']['tmp_name'][$index];
                            $destino = $ruta.$_FILES['files']['name'][$index];

                            $documento->insert_documento($output["ticket_id"],$_FILES['files']['name'][$index]);

                            move_uploaded_file($doc1,$destino);
                        }
                    }
                }
            }    
            echo json_encode($datos); 
        break;

        case "update":
            $ticket->update_ticket($_POST["ticket_id"]);
            $ticket->insert_ticketdetalle_cerrar($_POST["ticket_id"],$_POST["usu_id"]);
        break;

        case "reabrir":
            $ticket->reabrir_ticket($_POST["ticket_id"]);
            $ticket->insert_ticketdetalle_reabrir($_POST["ticket_id"],$_POST["usu_id"]);
        break;

        case "asignar":
            $ticket->update_ticket_asignacion($_POST["ticket_id"],$_POST["usuario_asignado"]);
        break;

        case "listar_x_usu":
            $datos = $ticket->listar_ticket_x_usu($_POST["usu_id"]);
            $data = Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["ticket_id"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["ticket_titulo"];
                
                if ($row["ticket_estado"]=="Abierto") {
                    $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                } else {
                    $sub_array[] = '<a onClick="CambiarEstado('.$row["ticket_id"].');"><span class="label label-pill label-danger">Cerrado</span></a>';
                }
                
                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fecha_crear"]));

                if ($row["fecha_asignacion"]==null){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                }else {
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fecha_asignacion"]));
                }

                if ($row["usuario_asignado"]==null){
                    $sub_array[] = '<span class="label label-pill label-warning">Sin Asignar</span>';
                }else {
                    $datos1 = $usuario->get_usuario_x_id($row["usuario_asignado"]);
                    foreach($datos1 as $row1){
                        $sub_array[] = '<span class="label label-pill label-success">'. $row1["usu_nom"] .'</span>';
                    }
                }

                $sub_array[] = '<button type="button" onClick="ver('.$row["ticket_id"].');"  id="'.$row["ticket_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }
            
            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

        case "listar":
            $datos = $ticket->listar_ticket();
            $data = Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["ticket_id"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["ticket_titulo"];

                if ($row["ticket_estado"]=="Abierto") {
                    $sub_array[] = '<span class="label label-pill label-success">Abierto</span>';
                } else {
                    $sub_array[] = '<a onClick="CambiarEstado('.$row["ticket_id"].');"><span class="label label-pill label-danger">Cerrado</span></a>';
                }

                $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fecha_crear"]));

                if ($row["fecha_asignacion"]==null){
                    $sub_array[] = '<span class="label label-pill label-default">Sin Asignar</span>';
                }else {
                    $sub_array[] = date("d/m/Y H:i:s", strtotime($row["fecha_asignacion"]));
                }

                if ($row["usuario_asignado"]==null){
                    $sub_array[] = '<a onClick="asignar('.$row["ticket_id"].');"><span class="label label-pill label-warning">Sin Asignar</span></a>';
                }else {
                    $datos1 = $usuario->get_usuario_x_id($row["usuario_asignado"]);
                    foreach($datos1 as $row1){
                        $sub_array[] = '<span class="label label-pill label-success">'. $row1["usu_nom"] .'</span>';
                    }
                }

                $sub_array[] = '<button type="button" onClick="ver('.$row["ticket_id"].');"  id="'.$row["ticket_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
                $data[] = $sub_array;
            }
            
            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

        case "listardetalle":
            $datos=$ticket->listar_ticketdetalle_x_ticket($_POST["ticket_id"]);
            ?>
            <?php
                foreach ($datos as $row) {
                    ?>

                        <article class="activity-line-item box-typical">

                            <div class="activity-line-date">
                                <?php echo date("d/m/Y", strtotime($row["fecha_crear"])); ?>
                            </div>

                            <header class="activity-line-item-header">
                                <div class="activity-line-item-user">
                                    <div class="activity-line-item-user-photo">
                                        <a href="#">
                                            <img src="../../public/img/<?php echo $row['rol_id'] ?>.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="activity-line-item-user-name"> <?php echo $row['usu_nom'].' '.$row['usu_ape']; ?></div>
                                    <div class="activity-line-item-user-status">
                                        <?php 
                                            if ($row['rol_id']==1) {
                                                echo 'Usuario';
                                            } else {
                                                echo 'Soporte';
                                            }
                                        
                                        ?>
                                    </div>
                                </div>
                            </header>

                            <div class="activity-line-action-list">

                                <section class="activity-line-action">
                                    <div class="time"><?php echo date("H:i:s", strtotime($row["fecha_crear"])); ?></div>
                                    <div class="cont">
                                        <div class="cont-in">
                                            <p><?php echo $row["ticketd_descripcion"]; ?></p>
                                        </div>
                                    </div>
                                </section>

                            </div>

                        </article>

                    <?php
                }


            ?>
            <?php
        break;

        case "mostrar";
            $datos=$ticket->listar_ticket_x_id($_POST["ticket_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["ticket_id"] = $row["ticket_id"];
                    $output["usu_id"] = $row["usu_id"];
                    $output["cat_id"] = $row["cat_id"];
                    $output["ticket_titulo"] = $row["ticket_titulo"];
                    $output["ticket_descripcion"] = $row["ticket_descripcion"];

                    if ($row["ticket_estado"]=="Abierto") {
                        $output["ticket_estado"] = '<span class="label label-pill label-success">Abierto</span>';
                    } else {
                        $output["ticket_estado"] = '<span class="label label-pill label-danger">Cerrado</span>';
                    }

                    $output["ticket_estado_texto"] = $row["ticket_estado"];

                    $output["fecha_crear"] = date("d/m/Y H:i:s", strtotime($row["fecha_crear"]));
                    $output["usu_nom"] = $row["usu_nom"];
                    $output["usu_ape"] = $row["usu_ape"];
                    $output["cat_nom"] = $row["cat_nom"];
                }
                echo json_encode($output);
            }   
        break;

        case "insertdetalle":
            $ticket->insert_ticketdetalle($_POST["ticket_id"],$_POST["usu_id"],$_POST["ticketd_descripcion"]);
        break;

        case "totalticket";
            $datos=$ticket->get_ticket_total();
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }   
        break;

        case "totalticketabierto";
            $datos=$ticket->get_ticket_totalabierto();
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }   
        break;

        case "totalticketcerrado";
            $datos=$ticket->get_ticket_totalcerrado();
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output);
            }   
        break;

        case "grafico";
            $datos=$ticket->get_ticket_grafico();
            echo json_encode($datos);
        break;
            
    }
?>