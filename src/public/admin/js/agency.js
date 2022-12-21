/**
 * agency delete
 * @param {String} agency_id
 * @param {String} agency_name
 */
function delete_agency(agency_id, agency_name) {
    $('.modal-title').text('Xác nhận xoá');
    $('#confirm-title').text('Bạn có chắc chắn muốn xoá thông tin đại lý bên dưới không?');
    $('#confirm-content').text(agency_id + ':' + agency_name);
    $('#confirm-modal').modal('show');

    var $delete_form = $("#agency_delete_form");
    $('#button-confirm').on('click', function () {
        $delete_form.submit();
    });
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

// csv download
$('#btn_agency_csv').on('click', function(){
    $('#search_form').attr('action', '/agency/csv-download').submit();
});

// button search
$('#btn_search').on('click', function(){
    $('#search_form').attr('action', '/agency').submit();
});
