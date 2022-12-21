$(document).ready(function() {
var codigo, opcion;
opcion = 4;
setDisabledButton();
    
tablaProductos = $('#tablaProductos').DataTable({  
    order: [1, 'asc'],
    language:{
        url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
    },
    "pagingType": "full_numbers",
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
    "ajax":{            
        "url": "productosCRUD/bd/crud.php", 
        "method": 'POST', //usamos el metodo POST
        "data":{opcion:opcion}, //enviamos opcion 4 para que haga un SELECT
        "dataSrc":""
    },
    "columnDefs": [ {
        "targets": [2,3,4,5,6,7],
        "searchable": false }
    ],
    "columns":[
        {"data": "codigo"},
        {"data": "nombre"},
        {"data": "descripcion"},
        {"data": "precio_venta"},
        { "data": "precio_mayor" },
        {"data": "stock"},
        {"data": "stock_min"},
        { "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-success btn-sm btnVerPrecioIVA'><i class='material-icons'>paid</i></button><button class='btn btn-primary btn-sm btnEditar'><i class='material-icons'>edit</i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='material-icons'>delete</i></button></div></div>"}
    ],
    "initComplete": function(settings, json) {
        setDisabledButton();
    },
    "drawCallback": function( settings ) {
        setDisabledButton();
    }
});     

function setDisabledButton(){
    if($('#user_username').attr("usertype")==0){
        $('.btnEditar').prop("disabled", true);
        $('.btnBorrar').prop("disabled", true);
        $('#btnNuevo').prop("disabled", true);
    }
}



var fila; //captura la fila, para editar o eliminar
//submit para el Alta y Actualización
$('#formUsuarios').submit(function(e){                         
    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
    codigo = $.trim($('#codigo').val());    
    nombre = $.trim($('#nombre').val());    
    precio_venta = $.trim($('#precio_venta').val());
    precio_mayor = $.trim($('#precio_mayor').val());    
    descripcion = $.trim($('#descripcion').val());    
    stock = $.trim($('#stock').val());
    stock_min = $.trim($('#stock_min').val());   
        $.ajax({
          url: "productosCRUD/bd/crud.php",
          type: "POST",
          datatype:"json",    
          data:  {codigo:codigo, nombre:nombre, precio_venta:precio_venta, precio_mayor:precio_mayor, descripcion:descripcion, stock:stock ,stock_min:stock_min ,opcion:opcion},    
          success: function(data) {
            tablaProductos.ajax.reload(null, false);
            if(opcion == 1){
                $('#pushNotificationToast').toast('dispose');
                $('#pushNotificationToastBody').html(`Producto con codigo: ${codigo} <br/> Nombre: ${nombre} <br/> <strong>Ha sido creado exitosamente en el sistema.</strong>`);
                $('#pushNotificationToast').toast('show');   
            }else if(opcion == 2){
                $('#pushNotificationToast').toast('dispose');
                $('#pushNotificationToastBody').html(`Producto con codigo: ${codigo} <br/> Nombre: ${nombre} <br/> <strong>Ha sido editado exitosamente.</strong>`);
                $('#pushNotificationToast').toast('show');   
            }
           }
        });			        
    $('#modalFormProductos').modal('hide');											     			
});
        
$('#modalFormProductos').on('hidden.bs.modal', function (e) {
    $('#nombre').prop( "disabled", false );
    $('#precio_venta').prop( "disabled", false );
    $('#precio_mayor').prop( "disabled", false );
    $('#descripcion').prop( "disabled", false );
    $('#stock').prop( "disabled", false );
    $('#stock_min').prop( "disabled", false );
    $('#btnGuardar').prop("disabled", false);
    $('.btnstockminmenos').prop("disabled", false);
    $('.btnstockminmas').prop("disabled", false);
    $('.btnstockmenos').prop("disabled", false);
    $('.btnstockmas').prop("disabled", false);
})

$("#btnNuevo").click(function(){
    opcion = 1; //alta           
    codigo=null;
    $("#formUsuarios").trigger("reset");
    $("#stock").val(0);
    $("#stock_min").val(0);
    $("#codigo").prop( "disabled", false );
    $('#btnGuardar').prop("disabled", true);
    $('#nombre').prop( "disabled", true );
    $('#precio_venta').prop( "disabled", true );
    $('#precio_mayor').prop( "disabled", true );
    $('#descripcion').prop( "disabled", true );
    $('#stock').prop( "disabled", true );
    $('#stock_min').prop( "disabled", true );
    $('.btnstockminmenos').prop("disabled", true);
    $('.btnstockminmas').prop("disabled", true);
    $('.btnstockmenos').prop("disabled", true);
    $('.btnstockmas').prop("disabled", true);
    $(".modal-header").css( "background-color", "#17a2b8");
    $(".modal-header").css( "color", "white" );
    $(".modal-title").text("Agregar Producto");
    $('#modalFormProductos').modal('show');	    
});

$('#codigo').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){
        codigo = $.trim($('#codigo').val());
        opcion = 6;
		$.ajax({
            url: "productosCRUD/bd/crud.php",
            type: "POST",
            datatype:"json",    
            data:  {codigo:codigo, opcion:opcion},    
            success: function(a) {
                var data = JSON.parse(a);
                console.log(data);
                if(data[0]['existe'] == 1){
                    $('#pushNotificationToast').toast('dispose');
                    $('#pushNotificationToastBody').html(`Codigo [${codigo}] ya se encuentra utilizado, por favor ingresar uno nuevo.`);
                    $('#pushNotificationToast').toast('show');   
                }else{
                    $('#nombre').prop( "disabled", false );
                    $('#precio_venta').prop( "disabled", false );
                    $('#precio_mayor').prop( "disabled", false );
                    $('#descripcion').prop( "disabled", false );
                    $('#stock').prop( "disabled", false );
                    $('#stock_min').prop( "disabled", false );
                    $('#btnGuardar').prop("disabled", false);
                    $('.btnstockminmenos').prop("disabled", false);
                    $('.btnstockminmas').prop("disabled", false);
                    $('.btnstockmenos').prop("disabled", false);
                    $('.btnstockmas').prop("disabled", false);
                }
            }
        });	
        opcion = 1;
	}
	event.stopPropagation();
})

//Editar        
$(document).on("click", ".btnEditar", function(){		        
    opcion = 2;//editar
    $('#btnGuardar').prop("disabled", false);
    $( "#codigo" ).prop( "disabled", true );
    fila = $(this).closest("tr");	        
    codigo = fila.find('td:eq(0)').text(); //capturo el ID	
    nombre = fila.find('td:eq(1)').text();
    descripcion = fila.find('td:eq(2)').text();
    precio_venta = fila.find('td:eq(3)').text();
    precio_mayor = fila.find('td:eq(4)').text();
    stock = fila.find('td:eq(5)').text();
    stock_min = fila.find('td:eq(6)').text();
    $("#codigo").val(codigo);
    $("#nombre").val(nombre);
    $("#precio_venta").val(precio_venta);
    $("#precio_mayor").val(precio_mayor);
    $("#descripcion").val(descripcion);
    $("#stock").val(stock);
    $("#stock_min").val(stock_min);
    $(".modal-header").css("background-color", "#007bff");
    $(".modal-header").css("color", "white" );
    $(".modal-title").text("Editar: " + nombre);		
    $('#modalFormProductos').modal('show');		   
});

 $(document).on("click", ".btnVerPrecioIVA", function () {
    fila = $(this).closest("tr");
    nombre = fila.find('td:eq(1)').text();
    precio_mayor = fila.find('td:eq(4)').text();
    precioIVA = precio_mayor * 1.19;
    //$('#pushNotificationToastBody').html(`Producto: "${nombre}" <br /> Precio Comerciante IVA: $ ${precioIVA.toFixed(1)}`);
    //$('#pushNotificationToast').toast('show');
     alert(`${nombre} \nPrecio Comerciante IVA: $ ${(precioIVA.toFixed(1)).slice(0, -2)}`)
});


//Borrar
$(document).on("click", ".btnBorrar", function(){
    fila = $(this);           
    codigo = $(this).closest('tr').find('td:eq(0)').text();		
    nombre = $(this).closest('tr').find('td:eq(1)').text();		
    opcion = 3; //eliminar        
    var respuesta = confirm("¿Está seguro de borrar el producto "+nombre+"?");                
    if (respuesta) {            
        $.ajax({
          url: "productosCRUD/bd/crud.php",
          type: "POST",
          datatype:"json",    
          data:  {opcion:opcion, codigo:codigo},    
          success: function(data){
            if(data.length > 3){
                $('#pushNotificationToast').toast('dispose');
                $('#pushNotificationToastBody').html(`Ocurrio un problema al borrar producto del sistema. <br/> Error: ${data}`);
                $('#pushNotificationToast').toast('show');
            }else{
                tablaProductos.row(fila.parents('tr')).remove().draw();            
                $('#pushNotificationToast').toast('dispose');
                $('#pushNotificationToastBody').html(`Producto con codigo: ${codigo} <br/> Nombre: ${nombre} <br/> Ha sido exitosamente borrado del sistema.`);
                $('#pushNotificationToast').toast('show');   
            }
          },
          error: function(){
            $('#pushNotificationToast').toast('dispose');
            $('#pushNotificationToastBody').html(`Ocurrio un problema al borrar producto del sistema. <br/> Error: <i>No se puede borrar un producto que ya fue asociado en una venta.</i>`);
            $('#pushNotificationToast').toast('show');
          }
        })
    }
 });

 $(document).on("click", ".btnstockmas", function(){
    var valor = parseInt($(this).val());
    var result = parseInt($("#stock").val()) + valor;
    $("#stock").val(result);
});	

$(document).on("click", ".btnstockmenos", function(){
    var valor = parseInt($(this).val());
    var result = parseInt($("#stock").val()) - valor;
    if(result < 0){
        $("#stock").val(0);
    }else{
        $("#stock").val(result);
    }
});	

$(document).on("click", ".btnstockminmas", function(){
    var valor = parseInt($(this).val());
    var result = parseInt($("#stock_min").val()) + valor;
    $("#stock_min").val(result);
});	

$(document).on("click", ".btnstockminmenos", function(){
    var valor = parseInt($(this).val());
    var result = parseInt($("#stock_min").val()) - valor;
    if(result < 0){
        $("#stock_min").val(0);
    }else{
        $("#stock_min").val(result);
    }
});	



     
});

function toCLP(number) {
    var number2 = number.toString().replace(".", ",");
    return number2.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

