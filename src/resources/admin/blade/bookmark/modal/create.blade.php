<div class="modal fade" id="bookmarkModal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" tabindex="-1" aria-modal="true">
    <div class="modal-dialog">
        <form method="POST" accept-charset="utf-8">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tạo bookmark</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên</label>
                        <input type="text" name="name" class="form-control">
                        <small id="name-error" style="color:red;display:none">Hãy nhập mục Tên</small>
                    </div>
                    <div class="mb-3">
                        <label for="link" class="form-label">Link</label>
                        <input type="text" name="link" class="form-control" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                    <button type="submit" class="btn btn-primary">Tạo bookmark</button>
                </div>
            </div>
        </form>
    </div>
</div>
