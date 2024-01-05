function init() {
}

$(document).ready(function(){
    var ticket_id = getUrlParameter('ID');
    
    listardetalle(ticket_id);

    $('#ticketd_descripcion').summernote({
        height: 250,
        lang: "es-ES",
        popover:{
            Image: [],
            link: [],
            air: []
        },

        callbacks: {
            onImagenUpload: function(image) {
                console.log("Image detect...");
                myimagetreat(image[0]);
            },
            onPaste: function (e) {
                console.log("Text detect...");
            }
        },

        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['link', 'picture']]

          ]

    });

    $('#ticketd_descripcionusu').summernote({
        height: 250,
        lang: "es-ES",
        popover:{
            Image: [],
            link: [],
            air: []
        },

        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['link', 'picture']]

          ]

    });

    $('#ticketd_descripcionusu').summernote ('disable');

    tabla=$('#documentos_data').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        "searching": true,
        lengthChange: false,
        colReorder: true,
        buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
                ],
        "ajax":{
            url: '../../controller/documento.php?op=listar',
            type : "post",
            data : {ticket_id:ticket_id},
            dataType : "json",
            error: function(e){
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 10,
        "autoWidth": false,
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    }).DataTable();

});
 
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

$(document).on("click","#btnenviar",function(){
    var ticket_id = getUrlParameter('ID');
    var usu_id =  $('#user_idx').val();
    var ticketd_descripcion = $('#ticketd_descripcion').val();

    if ($('#ticketd_descripcion').summernote('isEmpty')) {
        swal("Advertencia!", "Falta Descripcion", "warning");
    }else{
        $.post("../../controller/ticket.php?op=insertdetalle", { ticket_id:ticket_id,usu_id:usu_id,ticketd_descripcion:ticketd_descripcion}, function(data){
            listardetalle(ticket_id);
            $('#ticketd_descripcion').summernote('reset');
            swal("Correcto!", "Registrado Correctamente", "success");
        });
    }

});

$(document).on("click","#btncerrarticket",function(){
    swal({
        title: "Alerta!",
        text: "¿Esta seguro de Cerrar el Ticket?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        closeOnConfirm: false,
    },
    function(isConfirm) {
        if (isConfirm) {
            var ticket_id = getUrlParameter('ID');
            var usu_id =  $('#user_idx').val();
            $.post("../../controller/ticket.php?op=update", { ticket_id : ticket_id, usu_id : usu_id}, function(data){

            });

            $.post("../../controller/email.php?op=ticket_cerrado", {ticket_id:ticket_id}, function(data){

            });
    
            listardetalle(ticket_id);

            swal({
                title: "Correcto!",
                text: "Su Ticket fue Cerrado Correctamente",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        } 
    });
});

function listardetalle(ticket_id) {
    $.post("../../controller/ticket.php?op=listardetalle", { ticket_id : ticket_id}, function(data){
        $('#lbldetalle').html(data);
    });
    /* Muestra los comentarios que se han enviado en el Ticket */
    $.post("../../controller/ticket.php?op=mostrar", { ticket_id : ticket_id}, function(data){
        data = JSON.parse(data);
        $('#lblestado').html(data.ticket_estado);
        $('#lblnomusuario').html(data.usu_nom +' '+data.usu_ape);
        $('#lblfechacrear').html(data.fecha_crear);

        $('#lblnomidticket').html("Detalle Ticket - "+data.ticket_id);

        $('#cat_nom').val(data.cat_nom);
        $('#ticket_titulo').val(data.ticket_titulo);

        $('#ticketd_descripcionusu').summernote ('code', data.ticket_descripcion);
        
        if (data.ticket_estado_texto=="Cerrado") {
            $('#pnldetalle').hide();
        } 
        
    });

}

init();