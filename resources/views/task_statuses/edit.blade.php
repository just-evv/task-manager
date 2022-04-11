@extends('layouts.app')

@section('content')

    <h1 class="mb-5">Update status</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{ Form::model($status, ['route' => ['task_statuses.update', $status], 'method' => 'PATCH']) }}
    {{ Form::label('name', 'Name') }}
    {{ Form::text('name') }}<br>

    {{ Form::submit('Update') }}
    {{ Form::close() }}

@endsection
