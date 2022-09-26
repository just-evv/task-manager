@extends('layouts.app')

@section('content')
    @include('flash::message')

    <h1 class="text-5xl font-semibold mb-5">
        {{__('content.task.tasks')}}
    </h1>

    <div class="w-full flex items-center">
            <!-- Form -->
        {{ Form::open(['route' => 'tasks.index', 'method' => 'GET']) }}

        <div class="flex">

            <div>
                    {{ Form::select('filter[status_id]', $statuses , old('filter[status_id]'), ['placeholder' =>  __('content.item.status'), 'class' => "rounded border-gray-300"]) }}
            </div>
            <div class="col">
                {{ Form::select('filter[created_by_id]', $users , old('filter[created_by_id]'), ['placeholder' => __('content.item.created_by'), 'class' => "ml-2 rounded border-gray-300"]) }}
            </div>
            <div class="col">
                {{ Form::select('filter[assigned_to_id]', $users , old('filter[assigned_to_id]'), ['placeholder' => __('content.item.assigned_to'), 'class' => "ml-2 rounded border-gray-300"]) }}
            </div>
            <div class="col">
                {{ Form::submit(__('Apply'), ['class' => 'bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2']) }}
            </div>
        {{ Form::close() }}
        </div>

        @can('create', App\Models\Task::class)
            <div class="ml-auto">
                <x-button>
                    <a href="{{ route('tasks.create') }}">
                        {{__('content.task.create')}}
                    </a>
                </x-button>

            </div>
        @endcan
    </div>

    <table class="mt-4">
        <thead class="border-b-2 border-solid border-black text-left">
            <tr>
            <th>{{__('ID')}}</th>
            <th>{{ __('content.item.status') }}</th>
            <th>{{ __('content.item.name') }}</th>
            <th>{{ __('content.item.created_by') }}</th>
            <th>{{ __('content.item.assigned_to') }}</th>
            <th>{{ __('content.item.created_at') }}</th>
            @canany(['update', 'delete'], App\Models\Task::class)
                <th>{{__('Action')}}</th>
            @endcanany
        </tr>
        </thead>

        <tbody>
            @foreach ($tasks as $task)
            <tr class="border-b border-dashed text-left">
                <td>{{ $task->id }}</td>
                <td>{{ $task->status->name }}</td>
                <td>
                    <a class="text-blue-600 hover:text-blue-900" href="{{ route('tasks.show', $task) }}">
                        {{ $task->name }}
                    </a>
                </td>
                <td>{{ $task->creator->name }}</td>
                <td>{{ $task->assignedUser->name ?? ''}}</td>
                <td>{{ $task->created_at->format('d.m.Y') }}</td>
                @can('update', $task)
                    <td>
                        <a class="text-blue-600 hover:text-blue-900" href="{{ route('tasks.edit', $task) }}">{{ __('Edit') }}</a>
                        @can('delete', $task)
                            <a class="text-red-600 hover:text-red-900"
                               href="{{ route('tasks.destroy', $task) }}"
                               data-confirm="{{ __("Are you sure?") }}"
                               data-method="delete"
                               rel="nofollow">
                                {{__('Delete')}}
                            </a>
                        @endcan
                    </td>
                @endcan
            </tr>
        @endforeach
        </tbody>

    </table>

    {{ $tasks->links('pagination::bootstrap-4') }}
@endsection
