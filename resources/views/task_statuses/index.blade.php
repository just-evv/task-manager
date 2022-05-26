@extends('layouts.app')

@section('content')
    @include('flash::message')
    <h1 class="mb-5">Statuses</h1>
    @can('create', App\Models\TaskStatus::class)
    <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">Create new status</a>
    @endcan
    <table class="table me-2">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Created at</th>
            @can('create', App\Models\TaskStatus::class)
            <th>Action</th>
            @endcan
        </tr>
        </thead>
        @foreach($statuses as $status)
        <tr>

            <td>{{ $status->id }}</td>
            <td>{{ $status->name}}</td>
            <td>{{ $status->created_at->toDateString() }}</td>
            @canany(['update', 'delete'], $status)
            <td>
                <a class="text-decoration-none" href="{{ route('task_statuses.edit', $status) }}">Update</a>
                <a class="text-danger text-decoration-none"
                   href="{{ route('task_statuses.destroy', $status) }}"
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
@endsection
