function init() {
}

$(document).ready(function(){
    var usu_id =  $('#user_idx').val();

    if ($('#rol_idx').val()==1) {
        $.post("../../controller/usuario.php?op=total", {usu_id:usu_id}, function(data){
            data = JSON.parse(data);
            $('#lbltotal').html(data.TOTAL);
        });
    
        $.post("../../controller/usuario.php?op=totalabierto", {usu_id:usu_id}, function(data){
            data = JSON.parse(data);
            $('#lbltotalabiertos').html(data.TOTAL);
        });
    
        $.post("../../controller/usuario.php?op=totalcerrado", {usu_id:usu_id}, function(data){
            data = JSON.parse(data);
            $('#lbltotalcerrados').html(data.TOTAL);
        });

        $.post("../../controller/usuario.php?op=graficousuario", {usu_id:usu_id}, function(data){
            data = JSON.parse(data);
    
            new Morris.Bar({
                element: 'divgrafico',
                data: data,
                xkey: 'nom',
                ykeys: ['total'],
                labels: ['Cantidad'],
                barColors: ["#06215C"]
            });
        });

    }else{
        $.post("../../controller/ticket.php?op=totalticket",function(data){
            data = JSON.parse(data);
            $('#lbltotal').html(data.TOTAL);
        });
    
        $.post("../../controller/ticket.php?op=totalticketabierto",function(data){
            data = JSON.parse(data);
            $('#lbltotalabiertos').html(data.TOTAL);
        });
    
        $.post("../../controller/ticket.php?op=totalticketcerrado",function(data){
            data = JSON.parse(data);
            $('#lbltotalcerrados').html(data.TOTAL);
        });

        $.post("../../controller/ticket.php?op=grafico",function(data){
            data = JSON.parse(data);
    
            new Morris.Bar({
                element: 'divgrafico',
                data: data,
                xkey: 'nom',
                ykeys: ['total'],
                labels: ['Cantidad'],
                barColors: ["#06215C"]
            });
        });

    }
 

});


init();