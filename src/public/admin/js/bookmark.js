$(function () {
    $("#bookmarkModal form input[name=name]").on("keyup", function () {
        if ($(this).val() === "") {
            $("#bookmarkModal #name-error").css("display", "block");
            $("#bookmarkModal button[type=submit]").attr("disabled", true);
        } else {
            $("#bookmarkModal #name-error").css("display", "none");
            $("#bookmarkModal button[type=submit]").attr("disabled", false);
        }
    });

    $("#bookmark-create-btn").on("click", function (e) {
        e.preventDefault();
        $("#bookmarkModal #name-error").css("display", "none");
        $("#bookmarkModal button[type=submit]").attr("disabled", false);
        $("#bookmarkModal form").attr("action", $(this).attr("href"));
        $("#bookmarkModal form input[name=name]").val($("title").text().trim());
        $("#bookmarkModal form input[name=link]").val(window.location);

        $("#bookmarkModal").modal("show");
    });
});
