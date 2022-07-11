@extends('layouts.app')

@section('content')
    @include('flash::message')
    <h1 class="mb-5">{{__('Labels')}}</h1>
    @can('create', App\Models\Label::class)
        <a href="{{ route('labels.create') }}" class="btn btn-primary">{{__('Create new label')}}</a>
    @endcan
    <table class="table me-2">
        <thead>
        <tr>
            <th>{{__('ID')}}</th>
            <th>{{__('Name')}}</th>
            <th>{{__('Description')}}</th>
            <th>{{__('Created at')}}</th>
            @can('create', App\Models\Label::class)
                <th>{{__('Action')}}</th>
            @endcan
        </tr>
        </thead>
        @foreach($labels as $label)
            <tr>

                <td>{{ $label->id }}</td>
                <td>{{ $label->name }}</td>
                <td>{{ $label->description ?? '' }}</td>
                <td>{{ $label->created_at->toDateString() }}</td>
                @canany(['edit', 'delete'], $label)
                    <td>
                        <a class="text-decoration-none" href="{{ route('labels.edit', $label) }}">{{__('Edit')}}</a>
                        <a class="text-danger text-decoration-none"
                           href="{{ route('labels.destroy', $label) }}"
                           data-confirm="{{__('Are you sure?')}}"
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
