let tablaBusqueda;

function format (d, info ) {
    total = parseInt(d.total.replace(/,/g, ''));

    notaventa = "No se agrego nota alguna.";
    if(d.notaventa != null){
        notaventa = '"' + d.notaventa + '"';
    }

    return '<dl class="row">'+
                '<dt class="col-sm-2">Nombre cliente</dt>'+
                '<dd class="col-sm-4">'+ d.cliente +'</dd>'+
                '<dt class="col-sm-2">Rut cliente</dt>'+
                '<dd class="col-sm-4">'+ d.rut +'</dd>'+

                '<dt class="col-sm-2">Direccion</dt>'+
                '<dd class="col-sm-4">'+ d.direccion +'</dd>'+
                '<dt class="col-sm-2">Giro</dt>'+
                '<dd class="col-sm-4">'+ d.giro +'</dd>'+
                
                '<dt class="col-sm-2">Monto neto</dt>'+
                '<dd class="col-sm-4">$'+ (Math.round((total/1.19))).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.") +'</dd>'+
                '<dt class="col-sm-2">IVA 19%</dt>'+
                '<dd class="col-sm-4">$'+ (Math.round(((total/1.19)*0.19))).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.") +'</dd>'+

                '<dt class="col-sm-2">Productos</dt>'+
                '<dd class="col-sm-10">'+info.length+' producto/s vendidos.</dd>'+

                '<dt class="col-sm-2">Nota de la venta</dt>'+
                '<dd class="col-sm-10">'+notaventa+'</dd>'+
                
                '<dd class="col-sm-10"></dd>'+
                `<dd class="col-sm-2"><button totalventa="${d.total}" ventaid="${d.venta_id}" class="btn btn-outline-primary btn-sm btnVerProductos">Ver Detalle</button></dd>`+
                '<dd class="col-sm-10"></dd>'+
                `<dd class="col-sm-2"><form action="edit_ventas.php" method="POST">
                <button ventaid="${d.venta_id}" class="btn btn-outline-primary btn-sm btnEditarVenta">Editar Venta</button>
                <input type="hidden" class="tagventa_id" name="venta_id" value="${d.venta_id}">
              </form></dd>`+
                '<dd class="col-sm-10"></dd>'+
                `<dd class="col-sm-2"><button ventaid="${d.venta_id}" class="btn btn-outline-danger btn-sm btnBorrarVenta">Borrar</button></dd>`+
            '</dl>';
}

$('#tablaBusqueda tbody').on('click', 'tr', function () {
    if(!$(this).hasClass('detalles-venta')){
        var tr = $(this).closest('tr');
        var row = tablaBusqueda.row( tr );
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
            tr.css("background-color","white");
        }
        else {
            opcion = 2;
            venta_id = row.data().venta_id;
            $.ajax({
                type: "POST",
                url: 'productosCRUD/bd/allventas.php',
                data: {opcion:opcion, venta_id:venta_id},
                dataType: "JSON",
                success: function(data)
                {
                    row.child( format(row.data(), data)).show();
                    row.child().addClass('detalles-venta');
                    tr.addClass('shown');
                    tr.css("background-color","#FFC300");
                    tr.css("color","black");
                }
            });
        }
    }
});


function rellenarspClientes(){
    opcion = 7;
    vendedor = $("#spVendedor").val();
    $.ajax({
        type: "POST",
        url: 'productosCRUD/bd/allventas.php',
        data: {opcion:opcion, vendedor:vendedor},
        dataType: "JSON",
        success: function(data){
            $('#spCliente').empty();
            if(data.length > 0 ){
                for(var i=0; i<data.length; i++){
                    $('#spCliente').append(`<option>${data[i]['nombre']}</option>`);
                }
                $('#spCliente').prop("disabled", false);
                $('#spCliente').selectpicker('refresh');
                $("#spbtnBuscar").prop("disabled", false);
            }else{
                $('#spCliente').prop("disabled", true);
                $("#spbtnBuscar").prop("disabled", false);
                $('#spCliente').selectpicker('refresh');
            }
        }
    });
}

$("#spVendedor").on('change', function(){
    $("#spFechaInicio").prop("disabled", false);
    rellenarspClientes(); 
});

$("#spFechaInicio").on('change', function(){
    if(!$("#spFechaInicio").val() == ''){
        $("#spFechaTermino").prop("disabled", false);
        $("#spFechaTermino").attr("min", $("#spFechaInicio").val());
    }else{
        $("#spFechaTermino").prop("disabled", true);
        $("#spFechaTermino").val("dd/mm/aaaa");
    }
});

$("#spFechaTermino").on('change', function(){
    $("#spFechaInicio").attr("max", $("#spFechaTermino").val());
});

$('#spCliente').on('change', function(){
    $("#spbtnBuscar").prop("disabled", false);
});

$('#spbtnBuscar').on('click', function(){
    $('#contentBusqueda').css("display", "block");
    $('#contentResumen').addClass("d-none");
    $('#contentResumenAlert').addClass("d-none");

    vendedor = $("#spVendedor").val();
    fechaInicio = $("#spFechaInicio").val();
    fechaInicio.replace("-","/");
    fechaTermino = $("#spFechaTermino").val();
    fechaTermino.replace("-","/");
    clientes = $('#spCliente').val();
    let opcion = 5;

    if(fechaInicio == ''){
        if(clientes.length < 1){
            // sin nada la busqueda
            opcion = 8;
        }else{
            // sin fecha con cliente
            opcion = 9;
        }
    }else{
        if(fechaTermino == ''){
            fechaTermino = '2050-01-01';
        }
        if(clientes.length < 1){
            // con fecha sin cliente
            opcion = 5;
        }else{
            /// con todo la busqueda
            opcion = 6;
        }
    }

    if(vendedor == 'allventas') opcion = 12;

    $('#tablaBusqueda').DataTable().destroy();
    tablaBusqueda = $('#tablaBusqueda').DataTable({  
        order: [3, 'asc'],
        language:{
            url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
        },
        "lengthChange": false,
        "pageLength": -1,
        "info": false,
        "ajax":{            
            "url": "productosCRUD/bd/allventas.php",
            "method": 'POST', //usamos el metodo POST
            "data":{opcion:opcion, vendedor:vendedor, fechaInicio:fechaInicio, fechaTermino:fechaTermino, clientes:clientes},
            "dataSrc":""
        },
        "columns":[
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ""
            },       
            {"data": "folio"},
            {"data": "cliente",className:"rvclienteNombre"},
            {"data": "fecha"},
            {"data": "total",className:"ventaclientetotal"},
        ]
    });  
  
});

$(document).on("click", "#btnCargarResumen", function(){
    calcularResumenes();
});

function toCLP(number) {
    var number2 = number.toString().replace(".",",");
    return number2.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
function masFrecuente(array){
    if(array.length == 0)
        return null;
    var modeMap = {};
    var maxEl = array[0], maxCount = 1;
    for(var i = 0; i < array.length; i++)
    {
        var el = array[i];
        if(modeMap[el] == null)
            modeMap[el] = 1;
        else
            modeMap[el]++;  
        if(modeMap[el] > maxCount)
        {
            maxEl = el;
            maxCount = modeMap[el];
        }
    }
    return maxEl;
}
function menosFrecuente(arr, n){
    arr.sort();
    let min_count = n+1, res = -1;
    let curr_count = 1;  
    for (let i = 1; i < n; i++) {
        if (arr[i] == arr[i - 1])
            curr_count++;
        else {
            if (curr_count < min_count) {
                min_count = curr_count;
                res = arr[i - 1];
            }
            curr_count = 1;
        }
    }

    if (curr_count < min_count){
        min_count = curr_count;
        res = arr[n - 1];
    }
    return res;
}


function calcularResumenes(){
    let sumarvTotal = 0;
    let totalVentas = 0;
    let mayorVenta = -1;
    let menorVenta = 999999999;

    $('#tablaventas tr td.ventaclientetotal').each(function() {
        venta = parseInt($(this).html().replace(",",""));
        sumarvTotal += venta;
        totalVentas++;
        if(mayorVenta <= venta){
            mayorVenta = venta;
        }
        if(menorVenta >= venta){
            menorVenta = venta;
        }
    });

    let listaclientes = [];
    let totalclientes = 0;
    let ultimoclienteleido = "";
    $('#tablaventas tr td.rvclienteNombre').each(function() {
        cliente = $(this).html().trim();
        listaclientes.push(cliente);
    });

    for(var i=0; i<listaclientes.length; i++){
        if(ultimoclienteleido !== listaclientes[i]){
            totalclientes++;
        }
        ultimoclienteleido = listaclientes[i];
    }
    if(totalVentas == 0){
        $('#contentResumenAlert').removeClass("d-none");
    }else{
        $('#contentResumen').removeClass("d-none");

        $('#rvTotal').html("$"+toCLP(sumarvTotal));
        $('#rvPromedio').html("$"+toCLP(parseInt(sumarvTotal/totalVentas)));
        $('#rvMayor').html("$"+toCLP(mayorVenta));
        $('#rvMenor').html("$"+toCLP(menorVenta));

        $('#rcTotal').html("<strong>"+toCLP(totalclientes)+"</strong>");
        $('#rcMayor').html("<small>"+masFrecuente(listaclientes)+"</small>");
        $('#rcMenor').html("<small>"+menosFrecuente(listaclientes,listaclientes.length)+"</small>");

        $('#rfTotal').html("$"+toCLP(sumarvTotal));
        $('#rfTotalNeto').html("$"+toCLP(parseInt((sumarvTotal/1.19))));
        $('#rfPorcentaje').html("$"+toCLP(parseInt(((sumarvTotal/1.19)*0.03))));
    }

   
}

$(document).on("click",".btnBorrarVenta", function(){
    opcion = 3;
    venta_id = parseInt(($(this).attr('ventaid')).replace(/[.,\s]/g, ''));
    var respuesta = confirm("¿Está seguro de borrar la venta?")
    if(respuesta){    
        $.ajax({
            type: "POST",
            url: 'productosCRUD/bd/allventas.php',
            data: {opcion:opcion, venta_id:venta_id},
            dataType: "JSON",
            success: function(data)
            {
                alert("Venta borrada del sistema.");
                location.reload();
            }
        });
    }   
});


$(document).on("click",".btnVerProductos", function(){
    opcion = 2;
    venta_id = parseInt(($(this).attr('ventaid')).replace(/[.,\s]/g, ''));
    console.log("id: "+venta_id);
    total_venta = parseInt(($(this).attr('totalventa')).replace(/[.,\s]/g, ''));
    $("#printBTN").attr("ventaid",venta_id);
    $(".btnEditarVenta").attr("ventaid",venta_id);
    $(".tagventa_id").val(venta_id)
    $.ajax({
        type: "POST",
        url: 'productosCRUD/bd/allventas.php',
        data: {opcion:opcion, venta_id:venta_id},
        dataType: "JSON",
        success: function(data)
        {
            var productos = '<table id="ventaProductos" cellpadding="5" cellspacing="0" style="padding-left:50px; width: 100%">'+
                            '<thead>'+
                                '<tr>'+
                                    '<td>Item</td>'+
                                    '<td>Codigo</td>'+
                                    '<td>Producto</td>'+
                                    '<td>Cantidad</td>'+
                                    '<td>Precio</td>'+
                                    '<td>Total</td>'+
                                '</tr>'+
                            '</thead>'+
                            '<tbody>';
            for(var i = 0 ; i<data.length ; i++){
                productos += '<tr>'+
                                '<td><center><strong>'+ (i+1) +'</center></strong></td>'+
                                '<td>'+ data[i]['codigo']+'</td>'+
                                '<td>'+ data[i]['nombre']+'</td>'+
                                '<td><center>'+ data[i]['cant']+'</center></td>'+
                                '<td>$'+ data[i]['precio']+'</td>'+
                                '<td>$'+ data[i]['total']+'</td>'+
                            '</tr>';
            }
            productos +=    '</tbody><tfoot><tr>'+
                                '<td></td>'+
                                '<td></td>'+
                                '<td></td>'+
                                '<td></td>'+
                                '<td><strong>Monto Neto</strong></td>'+
                                '<td id="ventaMontoNeto">$'+ Math.round((total_venta/1.19)).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.") +'</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td></td>'+
                                '<td></td>'+
                                '<td></td>'+
                                '<td></td>'+
                                '<td><strong>IVA 19%</strong></td>'+
                                '<td id="ventaIVA19">$'+ Math.round((total_venta*0.19)).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.") +'</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td></td>'+
                                '<td></td>'+
                                '<td></td>'+
                                '<td></td>'+
                                '<td><strong>Monto Total</strong></td>'+
                                '<td id="ventaMontoTotal">$'+ total_venta.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.") +'</td>'+
                            '</tr>'+
                         '</tfoot></table>';
            $('#modalProductosContent').html(productos);
            $('#modalProductosVentas').modal('show');	   
        }
    });
});

$(document).on("click",".btnVerPDF", function(){
    venta_id = parseInt(($(this).attr('ventaid')).replace(/[.,\s]/g, ''));
    opcion = 4;
    $.ajax({
        type: "POST",
        url: 'productosCRUD/bd/allventas.php',
        data: {opcion:opcion, venta_id:venta_id},
        dataType: "JSON",
        success: function(data)
        {
            $('#borradorProductos tbody').empty();
            $('#borradorRut').text(data[0]['rut']);
            $('#borradorNombre').text(data[0]['razon_social']);
            $('#borradorGiro').text(data[0]['giro']);

            const monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
              fecha = (data[0]['fecha']).split("-");
              fechames = new Date (data[0]['fecha']);
              $('#borradorFecha').text(fecha[2]+" de "+monthNames[fechames.getMonth()]+" del "+fecha[0]);

            $('#borradorDireccion').text(data[0]['direccion']);
            $('#borradorComuna').text(data[0]['comuna']);
            $('#borradorVendedor').text(data[0]['vendedor']);
            $('#borradorFolio').text(data[0]['nro_folio']);
            if(data[0]['isborrador']==1){
                $('#tipoVenta').text("B O R R A D O R");
            }else{
                $('#tipoVenta').text("FACTURA ELECTRONICA");
            }
            $('#borradorContacto').text(data[0]['contacto']);
            $('#ventaProductos > tbody > tr').each(function(){
                $('#borradorProductosBody').append(` <tr>
                                                        <td>${$(this).find('td:eq(1)').text()}</td>
                                                        <td>${$(this).find('td:eq(2)').text()}</td>
                                                        <td style="text-align: right">${$(this).find('td:eq(3)').text()}</td>
                                                        <td style="text-align: right">${$(this).find('td:eq(4)').text().replace('$', '')}</td>
                                                        <td style="text-align: right">${$(this).find('td:eq(5)').text().replace('$', '')}</td>
                                                    </tr>`);
            });
            $('#borradorNeto').text($('#ventaMontoNeto').text().replace('$', ''));
            $('#borradorIVA').text($('#ventaIVA19').text().replace('$', ''));
            $('#borradorTotal').text($('#ventaMontoTotal').text().replace('$', ''));
            $('#borradorNotaTexto').text(data[0]['notaventa']);

            $(window).scrollTop(0);
            print();
        }
    });
});
