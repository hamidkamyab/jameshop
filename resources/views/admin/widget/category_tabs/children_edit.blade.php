@extends('admin.layouts.master')


@section('navigation')
    ویرایش زیرمجموعه {{$catTab->title}}
@endsection

@section('content')
    <div class="col-9 bg-white p-3 border-start border-4 border-info right-box">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="row justify-content-center">
            <form class="row m-0 g-4" action="{{ route('category_tabs.children.update', $catTab->id) }}" method="post" id="formTarget">
                @csrf
                @method('PATCH')


                <input type="hidden" id="photos" name="photosId" value="{{@$catTab->media[0]->file_id}}">

                <div class="form-group col-6 mb-3">
                    <label for="inputTitle" class="form-label">عنوان</label>
                    <input type="text" id="inputTitle" name="title" class="form-control BYekan" placeholder="عنوان برگه دسته بندی..."
                    value="{{ $catTab->title }}" />
                </div>

                <div class="col-6">
                    <label for="inputParent" class="form-label">دسته بندی</label>
                    <select class="form-select searchSelect mb-4" id="inputParent" name="category_id"
                        data-id="categoriesList">
                        <option selected disabled value="choose">انتخاب کنید...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if($catTab->category_id == $category->id) selected @endif>
                                {{ $category->title }}</option>
                            @if ($category->children)
                                @include('admin.partials.CategoryChildren', [
                                    'categories' => $category->children,
                                    'level' => 1,
                                    'toltipTitle' => $category->title,
                                    'disableParent' => false,
                                    'selectedId' => $catTab->category_id
                                ])
                            @endif
                        @endforeach
                    </select>
                </div>


                <div id="ImgBox" class="col-12 mb-3 @if(count($catTab->media) > 0) hidden @endif">
                    <div class="row">
                        <h6 class="text-muted">محل آپلود کاور</h6>
                    </div>
                    @include('admin.partials.Upload')
                </div>

                @if(count($catTab->media) > 0)
                    <div id="CT-Cover" class="col-12 mb-3 coverBox">
                        <div class="row mb-2">
                            <h6 class="text-muted">کاور زیر برگه {{$catTab->title}}</h6>
                        </div>
                        <div class="col-12 d-flex align-items-end gap-2">
                            <div class="col-10">
                                <img src="{{$catTab->media[0]->file->path}}" >
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="CoverDel()" >
                                    <i class="icon-trash" ></i>
                                    <span>حذف کاور</span>
                                </button>
                            </div>
                        </div>

                    </div>
                @endif
            </form>
        </div>
    </div>

    <div class="col-3 left-box d-flex flex-wrap gap-3">
        <div class="justify-content-center bg-white py-3 ps-2 pe-3 border-start border-4 border-info w-100">
            <div class="col-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" onclick="sendForm('formTarget')">ثبت</button>
                <a href="{{ route('category_tabs.index') }}" class="btn btn-outline-danger">انصراف</a>
            </div>
        </div>
    </div>
@endsection

@section('head')

    <script>

        var token = "{{ csrf_token() }}";
        var type = "image";
        var folder = "cat_tab";
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
