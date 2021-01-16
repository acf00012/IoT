
function init(){
    $.post("../ajax/aUsuarios.php?op=salir", function (e) {
    } );

    $("#loginForm").on('submit',function(e)
    {
        e.preventDefault();
        email=$("#email").val();
        password=$("#password").val();
        $.post("../ajax/aUsuarios.php?op=verificar",
            {"email":email,"password":password},
            function(data)
            {
                if (data != "null")
                {
                    $(location).attr("href","principal.php");
                }
                else
                {
                    alert("Usuario y/o Password incorrectos");
                }
            });
    });
}

function limpiar(){
    $("#email").val("");
    $("#password").val("");
}


init();
