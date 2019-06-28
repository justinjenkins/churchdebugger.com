$(function() {

    $("#seek-form").submit(function(event) {
        $("#seek-input").attr("readonly", "readonly").parent().addClass("is-large is-loading");
        $("#seek-submit-button").text("Finding").attr("disabled", "disabled");
    });

});