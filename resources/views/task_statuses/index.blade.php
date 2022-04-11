@extends('layouts.app')

@section('content')
    <h1 class="mb-5">Statuses</h1>
    <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">Create new status</a>
    <table class="table me-2">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Created</th>
            <th>Action</th>
        </tr>
        </thead>
        @foreach($statuses as $status)
        <tr>

            <td>{{$status->id}}</td>
            <td>{{$status->name}}</td>
            <td>{{$status->created_at}}</td>
            <td></td>

        </tr>
        @endforeach
    </table>
@endsection
