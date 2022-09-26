@extends('layouts.app')

@section('content')

        @include('flash::message')
    <h1 class="text-5xl font-semibold mb-5">{{__('content.status.statuses')}}</h1>

    @can('create', App\Models\TaskStatus::class)
        <div class="mr-auto">
            <x-button>
                <a href="{{ route('task_statuses.create') }}">{{__('content.status.create')}}</a>
            </x-button>
        </div>
    @endcan

    <table class="mt-4">
        <thead class="border-b-2 border-solid border-black text-left">
            <tr>
                <th>{{__('ID')}}</th>
                <th>{{__('content.item.name')}}</th>
                <th>{{__('content.item.created_at')}}</th>
                @canany(['update', 'delete'], App\Models\TaskStatus::class)
                <th>{{__('Action')}}</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
        @foreach($statuses as $status)
            <tr class="border-b border-dashed text-left">

                <td>{{ $status->id }}</td>
                <td>{{ $status->name}}</td>
                <td>{{ $status->created_at->toDateString() }}</td>
                @canany(['update', 'delete'], $status)
                    <td>
                        <a class="text-blue-600 hover:text-blue-900" href="{{ route('task_statuses.edit', $status) }}">{{__('Edit')}}</a>
                        <a class="text-red-600 hover:text-red-900"
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
        </tbody>

    </table>
@endsection
