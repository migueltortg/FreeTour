$(function(){
    $('#tabs').tabs();

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

    $("#btnAñadir").click(function(){
        agregarFila();
    });

    function agregarFila() {
        var rangoFecha = $("#fechaPr").val();
        var dias = obtenerDiasSeleccionados();
        var hora = $("#hora").val();
        var persona = $("#guias").val();
  
        var fila = "<tr><td>" + rangoFecha + "</td><td>" + dias + "</td><td>" + hora + "</td><td>" + persona + "</td></tr>";
        $("#horarios tbody").append(fila);
    }
  
    function obtenerDiasSeleccionados() {
        var diasSeleccionados = [];
        $("#diasSemana input[type='checkbox']:checked").each(function() {
            diasSeleccionados.push($(this).val());
        });
        return diasSeleccionados.join(",");
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

        var formData = new FormData();
        formData.append('programacion', getProgramacion());

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
    });
});