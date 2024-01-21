<link rel="stylesheet" href="{{ asset('css/dropzone.min.css') }}">
<div class="border border-1 border-gray-500 dropzone" id="dropzoneTag">
    <div class="dz-message">
        <div class="d-flex flex-column">
            <i class="icon-upload m-1 fs-2"></i>
            <span class="fs-5">فایل خود را کشیده و اینجا رها کنید</span>
            <span class="fs-5">یا اینجا کلیک کنید</span>
        </div>

    </div>
</div>
<script src="{{ asset('js/dropzone.min.js') }}"></script>
<script src="{{ asset('js/ajax.js') }}"></script>
<script>
    Dropzone.autoDiscover = false;
    const dateTime = new Date();

    var c = 0;

    $("div#dropzoneTag").dropzone({
            addRemoveLinks: true,
            uploadMultiple: false,
            maxFiles: max,
            uploadActive: true,
            url: "{{ route('files.upload') }}",
            sending: function(file, xhr, formData) {
                formData.append("_token", token)
                formData.append("type", type)
                formData.append("folder", folder)
                formData.append("mimesFile", mim)
                formData.append("thumbnail", thumbnail)
            },
            init: function() {
                this.on("success", (file, responseText) => {
                    up_success(file)
                });
                this.on("error", function(file, errorText) {
                    $('.uploadError').fadeIn(1500);
                    if (errorText instanceof Object) {
                        $('.toast .toast-body').text(errorText.message);
                    } else {
                        $('.toast .toast-body').text(errorText);
                    }
                    $('.toast').toast('show')
                });
                this.on("removedfile", async (file, responseText) => {
                    if (file['xhr']) {
                        var response = JSON.parse(file['xhr']['responseText']);
                        const id = response['file_id'];
                        var formData = new FormData()
                        formData.append("_token", "{{ csrf_token() }}");
                        formData.append("id", id);

                        if (id) {
                            const response = await fetch("{{ route('files.remove') }}", {
                                method: "POST",
                                body: formData
                            })
                            const result = await response.json();
                            if (result['status'] == 'success') {
                                resultRemove(id)
                            }
                        }
                    }
                });
            }
        });
</script>
