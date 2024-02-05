@extends('admin.layouts.master')

@section('navigation')
    تنظیمات
@endsection
@section('content')
    <div class="bg-white col-12 p-3 border-start border-4 border-info right-box">
        @if (Session::has('opration_setting'))
            @include('admin.partials.Alert', [
                'msg' => [session('opration_setting')],
                'status' => 'success',
            ])
        @endif

        @if (Session::has('error_attr'))
            @include('admin.partials.Alert', ['msg' => [session('error_attr')], 'status' => 'danger'])
        @endif

        <form class="col-12 d-flex flex-wrap justify-center p-4" action="{{ route('settings.store') }}" method="POST">
            @csrf
            <div class="col-6 p-2">
                <label for="inputTitle" class="form-label">عنوان سایت</label>
                <input type="text" class="form-control" id="inputTitle" name="Setting_SiteTitle" value="{{@$setting['Setting_SiteTitle']}}">
            </div>
            <div class="col-6 p-2">
                <label for="inputKeywords" class="form-label">کلمات کلیدی</label>
                <input type="text" class="form-control" id="inputKeywords" name="Setting_Keywords" value="{{@$setting['Setting_Keywords']}}">
            </div>
            <div class="col-12 p-2">
                <label for="inputMetaDescription" class="form-label">توضیحات سایت (سئو)</label>
                <textarea class="form-control" id="inputMetaDescription" name="Setting_MetaDescription">{{@$setting['Setting_MetaDescription']}}</textarea>
            </div>
            <div class="col-12 d-flex align-items-center gap-3 p-2 ">
                <div class="form-check form-switch">
                    <label class="form-check-label" for="giftCheck">نمایش ویجت کارت هدیه</label>
                    <input class="form-check-input" type="checkbox" id="giftCheck" name="giftCheck" @if(@$setting['Setting_GiftCat']) checked @endif onchange="giftFunc()">
                </div>
                <div class="fs-6 fw-light text-secondary">|</div>
                <div class="col-6 d-flex align-items-center gap-1">
                    <div class="col-3">
                        <label class="form-check-label" for="inputCat">دسته کارت هدیه:</label>
                    </div>
                    <div class="col-6">
                        <select class="form-select searchSelect @if(!@$setting['Setting_GiftCat']) select-cl @endif" id="inputCat" name="Setting_GiftCat" @if(!@$setting['Setting_GiftCat']) disabled @endif  >
                            <option selected disabled value="choose">انتخاب کنید...</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if(@$setting['Setting_GiftCat'] == $category->id) selected @endif>
                                    {{ $category->title }}</option>
                                @if ($category->children)
                                    @include('admin.partials.CategoryChildren', [
                                        'categories' => $category->children,
                                        'level' => 1,
                                        'toltipTitle' => $category->title,
                                        'disableParent' => false,
                                        'selectedId' => @$setting['Setting_GiftCat']
                                    ])
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 p-2">
                <button type="submit" class="btn btn-primary">ثبت تنظیمات</button>
            </div>
        </form>

    </div>
@endsection
