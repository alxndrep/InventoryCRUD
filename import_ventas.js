$(document).ready(function () {
    bsCustomFileInput.init()
})
const fileSelector = document.getElementById('file-selector');
var facturas = [];
fileSelector.addEventListener('change', (event) => {
    const fileList = event.target.files;
    facturas = [];
    getMetadataForFileList(fileList);

});

function getMetadataForFileList(fileList) {
    console.log(fileList.length);
    if(fileList.length <= 10){
        for (const file of fileList) {
            setTimeout(() => {
                if (file.type && (!file.type.startsWith('application/pdf') && !file.type.startsWith('text/xml'))) {
                    $("#errorTEXT").fadeIn('slow');
                    $("#errorTEXT").delay(5000).fadeOut('slow');
                    document.getElementById("errorTEXT").innerHTML = `<b>Documento incompatible.</b><br/> <strong>Nombre</strong>: ${file.name}, <strong>Tipo de archivo</strong>: ${file.type}`;
                    return;
                }
                if (file.type.startsWith('text/xml')) {
                    $(".btnActionFolios").fadeOut('slow');
                    $("#foliosCargados").fadeOut('slow');
                    document.getElementById("foliosCargados").innerHTML = "";
                    var factura = readFacturaXML(file);
                    setTimeout(() => {
                        fecha = factura[0]["documento"]["fecha"].split("-");
                        document.getElementById("foliosCargados").innerHTML += `<li id="${factura[0]["documento"]["folio"]}" class="list-group-item"><div class='btn-group'><button folio='${factura[0]["documento"]["folio"]}' class='btn btn-primary btn-sm btnVerFolio btnAddProducto btnAddListaProducto' data-toggle="collapse" data-target="#details${factura[0]["documento"]["folio"]}" aria-expanded="false" aria-controls="details${factura[0]["documento"]["folio"]}"></button></div> <strong>Folio</strong>: ${factura[0]["documento"]["folio"]} - <strong>Fecha</strong>: ${fecha.reverse().join("-")} <br/> <strong>Cliente</strong>: ${factura[1]["cliente"]["nombre"]} - <strong>Vendedor</strong>:
                        <select class="folio${factura[0]["documento"]["folio"]}">
                            <option value="SIN ESPECIFICAR">SIN ESPECIFICAR</option>
                            <option value="William Vasquez Leon">William Vasquez Leon</option>
                            <option value="Magdiel Zumelzu de la Jara">Magdiel Zumelzu de la Jara</option>
                            <option value="Carmen Andrea Libre Santiago">Carmen Andrea Libre Santiago</option>
                            <option value="Maria Fernanda Guerra Guerrero">Maria Fernanda Guerra Guerrero</option>
                            <option value="Romina Campos Miranda">Romina Campos Miranda</option>
                            <option value="Carlos Avila Humire">Carlos Avila Humire</option>
                        </select></li>`;
                        document.getElementById("foliosCargados").innerHTML += `<div class="collapse" id="details${factura[0]["documento"]["folio"]}">
                                                                                                        <table class="table table-sm" style="border: 1px solid black; margin-top: 5px;" id="productos${factura[0]["documento"]["folio"]}">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                <th style="background-color: white !important;" scope="col">#</th>
                                                                                                                <th style="background-color: white !important;" scope="col">Cod</th>
                                                                                                                <th style="background-color: white !important;" scope="col">Nombre</th>
                                                                                                                <th style="background-color: white !important;" scope="col">Cantidad</th>
                                                                                                                <th style="background-color: white !important;" scope="col">Precio</th>
                                                                                                                <th style="background-color: white !important;" scope="col">Total Neto</th>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>`;
                        $("#foliosCargados").fadeIn('1000');
                        $(".btnActionFolios").fadeIn('slow');
                        jQuery.each(factura[3]["productos"], function(index, producto){
                            opcion = 5;
                            codigo = producto["codigo"];
                            var nombreproducto;
                            cantidad = producto["cant"];
                            precio = producto["precio"];

                            $.ajax({
                                type: "POST",
                                url: 'productosCRUD/bd/crud.php',
                                data: {opcion:opcion, codigo:codigo},
                                async: false,
                                dataType: "JSON",
                                success: function(data){
                                    if(data.length > 0 ){
                                        nombreproducto = data[0]["nombre"];
                                    }else{
                                        nombreproducto = producto["nombre"];
                                    }
                                }
                            });
                            elid = "#productos"+factura[0]["documento"]["folio"]+" tbody";
                            $(elid).append(`<tr>
                                                <th scope="row">${index+1}</th>
                                                <td>${codigo}</td>
                                                <td>${nombreproducto}</td>
                                                <td>${cantidad}</td>
                                                <td>$${precio}</td>
                                                <td>$${precio*cantidad}</td>
                                            </tr>`);
                        });
                        facturas.push(factura);
                    }, 1000);
                }
            }, 1000);

        }
    }else{
        $("#errorTEXT").fadeIn('slow');
        $("#errorTEXT").delay(5000).fadeOut('slow');
        document.getElementById("errorTEXT").innerHTML = `<strong>Archivos cargados: ${fileList.length}</strong> <br/> Maximo de archivos permitidos: <strong>10</strong>.  Por favor <strong>no sobrepase</strong> el limite, intentelo nuevamente.`;
        return;
    }
    
};

$(document).on("click",".btnAddListaProducto", function(){
    $(this).toggleClass("btnDelProducto");
});

$(document).on("click",".borrarFoliosCargados", function(){
    $("#foliosCargados").fadeOut(900);
    setTimeout(() => {
        document.getElementById("foliosCargados").innerHTML = "";
        $("#file-selector").val('');
        facturas = [];
    }, 1000);
    $(".btnActionFolios").fadeOut('slow');
});
$(document).on("click",".btnCerrarModal", function(){
    window.location.href = "all_ventas.php";
});

$(document).on("click",".btnCargarFolios", function(){
    $('#modalFolioEstadoCarga').modal({backdrop: 'static', keyboard: false});
    $("#modalFolioEstadoCargaTitle").text("Cargando "+ facturas.length + " folio/s.");
    $("#modalFolioEstadoCarga").modal("show");
    let tick = 0;
    let foliosprocesados = 0;
    for (tick=0; tick<10; tick++) {
        if(tick<facturas.length){
            loadingFolios(tick, facturas[tick]);        
        }
    }
    


    function loadingFolios(i, folio){
        setTimeout(function(){
            fecha = folio[0]["documento"]["fecha"].split("-");
            fecha = fecha.reverse().join("/");
            nfolio = folio[0]["documento"]["folio"];
            opcion = 4;
            $(".listaFoliosCarga").append(`  <li class="list-group-item">
                                                <strong>Folio:</strong> ${folio[0]["documento"]["folio"]} - <strong>Fecha:</strong> ${fecha} - <strong>Cliente:</strong> ${folio[1]["cliente"]["nombre"]}
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated" id="pg${folio[0]["documento"]["folio"]}" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                                </div>
                                            </li>`).children(':last')
                                            .hide()
                                            .fadeIn(1000);;
            $.ajax({
                type: "POST",
                url: 'productosCRUD/bd/ventaproducto.php',
                data: {opcion:opcion, nfolio:nfolio},
                async : false,
                dataType: "JSON",
                success: function(data){
                    if(data[0]["existe"] == '0'){
                        $("#pg"+facturas[i][0]["documento"]["folio"]).css("width", "50%");
                        creandoVentas(i, facturas[i]);
                    }else{
                        $("#pg"+nfolio).toggleClass("bg-danger");
                        $("#pg"+nfolio).css("width", "100%");
                        $("#pg"+nfolio).text("Venta no cargada, ya existe una venta con el mismo nro. de folio.");
                        foliosprocesados++;
                        if(i==facturas.length-1 && foliosprocesados == facturas.length){
                            $(".btnCerrarModal").prop("disabled", false);
                        }
                    }
                }
            });
        }, 600*i)
    }

    function creandoVentas(i, folio){
        setTimeout(function(){
            nventa = {"cliente": folio[1]["cliente"], 
            "fecha": folio[0]["documento"]["fecha"], 
            "folio": folio[0]["documento"]["folio"],
            "vendedor": $('.folio'+folio[0]["documento"]["folio"]).val()};
            nvproductos = folio[3]["productos"];

            rut = folio[1]["cliente"]["rut"];
            var rut_temp = '';
            if(rut.length == 10){
                for(var j=0 ; j<10; j++){
                    if(j == 2 || j == 5){
                        rut_temp += ".";
                        rut_temp += (rut.charAt(j));
                    }else{
                        rut_temp += (rut.charAt(j));
                    }
                }
            }else if(rut.length == 9){
                for(var j=0 ; j<10; j++){
                    if(j == 1 || j == 4){
                        rut_temp += ".";
                        rut_temp += (rut.charAt(j));
                    }else{
                        rut_temp += (rut.charAt(j));
                    }
                }
            }
            nventa["cliente"]["rut"] = rut_temp;       
            opcion = 6;
            $.ajax
            ({
                url: 'productosCRUD/bd/ventaproducto.php',
                data: {opcion:opcion, nvproductos:nvproductos, nventa:nventa},
                dataType: "JSON",
                async : false,
                type: "POST",
                success: function(){
                    $("#pg"+folio[0]["documento"]["folio"]).css("width", "100%");
                    $("#pg"+folio[0]["documento"]["folio"]).toggleClass("bg-success");
                    $("#pg"+folio[0]["documento"]["folio"]).text("Cargado con exito.");
                    foliosprocesados++;
                    if(foliosprocesados == facturas.length){
                        $(".btnCerrarModal").prop("disabled", false);
                    }
                },
                error: function(){
                    $("#pg"+folio[0]["documento"]["folio"]).css("width", "100%");
                    $("#pg"+folio[0]["documento"]["folio"]).toggleClass("bg-danger");
                    $("#pg"+folio[0]["documento"]["folio"]).text("Error al cargar.");
                    if(foliosprocesados == facturas.length){
                        $(".btnCerrarModal").prop("disabled", false);
                    }
                }
            });
        }, 1500*i)
    }
});


function readFacturaXML(file) {
    // Check if the file is an image.
    var venta = [];
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function (event) {
        // El texto del archivo se mostrará por consola aquí
        archivo = event.target.result;
        var xml = new XMLHttpRequest();
        xml.open('GET', archivo, false);
        xml.send();
        xmlData = (new DOMParser()).parseFromString(xml.responseText, 'text/xml');

        var documento = xmlData.getElementsByTagName("Documento")[0].getElementsByTagName("Encabezado")[0].getElementsByTagName("IdDoc");
        vArray = {
            "documento":
            {
                "folio": documento[0].getElementsByTagName("Folio")[0].firstChild.data,
                "fecha": documento[0].getElementsByTagName("FchEmis")[0].firstChild.data
            }
        };
        venta.push(vArray);
        documento = xmlData.getElementsByTagName("Documento")[0].getElementsByTagName("Encabezado")[0].getElementsByTagName("Receptor");
        if(documento[0].getElementsByTagName("Contacto")[0] == undefined){
            contacto = "SIN ESPECIFICAR";
        }else{
            contacto = documento[0].getElementsByTagName("Contacto")[0].firstChild.data;
        }
        vArray = {
            "cliente":
            {
                "rut": documento[0].getElementsByTagName("RUTRecep")[0].firstChild.data,
                "nombre": documento[0].getElementsByTagName("RznSocRecep")[0].firstChild.data,
                "direccion": documento[0].getElementsByTagName("DirRecep")[0].firstChild.data,
                "giro": documento[0].getElementsByTagName("GiroRecep")[0].firstChild.data,
                "contacto": contacto,
                "comuna": documento[0].getElementsByTagName("CmnaRecep")[0].firstChild.data
            }
        };
        venta.push(vArray);
        documento = xmlData.getElementsByTagName("Documento")[0].getElementsByTagName("Encabezado")[0].getElementsByTagName("Totales");
        vArray = {
            "totales":
            {
                "neto": documento[0].getElementsByTagName("MntNeto")[0].firstChild.data,
                "iva": documento[0].getElementsByTagName("IVA")[0].firstChild.data,
                "total": documento[0].getElementsByTagName("MntTotal")[0].firstChild.data
            }
        };
        venta.push(vArray);
        documento = xmlData.getElementsByTagName("Documento")[0].getElementsByTagName("Detalle");
        productosArray = [];
        for (i = 0; i < documento.length; i++) {
            if (documento[i].getElementsByTagName("CdgItem")[0] == undefined) {
                producto_cod = "S/Codigo";
            } else {
                producto_cod = documento[i].getElementsByTagName("CdgItem")[0].getElementsByTagName("VlrCodigo")[0].firstChild.data;
            }
            producto_cant = documento[i].getElementsByTagName("QtyItem")[0].firstChild.data;
            producto_precio = documento[i].getElementsByTagName("PrcItem")[0].firstChild.data;
            producto_nombre = documento[i].getElementsByTagName("NmbItem")[0].firstChild.data;
            vArray = {
                "codigo": producto_cod,
                "cant": producto_cant,
                "precio": producto_precio,
                "nombre": producto_nombre
            };
            productosArray.push(vArray);
        }
        vArray = { "productos": productosArray };
        venta.push(vArray);
    };
    return venta;
}