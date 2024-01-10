@if ($errors->any())
    <div class="alert alert-dismissible alert-danger">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (Session::has('message'))

    <div class="alert alert-dismissible {{ Session::get('alert-class', 'alert-success') }}" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
        @if (is_array(Session::get('message')))
            <ul>
                @foreach (Session::get('message') as $row)
                    <li>{!! $row !!}</li>
                @endforeach
            </ul>
        @else
            {!! Session::get('message') !!}
        @endif
    </div>
@endif

@if (Session::has('success'))
    <div class="alert alert-dismissible {{ Session::get('alert-class', 'alert-success') }}" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
        @if (is_array(Session::get('success')))
            <ul>
                @foreach (Session::get('success') as $row)
                    <li>{!! $row !!}</li>
                @endforeach
            </ul>
        @else
            {!! Session::get('success') !!}
        @endif
    </div>
@endif
