@extends('layouts.app')

@section('content')
    @include('flash::message')
    <h1 class="text-5xl font-semibold mb-5">{{__('content.label.labels')}}</h1>
    @can('create', App\Models\Label::class)
        <div class="'mr-auto">
            <x-button>
                <a href="{{ route('labels.create') }}">{{__('content.label.create')}}</a>
            </x-button>
        </div>

    @endcan
    <table class=class="mt-4">
        <thead class="border-b-2 border-solid border-black text-left">
        <tr>
            <th>{{__('ID')}}</th>
            <th>{{__('content.item.name')}}</th>
            <th>{{__('content.item.description')}}</th>
            <th>{{__('content.item.created_at')}}</th>
            @canany(['update', 'delete'], App\Models\Label::class)
                <th>{{__('Action')}}</th>
            @endcanany
        </tr>
        </thead>
        <tbody>
            @foreach($labels as $label)
                <tr class="border-b border-dashed text-left">

                    <td>{{ $label->id }}</td>
                    <td>{{ $label->name }}</td>
                    <td>{{ $label->description ?? '' }}</td>
                    <td>{{ $label->created_at->toDateString() }}</td>
                    @canany(['edit', 'delete'], $label)
                        <td>
                            <a class="text-blue-600 hover:text-blue-900" href="{{ route('labels.edit', $label) }}">{{__('Edit')}}</a>
                            <a class="text-red-600 hover:text-red-900"
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
        </tbody>

    </table>
@endsection
