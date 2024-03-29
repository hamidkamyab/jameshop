  <!-- Slider -->
  <section class="slider position-relative vh-100">
      <div class="position-relative">
          <ul class="sliderUl border-warning m-0 p-0 d-flex position-relative">
              @foreach ($sliders as $key => $slider)
                  <li class="list-unstyled m-0 position-absolute vh-100 vw-100" id="slide-{{$key}}">
                      <img src="{{ $slider->media[0]->file->path }}" alt="" srcset="">
                  </li>
              @endforeach

          </ul>

          <div class="sliderOperationBox position-absolute">
              <ul class="list-unstyled sliderPaginateBox d-flex gap-2 d-flex align-items-center justify-content-center">
                  @foreach ($sliders as $key=>$slider)
                    <li class="sliderPaginateItem rounded-circle @if($key == 0) active @endif" id="sliderPaginateItem-{{$key}}"></li>
                  @endforeach
              </ul>
              <div class="sliderBtnBox d-flex justify-content-between gap-4">
                  <i class="prevSlide icon-arrow-right text-white text-shadow-dark" role="button"></i>
                  <i class="nextSlide icon-arrow-left text-white text-shadow-dark" role="button"></i>
              </div>

          </div>
      </div>
  </section>
  <!-- End Slider -->
