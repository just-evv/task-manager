@extends('layouts.app')

@section('content')
    @include('flash::message')
    <h1 class="mb-5">Tasks</h1>
    <div class="d-flex mb-3">
        @can('create-task')
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create new task</a>
        @endcan
        <div>
                <!-- Form -->
        </div>
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
            @canany(['edit-task'], $tasks)
                <th>Action</th>
            @endcanany
        </tr>
        </thead>
        @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->status->name }}</td>
                <td>{{ $task->name }}</td>
                <td>{{ $task->creator->name }}</td>
                <td>{{ $task->assignedUser->name ?? ''}}</td>
                <td>{{ $task->created_at->toDateString() }}</td>
                @canany(['edit-task'], $task)
                    <td>
                        <a class="text-decoration-none" href="{{ route('tasks.edit', $task) }}">Edit</a>
                    </td>
                @endcanany
            </tr>
        @endforeach
    </table>
    {{ $tasks->links('pagination::bootstrap-4') }}
@endsection
