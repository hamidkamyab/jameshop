@extends('admin.layouts.master')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/monolith.min.css') }}">
@endsection
@section('navigation')
ویرایش رنگ بندی محصولات
@endsection

@section('content')
    <div class="col-9 bg-white p-3 pb-5 border-start border-4 border-info right-box">
        @if (count($errors) > 0)
            @include('admin.partials.Alert', ['msg' => $errors->all(), 'status' => 'danger'])
        @endif
        <div class="row justify-content-center">
            <form class="row m-0 g-4" action="{{ route('colors.update', $color->id) }}" method="post" id="formTarget">
                @csrf
                @method('PATCH')
                <div class="col-12">
                    <label for="inputName" class="form-label">نام</label>
                    <input type="text" class="form-control" id="inputName" name="name" placeholder="نام رنگ..."
                        value="{{ $color->name }}">
                </div>
                <div class="col-12">
                    <label class="form-label">کد رنگ</label>
                    <input type="hidden" value="{{ $color->code }}" name="code" class="vazir" id="HexCode">
                    <div class="color-picker"></div>
                </div>


            </form>
        </div>
    </div>
    <div class="col-3 bg-white p-2 pe-3 border-start border-4 border-info left-box">
        <div class="row justify-content-center">
            <div class="col-12 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary"  onclick="sendForm('formTarget')">ویرایش رنگ</button>
                <a href="{{ route('colors.index') }}" class="btn btn-outline-danger">انصراف</a>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{ asset('js/pickr.min.js') }}"></script>
    <script>
        const pickr = Pickr.create({
            el: '.color-picker',
            theme: 'monolith', // or 'monolith', or 'nano'
            default: '{{ $color->code }}',
            swatches: [
                'rgba(244, 67, 54, 1)',
                'rgba(233, 30, 99, 0.95)',
                'rgba(156, 39, 176, 0.9)',
                'rgba(103, 58, 183, 0.85)',
                'rgba(63, 81, 181, 0.8)',
                'rgba(33, 150, 243, 0.75)',
                'rgba(3, 169, 244, 0.7)',
                'rgba(0, 188, 212, 0.7)',
                'rgba(0, 150, 136, 0.75)',
                'rgba(76, 175, 80, 0.8)',
                'rgba(139, 195, 74, 0.85)',
                'rgba(205, 220, 57, 0.9)',
                'rgba(255, 235, 59, 0.95)',
                'rgba(255, 193, 7, 1)'
            ],
            components: {

                // Main components
                preview: true,
                opacity: true,
                hue: true,

                // Input / output Options
                interaction: {
                    hex: true,
                    input: true,
                    clear: true,
                    save: true
                }
            }
        });
        pickr.on('save', (color) => {
            const hexColor = color.toHEXA().toString();
            document.getElementById('HexCode').value = hexColor;
        });
    </script>
@endsection
