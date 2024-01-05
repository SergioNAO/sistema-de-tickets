<?php
	require_once("../../config/conexion.php");
	if (isset($_SESSION["usu_id"])) {
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php"); ?>
    <title>Diinsel - Detalle Ticket</title>
</head>
<body class="with-side-menu">

    <?php require_once("../MainHeader/header.php"); ?>

	<div class="mobile-menu-left-overlay"></div>

    <?php require_once("../MainNav/nav.php"); ?>

	<div class="page-content">
		<div class="container-fluid">
            
			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3 id="lblnomidticket"></h3>
							<div id="lblestado"></div>
							<span class="label label-pill label-primary" id="lblnomusuario">Nombre del Usuario</span>
							<span class="label label-pill label-default" id="lblfechacrear"></span>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Home</a></li>
								<li class="active">Detalle Ticket</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<div class="box-typical box-typical-padding">
				<div class="row">

					<div class="col-lg-6">
						<fieldset class="form-group">
							<label class="form-label semibold" for="cat_nom">Categoria</label>
							<input type="text" id="cat_nom" name="cat_nom" class="form-control" readonly>
						</fieldset>
					</div>

					<div class="col-lg-6">
						<fieldset class="form-group">
							<label class="form-label semibold" for="ticket_titulo">Titulo</label>
							<input type="text" class="form-control" id="ticket_titulo" name="ticket_titulo" readonly>
						</fieldset>
					</div>

					<div class="col-lg-12">
						<fieldset class="form-group">
							<label class="form-label semibold" for="tick_titulo">Documentos Adicionales</label>
							<table id="documentos_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
								<thead>
									<tr>
										<th style="width: 90%;">Nombre</th>
										<th class="text-center" style="width: 10%;"></th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</fieldset>
					</div>

					<div class="col-lg-12">
						<fieldset class="form-group">
							<label class="form-label semibold" for="ticketd_descripcionusu">Descripción</label>
							<div class="summernote-theme-3">
								<textarea id="ticketd_descripcionusu" name="ticketd_descripcionusu" class="summernote" name="name"></textarea>
							</div>
						</fieldset>
					</div>
				
				</div>	
			</div>		
			
			<section class="activity-line" id="lbldetalle">

            </section>
			
			<div id="pnldetalle" class="box-typical box-typical-padding">

				<p>Comentarios</p>

				<div class="row">
					<div class="col-lg-12">
						<fieldset class="form-group">
							<label class="form-label semibold" for="ticketd_descripcion">Descripción</label>
							<div class="summernote-theme-3">
								<textarea id="ticketd_descripcion" name="ticketd_descripcion" class="summernote" name="name"></textarea>
							</div>
						</fieldset>
					</div>
					<div class="col-lg-12">
						<button type="button" id="btnenviar" class="btn btn-rounded btn-inline btn-primary">Enviar</button>
						<button type="button" id="btncerrarticket" class="btn btn-rounded btn-inline btn-danger">Cerrar Ticket</button>
					</div>
				</div>	

			</div>


		</div>
	</div>
    
    <?php require_once("../MainJs/js.php"); ?>
	
    <script type="text/javascript" src="detalleticket.js"></script>

</body>
</html>
<?php	
	}else {
		header("Location:".Conectar::ruta()."index.php");
	}
?>