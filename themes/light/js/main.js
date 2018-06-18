$(document).on("ready",function () {
    //FUNCIONAMIENTO DEL MODAL
    $("body").on("click ontouchend",".modalButton", function (event) {
        event.stopPropagation();
        event.preventDefault();
        $(".resultado").html("").addClass("hidden");
        $("#modalContent").html("<div class='loader_azul_muy_grande' style='margin: auto;display: block'></div>");
        $(".modal-dialog").removeClass("modal-sm modal-lg").addClass($(this).attr("size"));
        if(typeof $(this).attr("size") !== typeof undefined && $(this).attr("size") !== false){
            if($(this).attr("size") == "modal-sm") $(".modal-body").css("padding","20px 0px");
        }
        $("#modal").modal("show").find("#modalContent").load($(this).attr("value"));
        $(".modal-header > h1, .modal-header > h2, .modal-header > h3").html($(this).attr("title"));
        /*$('html body').animate({
            scrollTop: $("#modal").offset().top
        }, 2000);*/
    });

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
                $(".resultado").html("<span style='font-size: 16px;margin:auto' class='glyphicon glyphicon-ok' aria-hidden='true'></span> Prediccion realizada.");
                setTimeout(function(){
                    $("#modal").modal("hide");
                    $(".resultado").html("").addClass("hidden");
                    //Si esta seteado el id del gridview lo recarga con el pjax
                    if ( typeof $("#id_gridview").html() !== "undefined" ){
                        $.pjax.reload({container:"#id_gridview"});
                    }
                    if(window.location.pathname == "/partido/fixture"){ window.location.reload(); }
                }, 1000);
            }
            else{
                $(".resultado").html("<span class='glyphicon glyphicon-cog' aria-hidden='true' style='padding-right: 10px'></span>"+response).css({"width":"100%","text-align":"center"});
                setTimeout(function(){
                    $("#modal").modal("hide");
                    $(".resultado").html("").addClass("hidden");
                    //Si esta seteado el id del gridview lo recarga con el pjax
                    if ( typeof $("#id_gridview").html() !== "undefined" ){
                        $.pjax.reload({container:"#id_gridview"});
                    }
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
    if(window.location.pathname == "/partido/segunda-fase"){
        var imagen = document.getElementById("id_body");
        imagen.style.backgroundImage = "none";
//        $(".container").eq(0).addClass("container-fluid").removeClass("container");
        //$("body").css('background-image','none');
    }
});

function setHora() {
    $.ajax({
        url: '/site/hora',
        success: function(data) {
            $('.hora a').html(data);
        },
    });
}