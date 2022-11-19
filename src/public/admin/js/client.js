$("#btn_back_to_edit").on("click", function (e) {
    e.preventDefault();

    let form = $("#input_form");
    form.attr("action", $(this).data("post-url"));
    form.submit();
});

$("#btn_back_to_edit").on("click", function (e) {
    e.preventDefault();
    var $input_form = $("#input_form");
    $input_form.attr("action", $(this).data("post-url"));
    $input_form.submit();
});

function delete_client_user(id, name) {
    // 確認ダイアログ用テキスト
    var confirm_txt = "";
    confirm_txt =
        "Bạn có chắc chắn muốn xoá thông tin nhân viên đại lý dưới không?\n\n";
    confirm_txt += id + " : " + name;
    // 論理削除処理
    if (confirm(confirm_txt)) {
        document.delete_form.submit();
    }
}
