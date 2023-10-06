    <div class="alert alert-{{ $status }} d-flex align-items-start justify-content-between m-0 fade show" role="alert">
        <div class="d-flex gap-2 align-items-start w-100">
            @if ($status == 'success')
                <i class="icon-ok"></i>
            @else
                <i class="icon-attention"></i>
            @endif
            <div class="d-flex flex-column">
                @foreach ($msg as $msgText)
                <p class="m-0 p-0">
                    {{ $msgText }}
                </p>
            @endforeach
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
