@foreach (session('flash_notification', collect())->toArray() as $message)

    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        @switch($message['level'])
            @case('success')
                <div class="bg-green-100 border-l-4 border-green-400 p-4" role="alert">
                @break
            @case('warning')
                <div class="bg-red-100 border-l-4 border-red-400 p-4" role="alert">
                    @break
            @default
                        <div class="bg-blue-100 border-l-4 border-blue-400 p-4" role="alert">
        @endswitch

                @if ($message['important'])
                    <button type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-hidden="true"
                    >&times;</button>
                @endif

                        {!! $message['message'] !!}

            </div>
        @endif
        @endforeach

        {{ session()->forget('flash_notification') }}
