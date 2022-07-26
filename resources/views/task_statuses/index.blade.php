@extends('layouts.app')

@section('content')
    @include('flash::message')
    <h1 class="mb-5">{{__('content.status.statuses')}}</h1>
    @can('create', App\Models\TaskStatus::class)
    <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">{{__('content.status.create')}}</a>
    @endcan
    <table class="table me-2">
        <thead>
        <tr>
            <th>{{__('ID')}}</th>
            <th>{{__('content.item.name')}}</th>
            <th>{{__('content.item.created_at')}}</th>
            @canany(['update', 'delete'], App\Models\TaskStatus::class)
            <th>{{__('Action')}}</th>
            @endcanany
        </tr>
        </thead>
        @foreach($statuses as $status)
        <tr>

            <td>{{ $status->id }}</td>
            <td>{{ $status->name}}</td>
            <td>{{ $status->created_at->toDateString() }}</td>
            @canany(['update', 'delete'], $status)
            <td>
                <a class="text-decoration-none" href="{{ route('task_statuses.edit', $status) }}">{{__('Edit')}}</a>
                <a class="text-danger text-decoration-none"
                   href="{{ route('task_statuses.destroy', $status) }}"
                   data-confirm="{{ __("Are you sure?") }}"
                   data-method="delete"
                   rel="nofollow">
                    {{__('Delete')}}
                </a>
            </td>
            @endcanany

        </tr>
        @endforeach
    </table>
@endsection
