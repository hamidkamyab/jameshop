@section('head')
    <link rel="stylesheet" href="{{ asset('css/dropzone.min.css') }}">
@endsection
<!-- Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">
                    @if (@$title)
                        {{ $title }}
                    @else
                        آپلود فایل
                    @endif
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- <form action="{{ $url }}" class="dropzone" id="dropzoneTag">
                    @csrf
                </form> --}}
                <div class="dropzone" id="dropzoneTag">
                    <div class="dz-message">
                        <div class="d-flex flex-column">
                            <i class="icon-upload m-1 fs-2"></i>
                            <span class="fs-5">فایل‌های خود را کشیده و اینجا رها کنید</span>
                            <span class="fs-5">یا اینجا کلیک کنید</span>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@section('footer')
    <script src="{{ asset('js/dropzone.min.js') }}"></script>
    <script>
        $("div#dropzoneTag").dropzone({
            addRemoveLinks: true,
            uploadMultiple: false,
            url: "{{ $url }}",
            sending: function(file, xhr, formData) {
                formData.append("_token", "{{ csrf_token() }}")
            },
            init: function() {
                this.on("success", (file, responseText) => {
                    $('#mediafile_id').val(responseText['mediafile_id']);
                    $('.brand_imgDiv > i').fadeOut(0);
                    $('.brand_imgDiv > img').attr('src', responseText['path'])
                    $('.brand_imgDiv > img').fadeIn(500);
                });
                this.on("removedfile", (file) => {
                    var response = file['xhr']['responseText'];
                    response = JSON.parse(response);
                    console.log(response['photo_id'])

                    // if (file.id) {
                    //     // ارسال درخواست حذف به کنترلر Laravel
                    //     axios.delete(`/file/${file.id}`)
                    //         .then(response => {
                    //             console.log(response.data.message);
                    //         })
                    //         .catch(error => {
                    //             console.error(error);
                    //         });
                    // }
                });
            }
        });
    </script>
@endsection
