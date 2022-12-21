$(document).ready(function() {
    var rut, opcion;
    opcion = 4;
        
    tablaClientes = $('#tablaClientes').DataTable({  
        order: [1, 'asc'],
        language:{
            url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
        },
        "pagingType": "full_numbers",
        "lengthMenu": [[10, 25, 50], [10, 25, 50]],
        "ajax":{            
            "url": "productosCRUD/bd/clientes.php", 
            "method": 'POST', //usamos el metodo POST
            "data":{opcion:opcion}, //enviamos opcion 4 para que haga un SELECT
            "dataSrc":""
        },
        "columns":[
            {"data": "rut"},
            {"data": "razon_social"},
            {"data": "giro"},
            {"data": "email"},
            {"data": "contacto"},
            {"data": "direccion"},
            {"data": "comuna"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btn-sm btnEditar'><i class='material-icons'>edit</i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='material-icons'>delete</i></button></div></div>"}
        ]
    });    


    var fila; //captura la fila, para editar o eliminar
    //submit para el Alta y Actualización
    $('#formClientes').submit(function(e){                         
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
        rut = $.trim($('#rut').val());    
        razon_social = $.trim($('#razon_social').val());    
        direccion = $.trim($('#direccion').val());
        email = $.trim($('#email').val());    
        giro = $.trim($('#giro').val());    
        contacto = $.trim($('#contacto').val());
        comuna = $.trim($('#comuna').val());   
        console.log("opcion: "+opcion);
        var_opcion = opcion;
        opcion = 7;
        $.ajax({
            url: "productosCRUD/bd/clientes.php",
            type: "POST",
            datatype:"json",  
            data: {opcion:opcion, rut:rut},
            success: function(data){
                var info = JSON.parse(data);
                console.log(info);
                console.log("lenght: "+info.length);
               // if(typeof info[0]['rut'] !== 'undefined'){

               switch(var_opcion){
                    case 1:
                        if(info.length == 0){
                            opcion = 1;
                            $.ajax({
                                url: "productosCRUD/bd/clientes.php",
                                type: "POST",
                                datatype:"json",    
                                data:  {rut:rut, razon_social:razon_social, direccion:direccion, email:email, giro:giro, contacto:contacto ,comuna:comuna ,opcion:opcion},    
                                success: function(data) {
                                    tablaClientes.ajax.reload(null, false);
                                    $('#modalFormClientes').modal('hide');	
                                    $('#modalNotificacionBody').removeClass("alert-danger");
                                    $('#modalNotificacionBody').html("<strong>Cliente creado con exito.</strong> <br/><small>Ahora es posible asignar nuevas ventas al cliente registrado.</small>");
                                    $('#modalNotificacion').modal('show');	
                                }
                            });			        
                            
                        }
                        else{
                            console.log("info es mayor que 0 y entre al else");
                            $('#modalNotificacionBody').removeClass("alert-danger");
                            $('#modalNotificacionBody').toggleClass("alert-danger");
                            $('#modalNotificacionBody').html("<strong>Cliente ya existente con el rut ingresado.</strong> <br/> <small>Recuerde que para buscar un cliente debe de escribir con punto y guion el rut.</small>");
                            $('#modalFormClientes').modal('hide');	
                            $('#modalNotificacion').modal('show');	
                        }
                        break;
                    case 2:
                        opcion = 2;
                            $.ajax({
                                url: "productosCRUD/bd/clientes.php",
                                type: "POST",
                                datatype:"json",    
                                data:  {rut:rut, razon_social:razon_social, direccion:direccion, email:email, giro:giro, contacto:contacto ,comuna:comuna ,opcion:opcion},    
                                success: function(data) {
                                    tablaClientes.ajax.reload(null, false);
                                    $('#modalFormClientes').modal('hide');	
                                    $('#modalNotificacionBody').removeClass("alert-danger");
                                    $('#modalNotificacionBody').html("<strong>Datos actualizados correctamente!</strong> <br/> <small>Los datos del cliente han sido actualizados correctamente, ahora podra visualizar aquellos cambios.</small>");

                                    $('#modalNotificacion').modal('show');	
                                }
                            });			
                        break;
               }           
            }
        });									     			
    });
            
     
    
    //para limpiar los campos antes de dar de Alta una Persona
    $("#btnNuevo").click(function(){
        opcion = 1; //alta           
        rut=null;
        $("#formClientes").trigger("reset");
        $("#rut").prop( "disabled", false );
        $(".modal-header").css( "background-color", "#17a2b8");
        $(".modal-header").css( "color", "white" );
        $(".modal-title").text("Nuevo Cliente");
        $('#modalFormClientes').modal('show');	    
    });
    
    //Editar        
    $(document).on("click", ".btnEditar", function(){		        
        opcion = 2;//editar
        $( "#rut" ).prop( "disabled", true );
        fila = $(this).closest("tr");	        
        rut = fila.find('td:eq(0)').text(); //capturo el ID	
        razon_social = fila.find('td:eq(1)').text();
        giro = fila.find('td:eq(2)').text();
        email = fila.find('td:eq(3)').text();
        contacto = fila.find('td:eq(4)').text();
        direccion = fila.find('td:eq(5)').text();
        comuna = fila.find('td:eq(6)').text();
        $("#rut").val(rut);
        $("#razon_social").val(razon_social);
        $("#direccion").val(direccion);
        $("#email").val(email);
        $("#giro").val(giro);
        $("#contacto").val(contacto);
        $("#comuna").val(comuna);
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white" );
        $(".modal-title").text(razon_social);		
        $('#modalFormClientes').modal('show');		   
    });
    
    //Borrar
    $(document).on("click", ".btnBorrar", function(){
        fila = $(this);           
        rut = $(this).closest('tr').find('td:eq(0)').text();		
        razon_social = $(this).closest('tr').find('td:eq(1)').text();		
        opcion = 3; //eliminar        
        var respuesta = confirm("¿Está seguro de borrar el cliente "+razon_social+" - Rut: "+rut+" ?");                
        if (respuesta) {            
            $.ajax({
              url: "productosCRUD/bd/clientes.php",
              type: "POST",
              datatype:"json",    
              data:  {opcion:opcion, rut:rut},    
              success: function() {
                  tablaClientes.row(fila.parents('tr')).remove().draw();                  
               }
            });	
        }
     });
         
});    
    
    