<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            @if(@$title)
              {{$title}}
            @else
                آپلود فایل
            @endif
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{$url}}" class="dropzone" id="dropzoneTag">
                @csrf
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    let myDropzone = new Dropzone("#dropzoneTag", {
        maxFilesize: 2, // حداکثر اندازه فایل (مگابایت)
        acceptedFiles: ".avi", // نوع‌های مجاز فایل
        paramName: "file", // نام فیلد برای ارسال فایل
        uploadMultiple: false, // امکان آپلود چند فایل به صورت همزمان غیرفعال باشد
        addRemoveLinks: true, // اضافه کردن لینک حذف فایل
        // تنظیمات دیگر
        init: function() {
            this.on("success", function(file, response) {
                // عملیات موفقیت‌آمیز پس از آپلود فایل
                console.log(response);
            });
        },
    });
</script>
