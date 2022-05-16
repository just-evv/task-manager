@extends('layouts.app')

@section('content')
    @include('flash::message')
    <h1 class="mb-5">Labels</h1>
    @can('create-label')
        <a href="{{ route('labels.create') }}" class="btn btn-primary">Create new label</a>
    @endcan
    <table class="table me-2">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Created at</th>
            @canany(['update-label', 'delete-label'], $labels)
                <th>Action</th>
            @endcanany
        </tr>
        </thead>
        @foreach($labels as $label)
            <tr>

                <td>{{ $label->id }}</td>
                <td>{{ $label->name }}</td>
                <td>{{ $label->description ?? '' }}</td>
                <td>{{ $label->created_at->toDateString() }}</td>
                @canany(['update-label', 'delete-label'], $label)
                    <td>
                        <a class="text-decoration-none" href="{{ route('labels.edit', $label) }}">Edit</a>
                        <a class="text-danger text-decoration-none"
                           href="{{ route('labels.destroy', $label) }}"
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
