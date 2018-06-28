$(document).on("ready",function () {
    //FUNCIONAMIENTO DEL MODAL
    $("body").on("click ontouchend",".modalButton", function (event) {
        event.stopPropagation();
        event.preventDefault();
        $(".resultado").html("").addClass("hidden");
        $("#modalContent").html("<div class='loader_azul_muy_grande' style='margin: auto;display: block'></div>");
        //setea el tamaño del modal
        $(".modal-dialog").removeClass("modal-sm modal-lg").addClass($(this).attr("size"));
        if(typeof $(this).attr("size") !== typeof undefined && $(this).attr("size") !== false){
            if($(this).attr("size") == "modal-sm") $(".modal-body").css("padding","20px 0px");
        }
        //pide confirmacion si esta seteado
        var confirmar = true;
        if(typeof $(this).attr("confirm") !== typeof undefined && $(this).attr("confirm") !== false){
            confirmar = confirm("Esta seguro que borrar el item?");
        }
        $(".modal-header > h1, .modal-header > h2, .modal-header > h3").html($(this).attr("title"));
        $("#modal").modal("show");
        //carga en el modalContent la pagina.
        // LOS DATOS SE PASAN A TRAVES DE LA URL
        if(confirmar){
            $.ajax({
                url: $(this).attr("value"),
                type: "get",
                //data: data,
                processData: false,
                contentType: false,
            }).done (function (response){
                if(!response || response.length === 0){
                    $(".resultado").html("<span style='font-size: 16px;margin:auto' class='glyphicon glyphicon-ok' aria-hidden='true'></span> Accion realizada.");
                    setTimeout(function(){
                        $("#modal").modal("hide");
                        $(".resultado").html("").addClass("hidden");
                        //Si esta seteado el id del gridview lo recarga con el pjax
                        if ( typeof $("#id_gridview").html() !== "undefined"  )
                            $.pjax.reload({container:"#id_gridview"});
                        if(window.location.pathname == "/partido/fixture"){ window.location.reload(); }
                    }, 2000);
                }
                else{
                    $(".resultado").html("<span class='glyphicon glyphicon-cog' aria-hidden='true' style='padding-right: 10px'></span>"+response).css({"width":"90  %","text-align":"center"});
                    $("#modalContent").html(response);
                    /*setTimeout(function(){
                        $("#modal").modal("hide");
                        $("#modalContent").html("").addClass("hidden");
                        //Si esta seteado el id del gridview lo recarga con el pjax
                        if ( typeof $("#id_gridview").html() !== "undefined"  ){
                            $.pjax.reload({container:"#id_gridview"});
                        }
                    }, 2000);*/
                }
            }).fail(function (xhr, ajaxOptions, thrownError){
                $(".resultado").html("");
                console.log("LOG -> status: "+xhr.status+" thrownError: "+thrownError);
            });
            //.find("#modalContent").load($(this).attr("value"));
        }

        /*$('html body').animate({
            scrollTop: $("#modal").offset().top
        }, 2000);*/
    });

    //modal de las reglas
    $("body").on("click touchstart",".modalReglas", function () {
        $("#modalContent").html("<div class='loader_azul_muy_grande' style='margin: auto;display: block'></div>");
        var url = $(this).attr("value") + "?id_instancia="+$("#id_instancia").text();
        $(".modal-dialog").removeClass("modal-sm modal-lg").addClass($(this).attr("size"));
        $("#modal").modal("show").find("#modalContent").load(url);
        $(".modal-header > h1, .modal-header > h2, .modal-header > h3").html($(this).attr("title"));
        $(".modal-body").css("padding","20px");
    });

    //FUNCIONAMIENTO DEL formulario con AJAX
    $("body").on("beforeSubmit", "form#id_form", function () {
        var form = $(this);
        $(".resultado").removeClass("hidden").html("<div class='loader_tricolor_chico' style='margin: auto;display: block'></div>");

        $.ajax({
            url: form.attr("action"),
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
        }).done (function (response){
            if(!response || response.length === 0){
                $(".resultado").html("<span style='font-size: 16px;margin:auto' class='glyphicon glyphicon-ok' aria-hidden='true'></span> Accion realizada.");
                setTimeout(function(){
                    $("#modal").modal("hide");
                    $(".resultado").html("").addClass("hidden");
                    //Si esta seteado el id del gridview lo recarga con el pjax
                    if ( typeof $("#id_gridview").html() !== "undefined"  )
                        $.pjax.reload({container:"#id_gridview"});

                    if(window.location.pathname == "/partido/fixture"){ window.location.reload(); }
                }, 22000);
            }
            else{
                $(".resultado").html("<span class='glyphicon glyphicon-cog' aria-hidden='true' style='padding-right: 10px'></span>"+response).css({"width":"90  %","text-align":"center"});
                setTimeout(function(){
                    $("#modal").modal("hide");
                    $(".resultado").html("").addClass("hidden");
                    //Si esta seteado el id del gridview lo recarga con el pjax
                    if ( typeof $("#id_gridview").html() !== "undefined"  ) $.pjax.reload({container:"#id_gridview"});
                    //recargo la pagina segunda_fase despues de la prediccion
                    if(window.location.pathname == "/partido/segunda-fase"){ window.location.reload(); }
                }, 2000);
            }
        }).fail(function (xhr, ajaxOptions, thrownError){
            $(".resultado").html("");
            console.log("LOG -> status: "+xhr.status+" thrownError: "+thrownError);
        });
        return false;
    });


    setInterval(setHora, 60000);
})
$(window).on('load', function() {
    //fondo segunda fase
    /*if(window.location.pathname == "/partido/segunda-fase"){
        var imagen = document.getElementById("id_body");
        imagen.style.backgroundImage = "none";
        $(".container").eq(0).addClass("container-fluid").removeClass("container");
        $("body").css('background-image','none');
    }*/
});

function setHora() {
    $.ajax({
        url: '/site/hora',
        success: function(data) {
            $('.hora a').html(data);
        },
    });
}