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
    $('.modal-title').text('Xác nhận xoá');
    $('#confirm-title').text('Bạn có chắc chắn muốn xoá hợp đồng với đại lý ' + agency_name + ' không?');
    $('#confirm-content').text('ID: ' + agency_contract_id);
    $('#confirm-modal').modal('show');

    var $delete_form = $("#agency_contract_delete_form");
    $('#button-confirm').on('click', function () {
        $delete_form.submit();
    });
}

/**
 * contract cancel
 * @param {String} agency_id
 * @param {String} agency_name
 */
function contract_cancel(agency_name, agency_contract_id) {
    $('.modal-title').text('Xác nhận huỷ');
    $('#confirm-title').text('Bạn có chắc chắn muốn huỷ hợp đồng với đại lý ' + agency_name + ' không?');
    $('#confirm-content').text('Hợp đồng : ' + agency_contract_id);
    $('#confirm-modal').modal('show');

    var $delete_form = $("#agency_contract_cancel_form");
    $('#button-confirm').on('click', function () {
        $delete_form.submit();
    });
}
