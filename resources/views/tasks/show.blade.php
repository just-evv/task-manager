@extends('layouts.app')

@section('content')

    <h1 class="mb-5">{{ __('content.task.review') }}: {{ $task->name }}</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <p>{{ __('content.item.name') }}: {{ $task->name }}</p>
    <p>{{ __('content.item.status') }}: {{ $task->status->name }}</p>
    <p>{{ __('content.item.description') }}: {{ $task->description }}</p>
    <p>{{  __('content.item.assigned_to') }}: {{ $task->assignedUser->name }}</p>
    <p>{{ __('content.item.labels') }}:</p>
    <ul>
        @foreach($task->labels as $label)
            <li>{{ $label->name }}</li>
        @endforeach
    </ul>

@endsection
