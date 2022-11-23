/**
 * agency delete
 * @param {String} customer_id
 * @param {String} customer_name
 */
 function delete_customer_user(customer_id, customer_name) {
    // 確認ダイアログ用テキスト
    var confirm_txt = '';
    confirm_txt  = 'Bạn có chắc chắn muốn xoá thông tin khách hàng dưới không?\n\n';
    confirm_txt += "ID khách hàng: " + customer_id + "\n";
    confirm_txt += "Tên khách hàng: " + customer_name;
    // 論理削除処理
    if(confirm(confirm_txt)) {
        document.delete_form.submit();
    }
}

// btn_back_to_create
$('#btn_back_to_create').on('click', function(e) {
    e.preventDefault();
    var $input_form = $('#input_form');
    $input_form.attr('action', $(this).data('post-url'));
    $input_form.submit();
});

// btn_back_to_edit
$('#btn_back_to_edit').on('click', function(e) {
    e.preventDefault();
    var $input_form = $('#input_form');
    $input_form.attr('action', $(this).data('post-url'));
    $input_form.submit();
});
