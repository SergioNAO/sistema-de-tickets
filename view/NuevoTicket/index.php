<?php
require_once("../../config/conexion.php");
	if (isset($_SESSION["usu_id"])) {
?>
<!DOCTYPE html>
<html>
    <?php require_once("../MainHead/head.php"); ?>
    <title>Diinsel - Nuevo Ticket</title>
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
							<h3>Consultar Ticket</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">Home</a></li>
								<li class="active">Consultar Ticket</li>
							</ol>
						</div>
					</div>
				</div>
			</header>
		
			<div class="box-typical box-typical-padding">
				<p>
					Generacion de Tickets.
				</p>
						

				<h5 class="m-t-lg with-border">Ingresar Información</h5>

				<div class="row">
					<form method="post" id="ticket_form">

						<input type="hidden" id="usu_id" name="usu_id" value="<?php echo $_SESSION["usu_id"]?>">

						<div class="col-lg-12">
							<fieldset class="form-group">
								<label class="form-label semibold" for="ticket_titulo">Titulo</label>
								<input type="text" class="form-control" id="ticket_titulo" name="ticket_titulo" placeholder="Ingrese Titulo">
							</fieldset>
						</div>
						
						<div class="col-lg-6">
							<fieldset class="form-group">
								<label class="form-label semibold" for="exampleInput">Categoria</label>
								<select id="cat_id" name="cat_id" class="form-control">

								</select>
							</fieldset>
						</div>
						
						<div class="col-lg-6">
							<fieldset class="form-group">
								<label class="form-label semibold" for="fileElem">Documentos Adicionales</label>
								<input type="file" name="fileElem" id="fileElem" class="form-control" multiple>
							</fieldset>
						</div>

						<div class="col-lg-12">
							<fieldset class="form-group">
								<label class="form-label semibold" for="ticket_descripcion">Descripción</label>
								<div class="summernote-theme-3">
									<textarea id="ticket_descripcion" name="ticket_descripcion" class="summernote" name="name"></textarea>
								</div>
							</fieldset>
						</div>
						<div class="col-lg-12">
							<button type="submit" name="action" value="add" class="btn btn-rounded btn-inline btn-primary">Guardar</button>
						</div>
					</form>
				</div>	

			</div>

		</div>
	</div>

    <?php require_once("../MainJs/js.php"); ?>
	
    <script type="text/javascript" src="nuevoticket.js"></script>

</body>
</html>
<?php	
	}else {
		header("Location:".Conectar::ruta()."index.php");
	}
?>