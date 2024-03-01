$(function(){

    $("#crearRutaBtn").click(function(){
        if(validar()){
            crearRutaAPI(crearRutaJSON(),false);
        }else{
            console.log("ERROR");
        }
    });

    cargarVisitas();

    function cargarVisitas(){
            $("#visitasDisponibles").children().each(function(){
                $(this).remove();
            });
            $.get('/cargar_visitasAPI', { localidad: $("#selectLocalidad").val() })
            .done(function(data) {
              crearVisitas(JSON.parse(data));
            })
            .fail(function(error) {
                console.log('Error al obtener los datos de la API:', error);
            });
    }

    $("#selectLocalidad").change(function(){
        cargarVisitas();
    });

    function crearVisitas(array){
        for(var i=0;i<array.length;i++){
            var liElement = $('<li>', {
                'class': 'visitaItem',
                'style': 'border: 2px solid black;',
                'id':array[i].id,
            });
            var fotoUrl = "fotos_visitas/" + array[i].foto;
            var imgElement = $('<img>', {
                'src': fotoUrl,
                'width': '80px',
                'height': '80px',
                'alt': array[i].nombre
            }).appendTo(liElement);
        
            var h2Element = $('<h2>').text(array[i].nombre).appendTo(liElement);
            var pElement = $("<p>").html((array[i].descripcion).replace("<div>","").replace("</div>","")).appendTo(liElement);

        
            liElement.appendTo('#visitasDisponibles');
        }
    }

    function getVisitas(){
        var visitas=[];
        $("#visitasAsignadas").children().each(function(){
            visitas.push($(this).attr("id"));
        });
        return visitas;
    }

    function crearRutaJSON(){
        var ruta = {
            titulo: $("#inputTitulo").val(),
            descripcion: $("#textarea").val(),
            punto_inicio:$("#x").val()+", "+$("#y").val(),
            aforo:$("#aforo").val(),
            fecha_inicio:$("#fecha").val().split(" ")[0],
            fecha_fin:$("#fecha").val().split(" ")[2],
            programacion:getProgramacion(),
            visitas:getVisitas(),
        };
        return ruta;
    }

    function getProgramacion(){
        var programacion=[];
        $("#horarios tbody").children().each(function(){
            let dia = {
                rangoFecha:($(this).children().eq(0).text()),
                dias:($(this).children().eq(1).text()),
                hora:($(this).children().eq(2).text()),
                guia:($(this).children().eq(3).text())
            };
            programacion.push(dia);
        });
        
        return JSON.stringify(programacion);
    }


    $("#crearRutaTourBtn").click(function(){
        crearRutaAPI(crearRutaJSON(),true);
    });

    function crearRutaAPI(json,tour) {
        var jsonData = JSON.stringify(json);
        
        var file = $('input[type="file"][id^="images-"]')[0].files[0];
    
        var formData = new FormData();
        formData.append('ruta', jsonData);
        formData.append('foto', file);
        formData.append('tour',tour);
        formData.append('guia',$("#guias").val());

        $.ajax({
            url: '/crearRutaAPI',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                console.log(data);
                $("<p>").text("Ruta Creada").dialog({
                    modal:true,
                    draggable: false,
                    position: { my: "top", at: "top", of: $(".main-content") },
                    width:"20%",
                    heigth:"10vh",
                }); 
            },
            error: function(error) {
                console.log('Error al obtener los datos de la API:', error);
            }
        });

        console.log(jsonData);
    }

    function validar(){
        var validado=true;

        if(!comprobarTab1()){
            validado=false;
        }

        if(!comprobarTab2()){
            validado=false;
        }

        if(!comprobarTab3()){
            validado=false;
        }

        return validado;
    }

    function comprobarTab1(){
        var validado=true;

        $('#tabs-1 input,textarea').each(function(){
            if(($(this).val()=="" || $(this).val()=="<br>" || $(this).val()=="<div><br></div>") && $(this).attr('id')!=="imageURL"
            && $(this).attr('id')!=="fileURL" && $(this).attr('id')!=="fileText" && $(this).attr('id')!=="videoURL" && $(this).attr('id')!=="url"
            && $(this).attr('id')!=="urlText" && $(this).attr('id')!=="tableRows" && $(this).attr('id')!=="tableColumns"){
                if($(this).is("textarea")){
                    $(".richText").css("border","3px solid red");
                    validado=false;
                }else{
                    $(this).css("border","3px solid red");
                    validado=false;
                }
            }else{
                if($(this).is("textarea")){
                    $(".richText").css("border","3px solid green");
                }else{
                    $(this).css("border","3px solid green");
                }
            }
        });

        if($('input[type="file"][id^="images-"]')[0].files.length<1){
            $('#input-images').css("border","3px solid red");
            validado=false;
        }else{
            $('#input-images').css("border","3px solid green");
        }

        if(validado){
            $("#tab-1-li").css("background-color","green");
        }else{
            $("#tab-1-li").css("background-color","red");
        }

        return validado;
    }

    function comprobarTab2(){
        var validado=true;

        if($("#visitasAsignadas").children().length>0){
            $("#tab-2-li").css("background-color","green");
        }else{
            validado=false;
            $("#tab-2-li").css("background-color","red");
        }

        return validado;
    }

    function comprobarTab3(){
        var validado=true;

        if($("#horarios").children().children(1).length>1){
            $("#tab-3-li").css("background-color","green");
        }else{
            validado=false;
            $("#tab-3-li").css("background-color","red");
        }

        return validado;
    }

    function pintarError(boton){
        boton.css("border","3px solid red");
    }

    function pintarCorregido(boton){
        boton.css("border","3px solid green");
    }

    function crearRutaTours(){
        //FUNCION VALIDAR
        //LLAMADA API
        console.log("TOURS Y RUTA");
    }

    $(textarea).richText({
        height: "auto",
        removeStyles:true,
    });

    $('#input-images').imageUploader({
        extensions: ['.jpg','.jpeg','.png'],
    });

    $('#tabs').tabs();

    $("#btnMapa").click(function () {
        var mapa=$('<div id="map"></div>').appendTo('#modal').dialog({
            modal: true,
            width:"90%",        
            draggable: false,
            open: function (event, ui) {
                var mymap = L.map('map').setView([40.2668, -3.6638], 6);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mymap);

                mymap.on('click', function (e) {
                    var lat = e.latlng.lat;
                    var lng = e.latlng.lng;

                    $("#x").val(lat);
                    $("#y").val(lng);

                    $("#map").remove();
                    $(this).remove(); 
                });
            },
            close: function () {
                $("#map").remove();
                $(this).remove();
            }
        });
        $("#map").parent().css({height: "60vh",top : "15vh"});
        $("#map").css({height: "110%"});

    });

    $("#aforo").spinner({
        min:1
    });

    $( "ul#visitasDisponibles" ).sortable({
        connectWith: "ul"
    });

    $( "ul#visitasAsignadas" ).sortable({
    connectWith: "ul"
    });
    
    $("#btnAñadir").click(function(){
        agregarFila();
    });

    function eliminarFila(ev,fila){
        ev.preventDefault();
        fila.remove();
    }

    function editarFila(ev, fila) {
        ev.preventDefault();
    
        var celdas = fila.find('td');
        
        celdas.each(function(index) {
            if (index === celdas.length - 1) { 
                $(this).html('<button class="guardarBTN">Guardar</button>');
            } else {
                var texto = $(this).text();
                var input = $('<input>').val(texto);
                $(this).html(input);
            }
        });
    
        fila.find('.guardarBTN').click(function() {
            fila.find('td').each(function(index) {
                if (index !== celdas.length - 1) { 
                    var valorInput = $(this).find('input').val(); 
                    $(this).text(valorInput);
                }
            });
            
            fila.find('td:last-child').html("<button class='editarBTN'>Editar</button><button class='eliminarBTN'>Eliminar</button>");
        });
    }

    function agregarFila() {
        var rangoFecha = $("#fechaPr").val();
        var dias = obtenerDiasSeleccionados();
        var hora = $("#hora").val();
        var persona = $("#guias").val();
    
        var fila = "<tr><td>" + rangoFecha + "</td><td>" + dias + "</td><td>" + hora + "</td><td>" + persona + "</td><td><button class='editarBTN'>Editar</button><button class='eliminarBTN'>Eliminar</button></td></tr>";
        $("#horarios tbody").append(fila);

        $("#horarios tbody tr:last-child .eliminarBTN").click(function(event) {
            eliminarFila(event, $(this).closest("tr"));
        });

        $("#horarios tbody tr:last-child .editarBTN").click(function(event) {
            editarFila(event, $(this).closest("tr"));
        });
    }
  
    function obtenerDiasSeleccionados() {
        var diasSeleccionados = [];
        $("#diasSemana input[type='checkbox']:checked").each(function() {
            diasSeleccionados.push($(this).val());
        });
        return diasSeleccionados.join(",");
    }

    $(".ui-dialog-titlebar-close").on("click", function () {
        window.location.href = "/admin";
    });
    
    $('#fecha').daterangepicker({
        locale: {
            cancelLabel: 'Clear',
            format: 'DD/MM/YYYY',
        },
    });

    $("#fecha").on("change",function(){
        fechaIni=$("#fecha").val().split(" ")[0].split("/");
        fechaFin=$("#fecha").val().split(" ")[2].split("/");

        $('#fechaPr').daterangepicker({
            locale: {
                cancelLabel: 'Clear',
                format: 'DD/MM/YYYY',
            },
            minDate:new Date(fechaIni[2], fechaIni[1], fechaIni[0]),
            maxDate:new Date(fechaFin[2], fechaFin[1], fechaFin[0]),
        });
    });
});