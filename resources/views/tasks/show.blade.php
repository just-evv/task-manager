@extends('layouts.app')

@section('content')

    <h1 class="text-5xl font-semibold mb-5">{{ __('content.task.review') }}: {{ $task->name }}</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        <p><span class="font-medium">{{ __('content.item.name') }}:</span> {{ $task->name }}</p>
        <p><span class="font-black">{{ __('content.item.status') }}:</span> {{ $task->status->name }}</p>
        <p><span class="font-black">{{ __('content.item.description') }}:</span> {{ $task->description }}</p>
        <p><span class="font-black">{{  __('content.item.assigned_to') }}:</span> {{ $task->assignedUser->name ?? ''}}</p>
    @if ($task->labels->isNotEmpty())
            <p><span class="font-black">{{ __('content.item.labels') }}:</span> </p>
        <div>
            @foreach($task->labels as $label)
                <div class="text-xs inline-flex items-center font-bold leading-sm uppercase px-3 py-1 bg-blue-200 text-blue-700 rounded-full">
                    {{ $label->name }}
                </div>
            @endforeach
        </div>
    @endif
@endsection
