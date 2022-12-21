$(document).ready(function() {
    var opcion;
    opcion = 1;
        
    bajostock = $('#bajostock').DataTable({  
        order: [1, 'asc'],
    language:{
        url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
    },
    "pagingType": "full_numbers",
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
    "ajax":{            
        "url": "productosCRUD/bd/bajostock.php", 
        "method": 'POST', //usamos el metodo POST
        "data":{opcion:opcion}, //enviamos opcion 1 para que haga un SELECT
        "dataSrc":""
    },
    "columns":[
        {"data": "codigo"},
        {"data": "nombre"},
        {"data": "descripcion"},
        {"data": "stock"},
        {"data": "stock_min"},
        {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btn-sm btnEditar'><i class='material-icons'>edit</i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='material-icons'>delete</i></button></div></div>"}
    ]
    });     

    var fila; //captura la fila, para editar o eliminar
    $('#bajostockForm').submit(function(e){         
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
        codigo = $.trim($('#codigo').val());    
        stock = $.trim($('#stock').val());    
        stock_min = $.trim($('#stock_min').val());
        opcion = 2; // actualizar stock
            $.ajax({
              url: "productosCRUD/bd/bajostock.php",
              type: "POST",
              datatype:"json",    
              data:  {opcion:opcion, codigo:codigo, stock:stock, stock_min:stock_min},    
              success: function(data) {
                bajostock.ajax.reload(null, false);
               }
            });			        
        $('#modalForm').modal('hide');											     			
    });
            
    //Editar
    $(document).on("click", ".btnEditar", function(){		        
        opcion = 2;//editar
        $('#bajostockForm').trigger("reset");
        $( "#codigo" ).prop( "disabled", true );
        $( "#nombre" ).prop( "disabled", true );
        fila = $(this).closest("tr");	        
        codigo = fila.find('td:eq(0)').text(); //capturo el ID	
        nombre = fila.find('td:eq(1)').text();
        stock = fila.find('td:eq(3)').text();
        stock_min = fila.find('td:eq(4)').text();
        $("#codigo").val(codigo);
        $("#nombre").val(nombre);
        $("#stock").val(stock);
        $("#stock_min").val(stock_min);
        $(".modal-header").css("background-color", "#a80b0b");
        $(".modal-header").css("color", "white" );
        $(".modal-title").text(nombre);		
        $('#modalForm').modal('show');		   
    });

    //Borrar
    $(document).on("click", ".btnBorrar", function(){
        fila = $(this);           
        codigo = $(this).closest('tr').find('td:eq(0)').text();		
        nombre = $(this).closest('tr').find('td:eq(1)').text();		
        opcion = 3; //eliminar        
        var respuesta = confirm("¿Está seguro de borrar el producto "+nombre+" - Codigo: "+codigo+" ?");                
        if (respuesta) {            
            $.ajax({
                url: "productosCRUD/bd/bajostock.php",
                type: "POST",
                datatype:"json",    
                data:  {opcion:opcion, codigo:codigo},    
                success: function() {
                    bajostock.row(fila.parents('tr')).remove().draw();                  
                }
            });	
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

    $(document).on("click", ".btnplusstock", function(){
        var valor = parseInt($('#plusStock').val());
        var result = parseInt($("#stock").val()) + valor;
        if(result < valor) $("#stock").val(valor);
        else $("#stock").val(result);
    });	

});