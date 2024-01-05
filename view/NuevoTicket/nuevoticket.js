function init(){
    $("#ticket_form").on("submit",function(e){
        guardaryeditar(e);
    });
}

$(document).ready(function() {
    $('#ticket_descripcion').summernote({
        height: 200,
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
                /* e.preventDefault(); */
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

    $.post("../../controller/categoria.php?op=combo",function(data,status){
        $('#cat_id').html(data);
    });

});

function guardaryeditar(e) {
    e.preventDefault();
    var formData = new FormData($("#ticket_form")[0]);
    if ($('#ticket_descripcion').summernote('isEmpty') || $('#ticket_titulo').val()=='') {
        swal("Advertencia!", "Llene todos los campos Correctamente", "warning");
    } 
    else {
        var totalfiles = $('#fileElem').val().length;
        for (var i = 0; i < totalfiles; i++) {
            formData.append("files[]", $('#fileElem')[0].files[i]); 
        }
            
        $.ajax({
            url: "../../controller/ticket.php?op=insert",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data){
                data = JSON.parse(data);
                console.log(data[0].ticket_id);
                
                $.post("../../controller/email.php?op=ticket_abierto", {ticket_id : data[0].ticket_id}, function(data){

                });
                
                $('#ticket_titulo').val('');
                $('#ticket_descripcion').summernote('reset');
                swal("Correcto!", "Registrado Correctamente", "success");
            }
        });
    }
}
init();