﻿@section('head')
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
                <div class="alert alert-danger uploadError" role="alert">
                    <div class=" d-flex align-items-center justify-content-between">
                        <div class="d-flex gap-2 align-items-center">
                            <i class="icon-attention"></i>
                            <p class="p-0 m-0 errorBody"></p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
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
        // const url = "{{ $upload }}";
        // const _token = "{{ csrf_token() }}";
        // const type = "{{ $type }}";
        // const removeRoute = "{{ route('mediafiles.remove') }}";

        /***********Modal Upload************* */
        $("div#dropzoneTag").dropzone({
            addRemoveLinks: true,
            uploadMultiple: false,
            url: "{{ $upload }}",
            sending: function(file, xhr, formData) {
                formData.append("_token", "{{ csrf_token() }}")
                formData.append("type", "{{ $type }}")
                formData.append("mimesFile", "jpg,jpeg,png")
            },
            init: function() {
                this.on("success", (file, responseText) => {
                    $('#mediafile_id').val(responseText['mediafile_id']);
                    $('.mediaFileBox > i').fadeOut(0);
                    $('#mediaFileImg').attr('src', responseText['path'])
                    $('#mediafile_path').val(responseText['path'])
                    $('#mediaFileImg').fadeIn(500);
                });
                this.on("error", function(file, responseText) {
                    $('.uploadError').fadeIn(1500);
                    $('.uploadError .errorBody').text(responseText['errors']['file']);

                });
                this.on("removedfile", async (file, responseText) => {

                    var response = JSON.parse(file['xhr']['responseText']);
                    var formData = new FormData()
                    formData.append("_token", _token);
                    formData.append("id", response['mediafile_id']);

                    if (response['mediafile_id']) {
                        await fetch("{{ route('mediafiles.remove') }}", {
                            method: "POST",
                            body: formData
                        })
                    }
                });
            }
        });
        /*************************/
    </script>
@endsection
