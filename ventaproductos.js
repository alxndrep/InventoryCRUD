
const tableEL = document.querySelector('table');
const tbodyEL = document.querySelector('tbody');

$(document).ready(function() {

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })



    opcion = 1;
    tablaProductos = $('#tablaClientes').DataTable({  
    language:{
        url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
    },
    "lengthChange": false,
    "info": false,
    "ajax":{            
        "url": "productosCRUD/bd/ventaproducto.php", 
        "method": 'POST',
        "data": {opcion:opcion},
        "dataSrc":""
    },
    "columnDefs": [
        {"className": "dt-center", "targets": "_all"},
        {
            "targets": [3,4],
            "searchable": false }
      ],
    "columns":[
        {"defaultContent": "<div class='btn-group'><button class='btn btn-primary btn-sm btnAddProducto btnAddListaProducto'></button></div>", "width": "5%"},
        {"data": "codigo", "width": "10%"},
        {"data": "nombre", "width": "55%"},
        {"data": "stock", "width": "10%"},
        { "data": "precio_mayor", "width": "15%" },
        { "defaultContent":"<div class='btn-group'><button class='btn btn-success btn-sm btnVerPrecioIVA'><i class='material-icons'>paid</i></button></div>", "width":"5%"}
    ]
    });
    
    $(document).on("click", ".btnVerPrecioIVA", function () {
        fila = $(this).closest("tr");
        nombre = fila.find('td:eq(2)').text();
        precio_mayor = fila.find('td:eq(4)').text();
        precioIVA = precio_mayor * 1.19;
        //$('#pushNotificationToastBody').html(`Producto: "${nombre}" <br /> Precio Comerciante IVA: $ ${precioIVA.toFixed(1)}`);
        //$('#pushNotificationToast').toast('show');
        alert(`${nombre} \nPrecio Comerciante IVA: $ ${(precioIVA.toFixed(1)).slice(0, -2)}`)
    });

    $('#tablaClientes tbody').on('dblclick', 'tr', function(){
        if(!$(this).hasClass('btnAddListaProducto')){
            var fila = $(this).closest('tr');
            codigo = $.trim(fila.find('td:eq(1)').text());
            nombre = fila.find('td:eq(2)').text();
            precio = fila.find('td:eq(4)').text();
            trproducto = "#" + codigo;
            if (typeof $(trproducto).attr('id') !== 'undefined') {
                $('#pushNotificationToastBody').html(`Producto "${nombre}" ya fue ingresado en la venta.`);
                $('#pushNotificationToast').toast('show');
            }else{
                $(`
                    <tr id="${codigo}">
                        <td><div class='btn-group'><button class='btn btn-primary btn-sm btnDelProducto'></button></div></td>
                        <td><input class="form-control" type="text" value="${codigo}" readonly></td>
                        <td><input class="form-control productoNombre" codigo="${codigo}" type="text" value="${nombre}"></td>
                        <td><input class="form-control productoCantidad" codigo="${codigo}" type="number" style="text-align: center;" min="0" max="10000" value="0"></td>
                        <td><input class="form-control productoPrecio" codigo="${codigo}" type="number" style="text-align: right;" value="${precio}" data-toggle="tooltip" data-placement="top" title="Precio con IVA: $${Math.ceil(precio*1.19)}"></td>
                        <td><input class="form-control productoTotal" codigo="${codigo}" type="number" style="text-align: right;" value="0" readonly></td>
                    </tr>`).insertBefore("#rowAddProduct");
                $('#pushNotificationToastBody').html(`Producto "${nombre}" agregado.`);
                $('#pushNotificationToast').toast('show');       
            }
            $('#modalListaProductos').modal('hide');
            $(`[codigo='${codigo}'].productoCantidad`).focus();

        }
    });


});


$('#nvproductos tbody').on('click', 'tr', function () {
    if($(this).hasClass('rowAddProduct')){
        $('#modalListaProductos').modal('show');
        $(".modal-title").text("Lista de Productos");
        tablaProductos.search('').draw();
    }
});

$('#modalListaProductos').on('shown.bs.modal', function (e) {
    $('#tablaClientes_filter input').focus();
});


$(document).on("click", ".btnAddProducto", function(){
    $('#modalListaProductos').modal('show');
});

function onDelProduct(e){
    if(!e.target.classList.contains('btnDelProducto')){
        return;
    }
    const btn = e.target;
    btn.closest("tr").remove();
    var numberOfRows = $("#nvproductos>tbody>tr").length;
    console.log("filas: "+numberOfRows);
    if(numberOfRows == 19){
        if(!$('#rowAddProduct').length){
            $('#nvproductos>tbody').append(`<tr id="rowAddProduct" class="rowAddProduct">
            <td><button class="btn btn-primary btn-sm btnAddProducto"></button></td>
            <td></td>
            <td><b><i>Agregar producto nuevo</i></b></td>
            <td></td>
            <td></td>
            <td></td>
            </tr>`);
        }
    }
};

$(document).on("click",".btnAddListaProducto", function(){
    fila = $(this).closest("tr");
    codigo = $.trim(fila.find('td:eq(1)').text());
    nombre = fila.find('td:eq(2)').text();
    precio = fila.find('td:eq(4)').text();
    trproducto = "#" + codigo;
    if (typeof $(trproducto).attr('id') !== 'undefined') {
        $('#pushNotificationToastBody').html(`Producto "${nombre}" ya fue ingresado en la venta.`);
        $('#pushNotificationToast').toast('show');
    }else{
        $(`
            <tr id="${codigo}">
                <td><div class='btn-group'><button class='btn btn-primary btn-sm btnDelProducto'></button></div></td>
                <td><input class="form-control" type="text" value="${codigo}" readonly></td>
                <td><input class="form-control productoNombre" codigo="${codigo}" type="text" value="${nombre}"></td>
                <td><input class="form-control productoCantidad" codigo="${codigo}" type="number" style="text-align: center;" min="0" max="10000" value="0"></td>
                <td><input class="form-control productoPrecio" codigo="${codigo}" type="number" style="text-align: right;" value="${precio}" data-toggle="tooltip" data-placement="top" title="Precio con IVA: $${Math.ceil(precio*1.19)}"></td>
                <td><input class="form-control productoTotal" codigo="${codigo}" type="number" style="text-align: right;" value="0" readonly></td>
            </tr>`).insertBefore("#rowAddProduct");
            $('#pushNotificationToastBody').html(`Producto "${nombre}" agregado.`);
            $('#pushNotificationToast').toast('show');
    }
    $('#modalListaProductos').modal('hide');
    $(`[codigo='${codigo}'].productoCantidad`).focus();

});

tableEL.addEventListener('click', onDelProduct);

function searchCliente(opcion, rut){
    if(opcion == 5){
        busqueda = $.trim($('#nvcliente').val());    
    }else if(opcion == 6){
        busqueda = $.trim($('#nvrut').val());    
    }else{
        busqueda = rut;
        opcion = 6;
    }
    busquedaAJAX = "%" + busqueda.replace(/\s/g, '% %') + "%";
    $.ajax({
        type: "POST",
        url: 'productosCRUD/bd/clientes.php',
        data: {opcion:opcion, busquedaAJAX:busquedaAJAX},
        dataType: "JSON",
        success: function(data)
        {
            if(data.length==0){
                $("#errornvcliente").html("No se encontro ningun cliente que coincida con el nombre/rut buscado.");
                $("#errornvcliente").css('display', 'block');
                $("#errornvcliente").append(`<button type="button" style="position: absolute; right: 0; margin-right: 5px" class="btn btn-primary btnNuevoCliente">Nuevo Cliente</button>`);
                $("#nventa").trigger("reset");
            }else if(data.length==1){
                $("#errornvcliente").css('display', 'none');
                $('#nvcliente').val(data[0]['nombre']);
                $('#nvrut').val(data[0]['rut']);
                $('#nvgiro').val(data[0]['giro']);
                $('#nvdireccion').val(data[0]['direccion']);
                $('#nvcomuna').val(data[0]['comuna']);
                if(data[0]['contacto'] !== null){
                    $('#nvcontacto').val(data[0]['contacto']);
                }else{
                    $('#nvcontacto').val("- SIN ESPECIFICAR -");
                }
                //Ingreso fecha actual al field
                var now = new Date();
                var month = (now.getMonth() + 1);               
                var day = now.getDate();
                if (month < 10) 
                    month = "0" + month;
                if (day < 10) 
                    day = "0" + day;
                var today = now.getFullYear() + '-' + month + '-' + day;
                $('#nvfecha').val(today);
                ////////////////////////////////
                $('#divTablaProductos').css('display', 'block');

                var username_vendedor = document.getElementById('user_username');
                $('#nvvendedor').val(username_vendedor.innerHTML);


            }else if(data.length>1){
                // mostrar modal para seleccionar el cliente
                $('#modal-body-clientes').empty();
                $('#modal-body-clientes').append(`
                        <div class="row">
                            <div class="col-md-4"><h5>Rut</h5></div>
                            <div class="col-md-4"><h5>Nombre</h5></div>
                            <div class="col-md-4"><h5>Seleccionar</h5></div>
                        </div>
                `);
                for(var i=0 ; i< data.length; i++){
                    $('#modal-body-clientes').append(`
                        <div class="row">
                            <div class="col-md-4">${data[i]['rut']}</div>
                            <div class="col-md-4">${data[i]['nombre']}</div>
                            <div class="col-md-4"><button class='btn btn-primary btn-sm btnSelectCliente' rut='${data[i]['rut']}'>Seleccionar</button></div>
                        </div>
                        <hr>

                    `);
                }
                $('#nvclientesbuscados').modal('show');
            }
            
        }
    });
}

$(document).on("click", ".btnNuevoCliente", function(){
    $("#formClientes").trigger("reset");
    $("#rut").prop( "disabled", false );
    $(".modal-header").css( "background-color", "#17a2b8");
    $(".modal-header").css( "color", "white" );
    $(".modal-title").text("Nuevo Cliente");
    $('#modalFormClientes').modal('show');
});

$('#formClientes').submit(function(e){                         
    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
    rut = $.trim($('#rut').val());    
    razon_social = $.trim($('#razon_social').val());    
    direccion = $.trim($('#direccion').val());
    email = $.trim($('#email').val());    
    giro = $.trim($('#giro').val());    
    contacto = $.trim($('#contacto').val());
    comuna = $.trim($('#comuna').val());   
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
            if(info.length == 0){
                opcion = 1;
                $.ajax({
                    url: "productosCRUD/bd/clientes.php",
                    type: "POST",
                    datatype:"json",    
                    data:  {rut:rut, razon_social:razon_social, direccion:direccion, email:email, giro:giro, contacto:contacto ,comuna:comuna ,opcion:opcion},    
                    success: function(data) {
                        //tablaClientes.ajax.reload(null, false);
                        $('#modalFormClientes').modal('hide');	
                        $('#modalNotificacionBody').removeClass("alert-danger");
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
        }
    });									     			
});

$(document).on("focusin", ".productoCantidad", function(){
    if($(this).val() == 0){
        $(this).val("");
    }
});

function enterKeyClientesRUT(e){
    var key= e.keyCode || e.which;
    if (key==13){
        searchCliente(6, $.trim($('#nvrut').val()));
    }
};
function enterKeyClientesRazon(e){
    var key= e.keyCode || e.which;
    if (key==13){
        searchCliente(5, $.trim($('#nvcliente').val()));
    }
};

$(document).on("click", ".btnBuscarNombre", function(){
    opcion = 5;
    searchCliente(opcion, '');

});

$(document).on("click", ".btnBuscarRut", function(){
    opcion = 6;
    searchCliente(opcion, '');
}); 


$(document).on("click", ".btnSelectCliente", function(){
    var rut = $(this).attr('rut');
    opcion = 7;
    searchCliente(opcion, rut);
    $('#nvclientesbuscados').modal('hide');
});

$(document).on("click", ".btnReset", function(){
    $('#divTablaProductos').css('display', 'none');
    $("#nvproductos td").parent().remove();
    $('#nvproductos>tbody').append(`<tr id="rowAddProduct" class="rowAddProduct">
    <td><button class="btn btn-primary btn-sm btnAddProducto"></button></td>
    <td></td>
    <td><b><i>Agregar producto nuevo</i></b></td>
    <td></td>
    <td></td>
    <td></td>
    </tr>`);
});

$(document).on('blur change keyup keydown keypress focus', '.productoCantidad', function (){
    var codigo = $(this).attr('codigo');
    $(`[codigo='${codigo}'].productoTotal`).val($(`[codigo='${codigo}'].productoPrecio`).val() * $(this).val());
    calcularMontos();
});
$(document).on('blur change keyup keydown keypress focus', '.productoPrecio', function (){
    var codigo = $(this).attr('codigo');
    var precio = Math.ceil(($(this).val() * 1.19));
    $(this).attr('title', "Precio con IVA: $"+precio);
    $(`[codigo='${codigo}'].productoTotal`).val($(`[codigo='${codigo}'].productoCantidad`).val() * $(this).val());
    calcularMontos();
});

function calcularMontos(){
    var totalmarks=0;
    $('tr').each(function(){
        $(this).find('.productoTotal').each(function(){
            var marks = parseInt($(this).val());
            totalmarks += marks;
        });
    });
    $('#nvtotalneto').html(toCLP(totalmarks));
    iva19 = totalmarks*0.19;
    $('#nviva19').html(toCLP(iva19.toFixed(0)));
    $('#nvtotalmonto').html((toCLP((totalmarks+iva19).toFixed(0))));
}

function toCLP(number) {
    var number2 = number.toString().replace(".",",");
    return number2.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

$("#nventa").on("submit", function(event){
    event.preventDefault();
    var that = this; // that is the form

    enviarNuevaVenta(function(valid) {
        if(!valid) { return; }
        $(that).off("submit"); // to guarante the function won't be invoked
        that.submit(); // submit the form
    });
});

function enviarNuevaVenta(){
    var numberOfRows = $("#nvproductos>tbody>tr").length;
        if(numberOfRows > 1){
            var flag = true;
            $('tr').each(function(){
                $(this).find('.productoCantidad').each(function(){
                    if($(this).val() == 0){
                        flag = false;
                        $('#diverroralert').html("Hay productos sin una <strong>cantidad</strong> asignada, rellene los campos faltantes o borre los productos.");
                        $('#diverroralert').css("display","block");
                        $('#diverroralert').delay(5000).fadeOut('slow');
                        return false;
                    }
                })
            });
            $('tr').each(function(){
                $(this).find('.productoPrecio').each(function(){
                    if($(this).val() == 0 || $(this).val() == ""){
                        flag = false;
                        $('#diverroralert').html("Hay productos sin un <strong>precio</strong> asignado o igual a 0, modifique los precios por favor.");
                        $('#diverroralert').css("display","block");
                        $('#diverroralert').delay(5000).fadeOut('slow');
                        return false;
                    }
                })
            });
            if(flag){
                printBorrador();
                return true;
            }
        }else{
            $('#diverroralert').css("display","block");
            $('#diverroralert').html("Ingrese al menos <strong>un producto</strong> a la venta.");
            $('#diverroralert').delay(5000).fadeOut('slow');
            return false;
        }
}

function guardarVentaDB(){
    $("#modalCrearVenta").modal('hide');
    nvproductos = [];
    var producto=0, cantidad=0, precio=0;
    $('tr').each(function(){
        $(this).find('.productoCantidad').each(function(){
            producto = $(this).attr("codigo");
            cantidad = parseInt($(this).val());
            precio = $(`[codigo='${producto}'].productoPrecio`).val();
            nombre = $(`[codigo='${producto}'].productoNombre`).val();
            productojson = {"codigo":`${producto}`, "cant":`${cantidad}`, "precio":`${precio}`, "nombre": `${nombre}`};
            nvproductos.push(productojson);
        });
    });
    nventa = {"rut":$('#nvrut').val(), 
            "fecha": $('#nvfecha').val(), 
            "folio": $('#nvfolio').val(),
            "vendedor": $('#nvvendedor').val(),
            "notaventa": $('#nvnotas').val()};
    opcion = 2;
    $.ajax
    ({
        url: 'productosCRUD/bd/ventaproducto.php',
        data: {opcion:opcion, nvproductos:nvproductos, nventa:nventa},
        dataType: "JSON",
        type: "POST",
        success: function(data){
            $('#borradorFolio').text(data[0]['last_id']);
            $('#modalVerPDFVenta').modal({backdrop: 'static', keyboard: false})  
            $("#modalVerPDFVenta").modal("show");
        }
    });
}

$(document).on("click", ".btnCerrarVentaGuardada", function(){
    if($('#user_username').attr('usertype') == 1){
        window.location.href = "allventas2.php";
    }else{
        window.location.href = "tus_ventas.php";
    }
});

var numberOfRows = $("#nvproductos>tbody>tr").length;
$("#nvproductos").bind("DOMSubtreeModified", function() {
    if($("#nvproductos>tbody>tr").length !== numberOfRows){
        numberOfRows = $("#nvproductos>tbody>tr").length;
        $("#barraLimiteProductos").css("width",`${(numberOfRows - 1)*5}%`);
        $("#barraLimiteProductos").html(`<b style="color: black;">Productos: ${numberOfRows-1}</b>`);
        if((numberOfRows-1) == 15){
            $("#barraLimiteProductos").toggleClass("bg-info bg-warning");
        }else if((numberOfRows-1) == 20){
            $("#barraLimiteProductos").toggleClass("bg-warning bg-danger");
            $("#rowAddProduct").remove();
            $("#barraLimiteProductos").css("width","100%");
            $('#modalListaProductos').modal('hide');
            $("#barraLimiteProductos").html(`<b style="color: black;">Productos: 20</b>`);
        }
        
    }
});

function printBorrador(){
    $('#borradorProductos tbody').empty();
    $('#borradorRut').text($('#nvrut').val());
    $('#borradorNombre').text($('#nvcliente').val());
    $('#borradorGiro').text($('#nvgiro').val());
    const monthNames = ["", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
  "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    fecha = $('#nvfecha').val().split("-");
    $('#borradorFecha').text(fecha[2]+" de "+monthNames[parseInt(fecha[1])]+" del "+fecha[0]);
    $('#borradorDireccion').text($('#nvdireccion').val());
    $('#borradorComuna').text($('#nvcomuna').val());
    $('#borradorVendedor').text($('#nvvendedor').val());

    $('#borradorContacto').text($('#nvcontacto').val());
    $('#borradorNeto').text($('#nvtotalneto').text());
    $('#borradorIVA').text($('#nviva19').text());
    $('#borradorTotal').text($('#nvtotalmonto').text());
    $('#borradorNotaTexto').text($('#nvnotas').val());
    
    $('tr').each(function(){
        $(this).find('.productoCantidad').each(function(){
            producto = $(this).attr("codigo");
            cantidad = parseInt($(this).val());
            precio = $(`[codigo='${producto}'].productoPrecio`).val();
            nombre = $(`[codigo='${producto}'].productoNombre`).val();
            productojson = {"codigo":`${producto}`, "cant":`${cantidad}`, "precio":`${precio}`, "nombre": `${nombre}`};
            $('#borradorProductosBody').append(` <tr>
                                                        <td>${producto}</td>
                                                        <td>${nombre}</td>
                                                        <td style="text-align: right">${toCLP(cantidad)}</td>
                                                        <td style="text-align: right">${toCLP(precio)}</td>
                                                        <td style="text-align: right">${toCLP(precio*cantidad)}</td>
                                                    </tr>`);
        });
    });
    $("#modalCrearVenta").modal('show');
}

function printDocumento(){
    $(window).scrollTop(0);
    print();
}

