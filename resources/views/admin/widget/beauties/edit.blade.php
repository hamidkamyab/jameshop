@extends('admin.layouts.master')


@section('navigation')
    زیبایی و سلامت
@endsection

@section('content')
    <div class="col-9 bg-white p-3 border-start border-4 border-info right-box">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="row justify-content-center">
            <form class="row m-0 g-4" action="{{ route('beauties.update', $beauty->id) }}" method="post" id="formTarget">
                @csrf
                @method('PATCH')


                <div class="form-group col-6 mb-3">
                    <label for="inputTitle" class="form-label">عنوان</label>
                    <input type="text" id="inputTitle" name="title" class="form-control" value="{{$beauty->title}}" />
                </div>

                <div class="form-group col-6 mb-3">
                    <label for="inputLink" class="form-label">لینک</label>
                    <input type="text" id="inputLink" name="link" class="form-control vazir d-ltr"  value="{{$beauty->link}}" />
                </div>

                <div id="ImgBox" class="col-12 mb-3 @if(count($beauty->media) > 0) hidden @endif">
                    <div class="row">
                        <h6 class="text-muted">محل آپلود کاور شگفت آویز</h6>
                    </div>
                    @include('admin.partials.Upload')
                </div>

                @if(count($beauty->media) > 0)
                    <div id="amzCover" class="col-12 mb-3 coverBox">
                        <div class="row mb-2">
                            <h6 class="text-muted">کاور شگفت آویز</h6>
                        </div>
                        <div class="d-flex align-items-end gap-2">
                            <img src="{{$beauty->media[0]->file->path}}" >
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="CoverDel()" >
                                <i class="icon-trash" ></i>
                                <span>حذف کاور</span>
                            </button>
                        </div>

                    </div>
                @endif
                <input type="hidden" id="photos" name="photosId" value="{{@$beauty->media[0]->file_id}}">

            </form>
        </div>
    </div>

    <div class="col-3 left-box d-flex flex-wrap gap-3">
        <div class="justify-content-center bg-white py-3 ps-2 pe-3 border-start border-4 border-info w-100">
            <div class="col-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" onclick="sendForm('formTarget')">ثبت</button>
                <a href="{{ route('beauties.index') }}" class="btn btn-outline-danger">انصراف</a>
            </div>
        </div>
    </div>
@endsection

@section('head')

    <script>

        var token = "{{ csrf_token() }}";
        var type = "image";
        var folder = "beauty";
        var mim = "jpg,jpeg,png,gif";
        var thumbnail = "false";

        var max = 1; //maxFiles

        let photosId = [];

        let setOldVal = false;

        function up_success(file) {
            let resText = JSON.parse(file.xhr.responseText);
            photosId.push(resText.file_id);

            if (!setOldVal) {
                var elements = document.querySelectorAll('.dbSlide');
                elements.forEach(elem => {
                    photosId.push($(elem).attr('data-id'));
                })
                setOldVal = true
            }
            $('#photos').val(photosId);
        }

        function resultRemove(id) {
            photosId = photosId.filter(item => item !== id);
            $('#photos').val(photosId);
        }
    </script>

@endsection
