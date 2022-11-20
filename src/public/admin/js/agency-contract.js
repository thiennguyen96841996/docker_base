function addMonths(date, numOfMonths) {
    if (numOfMonths == 37) {
        return '';
    }
    date = new Date(date);
    date.setMonth(date.getMonth() + parseInt(numOfMonths));

    return date.toISOString().split('T')[0];
}

$('#contract_sign_date').on('change', function () {
    var term = $('#contract_term').val();
    if (term != '') {
        $('#contract_cancel_date').val(addMonths($(this).val(), term));
    } else {
        $('#contract_term').on('change', function () {
            $('#contract_cancel_date').val(addMonths($('#contract_sign_date').val(), $(this).val()));
        });
    }
});

$('#contract_term').on('change', function () {
    var date = $('#contract_sign_date').val();
    if (date != '') {
        $('#contract_cancel_date').val(addMonths(date, $(this).val()));
    }
});

/**
 * agency contract delete
 * @param {String} agency_name
 * @param {String} agency_contract_id
 */
function delete_agency_contract(agency_name, agency_contract_id) {
    // 確認ダイアログ用テキスト
    var confirm_txt = '';
    confirm_txt  = 'Bạn có chắc chắn muốn xoá thông tin hợp đồng dưới không?\n\n';
    confirm_txt += agency_name + ' : ' + agency_contract_id;
    // 論理削除処理
    if(confirm(confirm_txt)) {
        document.delete_contract_form.submit();
    }
}

/**
 * contract cancel
 * @param {String} agency_id
 * @param {String} agency_name
 */
function contract_cancel(agency_name, agency_contract_id) {
    // 確認ダイアログ用テキスト
    var confirm_txt = '';
    confirm_txt  = 'Bạn có chắc chắn muốn huỷ hợp đồng với đại lý dưới không?\n\n';
    confirm_txt += agency_name + ' : ' + agency_contract_id;
    // 論理削除処理
    if(confirm(confirm_txt)) {
        document.contract_cancel_form.submit();
    }
}
