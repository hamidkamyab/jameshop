/***********Modal Upload************* */
$("div#dropzoneTag").dropzone({
    addRemoveLinks: true,
    uploadMultiple: false,
    url: url,
    sending: function(file, xhr, formData) {
        formData.append("_token", _token)
        formData.append("type", type)
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
        this.on("removedfile", async(file, responseText) => {

            var response = JSON.parse(file['xhr']['responseText']);
            var formData = new FormData()
            formData.append("_token", _token);
            formData.append("id", response['mediafile_id']);

            if (response['mediafile_id']) {
                await fetch(removeRoute, {
                    method: "POST",
                    body: formData
                })
            }
        });
    }
});
/*************************/


/***********Brand Image************* */

var tag = document.getElementById("deleteBrandImg");
tag.addEventListener('click', async() => {
        var formData = new FormData()
        formData.append("_token", _token);
        formData.append("id", $('#mediafile_id').val());
        if ($('#mediafile_id').val()) {
            var response = await fetch(removeRoute, {
                method: "POST",
                body: formData
            })
            result = await response.json();
            if (result.status == 'success') {
                $('#mediafile_id').val("");
                $('#mediaFileImg').fadeOut(0);
                $('#mediaFileImg').attr('src', "")
                $('#mediafile_path').val("")
                $('.mediaFileBox > i').fadeIn(500);
                $('#deleteBrandImg').fadeOut(250)
                $('#uploadModalBtn').removeClass('disabled')
            }
        }
    })
    /*************************/