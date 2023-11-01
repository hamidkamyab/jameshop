<!-- Modal -->
<div class="modal fade" id="AttributeModal" tabindex="-1" aria-labelledby="AttributeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="AttributeModalLabel">ویژگی های دسته بندی</h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body position-relative">
                <div id="loading" class="position-absolute">
                    <div class="d-flex justify-content-center align-items-center flex-column gap-1">
                        <span class="icon-spin1 animate-spin text-primary fs-3"></span>
                        <span class="text-primary">لطفا منتظر بمانید...</span>
                    </div>
                </div>
                <table id="attrTable" class="table table-sm">
                    <thead>
                        <tr>
                            <th class="fs-6 fw-normal">عنوان ویژگی</th>
                            <th class="fs-6  fw-normal text-center">حذف</th>
                        </tr>
                    </thead>
                    <tbody id="attrTbody" >

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    urlAttrDestroy = "{{route('categories.attributes_destroy',['attrID','catID'])}}";
</script>
