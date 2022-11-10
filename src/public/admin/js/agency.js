/**
 * agency delete
 * @param {String} agency_id
 * @param {String} agency_name
 */
function delete_agency(agency_id, agency_name) {
    // 確認ダイアログ用テキスト
    var confirm_txt = "";
    confirm_txt =
        "Bạn có chắc chắn muốn xoá thông tin đại lý bên dưới không?\n\n";
    confirm_txt += "ID đại lý: " + agency_id + "\n";
    confirm_txt += "Tên đại lý: " + agency_name;
    // 論理削除処理
    if (confirm(confirm_txt)) {
        document.delete_form.submit();
    }
}

// btn_back_to_create
$("#btn_back_to_create").on("click", function (e) {
    e.preventDefault();
    var $input_form = $("#input_form");
    $input_form.attr("action", $(this).data("post-url"));
    $input_form.submit();
});

// btn_back_to_edit
$("#btn_back_to_edit").on("click", function (e) {
    e.preventDefault();
    var $input_form = $("#input_form");
    $input_form.attr("action", $(this).data("post-url"));
    $input_form.submit();
});
