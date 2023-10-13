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
                <div class="dropzone" id="dropzoneTag"></div>
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
                    $('#photo_id').val(responseText['photo_id']);
                    $('.brand_imgDiv > i').fadeOut(0);
                    $('.brand_imgDiv > img').attr('src',responseText['path'])
                    $('.brand_imgDiv > img').fadeIn(500);
                });
            }
        });
    </script>
@endsection
