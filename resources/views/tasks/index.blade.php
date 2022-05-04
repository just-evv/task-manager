@extends('layouts.app')

@section('content')
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
        </tr>
        </thead>
        <tr>
            <td></td>
            <td></td>
            <td>
                <a class="text-decoration-none" href=" { route('') } ">
                </a>
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
@endsection
