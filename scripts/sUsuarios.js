var tabla;
var tablaPadres;
var tablaEntradaSalida;
var lista = 1;
var tipo = "";
var claveMatch = "";


//Función que se ejecuta al inicio
function init(){
    listar();
    listarPadres();
    mostrarform(2);
    $("#formulario").on("submit",function(e)
    {
        guardaryeditar(e);
    });
    limpiar();
    indicadores(1);
}

function indicadores(caso) {
    lista = caso;
    mostrarform(2);
    switch (caso) {
        case 0:
            listar();
            $("#padre").prop("class","d-none d-sm-inline-block btn btn-outline-warning");
            $("#maestro").prop("class","d-none d-sm-inline-block btn btn-outline-warning");
            $("#alumno").prop("class","d-none d-sm-inline-block btn btn-outline-warning");
            $("#administrador").prop("class","d-none d-sm-inline-block btn btn-warning");
            $("#divMatch").hide();
            $("#identificador").html("CURP");
            break;
        case 1:
            listar();
            $("#padre").prop("class","d-none d-sm-inline-block btn btn-outline-warning");
            $("#alumno").prop("class","d-none d-sm-inline-block btn btn-outline-warning");
            $("#administrador").prop("class","d-none d-sm-inline-block btn btn-outline-warning");
            $("#maestro").prop("class","d-none d-sm-inline-block btn btn-warning");
            $("#divMatch").hide();
            $("#identificador").html("Numero de control");
            break;
        case 2:
            listar();
            $("#maestro").prop("class","d-none d-sm-inline-block btn btn-outline-warning");
            $("#alumno").prop("class","d-none d-sm-inline-block btn btn-outline-warning");
            $("#padre").prop("class","d-none d-sm-inline-block btn btn-warning");
            $("#administrador").prop("class","d-none d-sm-inline-block btn btn-outline-warning");
            $("#identificador").html("CURP");
            break;
        case 3:
            listar();
            $("#padre").prop("class","d-none d-sm-inline-block btn btn-outline-warning");
            $("#maestro").prop("class","d-none d-sm-inline-block btn btn-outline-warning");
            $("#alumno").prop("class","d-none d-sm-inline-block btn btn-warning");
            $("#administrador").prop("class","d-none d-sm-inline-block btn btn-outline-warning");
            $("#identificador").html("Numero de control");
            break;
    }
}

function limpiar() {
    $("#nombre").val("");
    $("#control").val("");
    $("#id").val("");
    $("#nickname").val("");
    $("#email").val("");
    $("#contrasenia").val("");
    //$("#fotoActualMuestra").val("");
    $("#fotoActual").val("");
    $("#imagen").val("");
    $("#imagenMostrar").hide();
    $("#NameMatch").val("");
}

function guardaryeditar(e) {
    switch (lista) {
        case 0://administrador
            tipo = 'Administrador';
            break;
        case 1://institucion
            tipo = 'Maestro';
            break;
        case 2://psicologo
            tipo = 'Padre';
            break;
        case 3://alumno
            tipo = 'Alumno';
            break;
    }
    e.preventDefault();
    $("#btnGuardar").prop("disabled",true);
    var formData = new FormData($('#formulario')[0]);
    $.ajax({
        url: '../ajax/aUsuarios.php?op=guardaryeditar&tipo='+tipo+'&caso='+lista,
        type:'POST',
        data: formData,
        contentType:false,
        processData:false,

        success: function(datos)
        {
            bootbox.alert(datos);
            mostrarform(2);
            tabla.ajax.reload();
        }
    });
    $("#btnGuardar").prop("disabled",false);
    limpiar();
}

//Función Listar
function listar(){
    tabla=$('#tbUsuarios').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdf'
            ],
            "ajax":
                {
                    url: '../ajax/aUsuarios.php?op=listarUsuario&caso='+lista,
                    type : "get",
                    dataType : "json",
                    error: function(e){
                        console.log(e.responseText);
                    }
                },
            "bDestroy": true,
            "iDisplayLength": 5, //Pagninacion
            "order": [[0, "desc"]] //ordenar (columna orden)
        }).DataTable();
}

function listarPadres(){
    tablaPadres=$('#tbUsuariosMatchPiscologo').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdf'
            ],
            "ajax":
                {
                    url: '../ajax/aUsuarios.php?op=listarPadre',
                    type : "get",
                    dataType : "json",
                    error: function(e){
                        console.log(e.responseText);
                    }
                },
            "bDestroy": true,
            "iDisplayLength": 5, //Pagninacion
            "order": [[0, "desc"]] //ordenar (columna orden)
        }).DataTable();
}


function mostrarform(flag)
{
    switch (flag){
        case 1:
            $("#formularioVista").show();
            $("#listadoVista").hide();
            $("#btnCancelar").prop("disabled",false);
            $("#btnAgregar").prop("disabled",true);
            $("#btnCancelar").show();
            $("#btnAgregar").hide();
            $("#listadoEntradasSalidas").hide();
            switch (lista) {
                case 3://Alumno
                    $("#listadoMatchInstitucion").hide();
                    $("#listadoMatchPsicologo").show();
                    $("#MostrarMatch").html("Nombre del padre");
                    $("#divMatch").show();
                    break;
            }
            limpiar();
            break;
        case 2:
            $("#listadoEntradasSalidas").hide();
            $("#listadoMatchInstitucion").hide();
            $("#listadoMatchPsicologo").hide();
            $("#formularioVista").hide();
            $("#listadoVista").show();
            $("#btnCancelar").prop("disabled",true);
            $("#btnAgregar").prop("disabled",false);
            $("#btnCancelar").hide();
            $("#btnAgregar").show();
            limpiar();
            break;
        case 3:
            $("#listadoEntradasSalidas").show();
            $("#listadoMatchInstitucion").hide();
            $("#listadoMatchPsicologo").hide();
            $("#formularioVista").hide();
            $("#listadoVista").hide();
            $("#btnCancelar").prop("disabled",false);
            $("#btnAgregar").prop("disabled",false);
            $("#btnCancelar").show();
            $("#btnAgregar").hide();
            limpiar();
            break;
    }
}


function desactivar(id) {
    bootbox.confirm("¿Está seguro de desactivar el usuario?", function (result){
        if (result){
            $.post("../ajax/aUsuarios.php?op=desactivar",{id : id}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            } );
        }
    })
}

function activar(id) {
    bootbox.confirm("¿Está seguro de activar el usuario?", function (result){
        if (result){
            $.post("../ajax/aUsuarios.php?op=activar",{id : id}, function (e) {
                bootbox.alert(e);
                tabla.ajax.reload();
            } );
        }
    })
}

function mostrar(id) {
    $.post("../ajax/aUsuarios.php?op=mostrar",{id : id}, function (data, status) {
        data = JSON.parse(data);
        $("#id").val(data.clave);
        $("#nombre").val(data.nombre);
        $("#nickname").val(data.nickname);
        $("#control").val(data.numero_c);
        $("#email").val(data.email);
        $("#contrasenia").val(data.contrasenia);
        $("#imagenMostrar").show();
        //alert('<img alt="" src="../vistas/files/'+data.imagen+'" class="img-profile rounded-circle" width="100px" height="100px">');
        $("#imagenMostrar").attr("src","../vistas/files/"+data.imagen);
        $("#fotoActual").val(data.imagen);
    });
    switch (lista) {
        case 3://Alumno
            $.post("../ajax/aUsuarios.php?op=mostrarNombrePadre",{id : id}, function (data, status) {
                data = JSON.parse(data);
                $("#match").val(data.clavePadre);
                $("#NameMatch").val(data.nombre);
            });
            break;
    }
    mostrarform(1);
}
function registro(clave) {
    mostrarform(3);
    tablaEntradaSalida=$('#tbEntradasSalidas').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdf'
            ],
            "ajax":
                {
                    url: '../ajax/aUsuarios.php?op=listarEntradasSalidas&clave='+clave,
                    type : "get",
                    dataType : "json",
                    error: function(e){
                        console.log(e.responseText);
                    }
                },
            "bDestroy": true,
            "iDisplayLength": 5, //Pagninacion
            "order": [[0, "desc"]] //ordenar (columna orden)
        }).DataTable();

}

function agregarJoin(id) {
    $("#match").val(id);
    $.post("../ajax/aUsuarios.php?op=obtenerNombreMatch",{id : id}, function (e) {
        $("#NameMatch").val(e);
    } );
}


init();
