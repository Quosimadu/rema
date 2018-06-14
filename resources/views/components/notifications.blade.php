@php
    $messages = [
        'success' => session('success'),
        'danger' => session('error'),
        'warning' => session('warning'),
        'info' => session('info'),
    ];
    if (empty($messages['danger']) && session()->has('errors')) {
        $messages['danger'] = session('errors')->all();
    }
@endphp
@foreach ($messages as $notificationType => $message)
    @if (!empty($message))
        <div class="row">
            <div class="alert alert-{{ $notificationType }} alert-bordered">
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">x</span></button>
                @if(is_array($message))
                    <ul>
                    @foreach ($message as $m)
                        <li>{!! $m !!}</li>
                    @endforeach
                    </ul>
                @else
                    {!! $message !!}
                @endif
            </div>
        </div>
    @endif
@endforeach