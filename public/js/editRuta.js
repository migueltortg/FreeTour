$(function(){

    function cargarVisitas(){
            $("#visitasDisponibles").children().each(function(){//VACIAMOS EL LISTADO DE VISITAS PARA CARGAR DE NUEVO
                $(this).remove();
            });
            $.get('/cargar_visitasAPI', { localidad: $("#selectLocalidad").val() })//PETICION AJAX PARA CAGAR LISTADO DE VISITAS
            .done(function(data) {
              crearVisitas(JSON.parse(data));
            })
            .fail(function(error) {
                console.log('Error al obtener los datos de la API:', error);
            });
    }

    $("#selectLocalidad").change(function(){//CADA VEZ QUE CAMBIE EL SELECT SE RECARGAN LAS VISITAS
        cargarVisitas();
    });

    function crearVisitas(array){//CREAMOS EL HTML DE LAS VISITAS
        for(var i=0;i<array.length;i++){
            repite=true;
            $("#visitasAsignadas li").each(function(){
                if($(this).attr("id")==array[i].id){
                    repite=false;
                }
            });
            if(repite){
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
    }

    function getVisitas(){//RECOGEMOS LAS ID DE LAS VISITAS QUE SE HAN ASIGNADO A LA RUTA
        var visitas=[];
        $("#visitasAsignadas").children().each(function(){
            visitas.push($(this).attr("id"));
        });
        return visitas;
    }

    function crearRutaJSON(){//CREAMOS EL OBJETO RUTA 
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

    function getProgramacion(){//RECOGEMOS TODOS LOS DATOS NECESARIOS PARA FORMAR EL JSON DE PROGRAMACION
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


    
    $("#confirmarEdit").click(function(){
        if(validar()){
            editarRuta(crearRutaJSON());
        }else{
            console.log("ERROR");
        }
    });

    function editarRuta(json) {//API PARA CREAR RUTA
        
        var jsonData = JSON.stringify(json);
    
        var formData = new FormData();
        const urlParams=new URLSearchParams(window.location.search);
        var id=urlParams.get('id');

        formData.append('id', id);
        formData.append('ruta', jsonData);
        
        if($('input[type="file"][id^="images-"]')[0].files[0]!==undefined){
            var file = $('input[type="file"][id^="images-"]')[0].files[0];
            formData.append('foto', file);
        }

        formData.append('guia',$("#guias").val());

        $.ajax({
            url: '/editarRutaAPI',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                alert(data);
                location.reload();
            },
            error: function(error) {
                console.log('Error al obtener los datos de la API:', error);
            }
        });
    }

    function validar(){
        var validado=true;

        if(!comprobarTab1()){//VALIDACION DEL PRIMER TAB
            validado=false;
        }

        if(!comprobarTab2()){//VALIDACION DEL SEGUNDO TAB
            validado=false;
        }

        if(!comprobarTab3()){//VALIDACION DEL TERCER TAB
            validado=false;
        }

        return validado;//SI NINGUN TAB ES ERRONEO DEVUELVE TRUE
    }

    function comprobarTab1(){//REVISAMOS Y VALIDAMOS EL PRIMER TAB
        var validado=true;

        $('#tabs-1 input,textarea').each(function(){
            if(($(this).val()=="" || $(this).val()=="<br>" || $(this).val()=="<div><br></div>") && $(this).attr('id')!=="imageURL"
            && $(this).attr('id')!=="fileURL" && $(this).attr('id')!=="fileText" && $(this).attr('id')!=="videoURL" && $(this).attr('id')!=="url"
            && $(this).attr('id')!=="urlText" && $(this).attr('id')!=="tableRows" && $(this).attr('id')!=="tableColumns"
            && !$(this).attr('id').startsWith("images-")){
                if($(this).is("textarea")){
                    $(".richText").css("border","3px solid red");
                    validado=false;
                }else{
                    console.log($(this).attr('id'));
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
            if($(this).attr('id')=="fecha"){
                if((($("#fecha").data('daterangepicker').startDate._i)-($("#fecha").data('daterangepicker').endDate._i))<0){
                    $(this).css("border","3px solid green");
                }else{
                    validado=false;
                    $(this).css("border","3px solid red");                
                }
            }
        });

        if(validado){
            $("#tab-1-li").css("background-color","green");
        }else{
            $("#tab-1-li").css("background-color","red");
        }

        return validado;
    }

    function comprobarTab2(){//REVISAMOS Y VALIDAMOS EL SEGUNDO TAB
        var validado=true;

        if($("#visitasAsignadas").children().length>0){
            $("#tab-2-li").css("background-color","green");
        }else{
            validado=false;
            $("#tab-2-li").css("background-color","red");
        }

        return validado;
    }

    function comprobarTab3(){//REVISAMOS Y VALIDAMOS EL TERCER TAB
        var validado=true;

        if($("#horarios").children().children(1).length>1){
            $("#tab-3-li").css("background-color","green");
        }else{
            validado=false;
            $("#tab-3-li").css("background-color","red");
        }

        return validado;
    }


    $(textarea).richText({
        height: "auto",
        removeStyles:true,
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
        if((($("#fechaPr").data('daterangepicker').startDate._i)-($("#fechaPr").data('daterangepicker').endDate._i))<0){
            $("#fechaPr").css("border","3px solid green");
            agregarFila();
        }else{
            $("#fechaPr").css("border","3px solid red");                
        }
    });

    function eliminarFila(ev,fila){
        ev.preventDefault();
        fila.remove();
    }


    function agregarFila() {
        var rangoFecha = $("#fechaPr").val();
        var dias = obtenerDiasSeleccionados();
        var hora = $("#hora").val();
        var persona = $("#guias").val();
    
        var fila = "<tr><td>" + rangoFecha + "</td><td>" + dias + "</td><td>" + hora + "</td><td>" + persona + "</td><td><button class='eliminarBTN'>Eliminar</button></td></tr>";
        $("#horarios tbody").append(fila);

        $("#horarios tbody tr:last-child .eliminarBTN").click(function(event) {
            eliminarFila(event, $(this).closest("tr"));
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

    const urlParams = new URLSearchParams(window.location.search);
    let id= urlParams.get('id');

    var formData = new FormData();
    formData.append('id', id);

    $.ajax({
        url: '/rutaId',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
            ruta = (JSON.parse(data));
            console.log(data);
            $("#inputTitulo").val(ruta.nombre);
            $('#descripcion').val(ruta.descripcion);
            $('.image-uploader').attr("class","image-uploader has-files");
            var preloadedFile = [{id:1,src:'fotos_rutas/'+ruta.foto}];

            $('#input-images').imageUploader({
                preloaded: preloadedFile, // Pass the preloaded file as an array
                extensions: ['.jpg','.jpeg','.png'],
            });
            
            $("#x").val(ruta.puntoInicio.split(",")[0]);
            $("#y").val(ruta.puntoInicio.split(",")[1].trim());

            $("#fecha").data('daterangepicker').setStartDate(new Date(ruta.fechaInicio));
            $("#fecha").data('daterangepicker').setEndDate(new Date(ruta.fechaFin));

            $("#aforo").val(ruta.aforo);

            $(ruta.visitas).each(function(){
                $("#visitasAsignadas").html('<li class="visitaItem" style="border: 2px solid black;" id="'+$(this)[0].id+'"><img src="fotos_visitas/'+$(this)[0].foto+'" alt="'+$(this)[0].nombre+'" style="width: 80px; height: 80px;"><h2>'+$(this)[0].nombre+'</h2><p>'+$(this)[0].descripcion+'</p></li>');
            });

            cargarVisitas();
            
            var programacion =  JSON.stringify(ruta.programacion);
            console.log(ruta.programacion);
            ruta.programacion.forEach(function(dia) {
                var fila = "<tr><td>" + dia.rangoFecha + "</td><td>" + dia.dias + "</td><td>" + dia.hora + "</td><td>" + dia.guia + "</td><td><button class='eliminarBTN'>Eliminar</button></td></tr>";
                
                $("#horarios tbody").append(fila);
            });
            
            $("#horarios tbody tr:last-child .eliminarBTN").click(function(event) {
                eliminarFila(event, $(this).closest("tr"));
            });

        },
        error: function(error) {
            console.log('Error al obtener los datos de la API:', error);
        }
    });
});