$(document).on("ready",function () {
    $("body").on("beforeSubmit", "#id_form_chat", function () {
        var form = $(this);
        //$(".resultadoChat").removeClass("hidden").html("<div class='loader_tricolor_chico' style='margin: auto;display: block'></div>");
        $.ajax({
            url: form.attr("action"),
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
        }).done(function (response) {
            $("#wrap_chat").html(response);
            //document.getElementById("chat-mensaje").focus();
            //$(".resultadoChat").html("");
            scrolldownChat();
        }).fail(function (xhr, ajaxOptions, thrownError) {
            //$(".resultadoChat").html("");
            console.log("LOG -> status: " + xhr.status + " thrownError: " + thrownError);
        });
        return false;
    });

    function scrolldownChat() {
        document.getElementById("inner_chat").scrollTop = document.getElementById("inner_chat").scrollHeight + 10;
    }
    scrolldownChat();
    setInterval(function(){
        // this will run after every 10 seconds
        if($("#chat-mensaje").val() == ""){
            $("#id_form_chat").submit();
        }
    }, 5000);
});