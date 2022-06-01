@extends('layouts.app')

@section('content')

    <h1 class="mb-5">{{ __('Task review') }}: {{ $task->name }}</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <p>{{ __('Name') }}: {{ $task->name }}</p>
    <p>{{ __('Status') }}: {{ $task->status->name }}</p>
    <p>{{ __('Description') }}: {{ $task->description }}</p>
    <p>{{ __('Label') }}:</p>
    <ul>
        @foreach($task->labels as $label)
            <li>{{ $label->name }}</li>
        @endforeach
    </ul>

@endsection
