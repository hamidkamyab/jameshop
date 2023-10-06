    <div class="alert alert-{{ $status }} d-flex align-items-center justify-content-between m-0 fade show" role="alert">
        <div class="d-flex gap-2 align-items-center">
            @if ($status == 'success')
                <i class="icon-ok"></i>
            @else
                <i class="icon-attention"></i>
            @endif
            <p class="m-0 p-0">
                {{ $msg }}
            </p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
