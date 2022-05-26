@extends('layouts.app')

@section('content')
    @include('flash::message')
    <h1 class="mb-5">Tasks</h1>

    <div class="d-flex mb-3">
            <!-- Form -->
        {{ Form::open(['route' => 'tasks.index', 'method' => 'GET']) }}

        <div class="row g-1">

            <div class="col">
                {{ Form::select('filter[status_id]', $statuses , null, ['placeholder' => 'Status', 'class' => "form-select me-2"]) }}
            </div>
            <div class="col">
                {{ Form::select('filter[created_by_id]', $users , null, ['placeholder' => 'Creator', 'class' => "form-select me-2"]) }}
            </div>
            <div class="col">
                {{ Form::select('filter[assigned_to_id]', $users , null, ['placeholder' => 'Assigned to', 'class' => "form-select me-2"]) }}
            </div>
            <div class="col">
                {{ Form::submit('Apply', ['class' => 'btn btn-outline-primary me-2']) }}
            </div>
        {{ Form::close() }}
        </div>

        @can('create-task')
            <div class="ms-auto">
                <a href="{{ route('tasks.create') }}" class="btn btn-primary ml-auto">Create new task</a>
            </div>
        @endcan
    </div>

    <table class="table me-2">
        <thead>
        <tr>
            <th>ID</th>
            <th>Status</th>
            <th>Name</th>
            <th>Created by</th>
            <th>Assigned to</th>
            <th>Created at</th>
            @canany(['edit-task'], $filter)
                <th>Action</th>
            @endcanany
        </tr>
        </thead>
        @foreach ($filter as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>
                    <a class="text-decoration-none" href="{{ route('tasks.show', $task) }}">
                    {{ $task->status->name }}
                    </a>
                </td>
                <td>{{ $task->name }}</td>
                <td>{{ $task->creator->name }}</td>
                <td>{{ $task->assignedUser->name ?? ''}}</td>
                <td>{{ $task->created_at->toDateString() }}</td>
                @canany(['edit-task', 'delete-task'], $task)
                    <td>
                        <a class="text-decoration-none" href="{{ route('tasks.edit', $task) }}">Edit</a>
                        <a class="text-danger text-decoration-none"
                           href="{{ route('tasks.destroy', $task) }}"
                           data-confirm="Are you sure?"
                           data-method="delete"
                           rel="nofollow">
                            Delete
                        </a>
                    </td>
                @endcanany
            </tr>
        @endforeach
    </table>
    {{ $filter->links('pagination::bootstrap-4') }}

@endsection
