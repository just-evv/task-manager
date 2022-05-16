@extends('layouts.app')

@section('content')

    <h1 class="mb-5">Edit label</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="form-group">
        {{ Form::model($label, ['route' => ['labels.update', $label], 'method' => 'PATCH']) }}
        <div class="form-group mb-3">
            {{ Form::label('name', 'Name') }}
            <br>
            {{ Form::text('name', $value = null , ['class' => 'form-control']) }}
            <br>
            {{ Form::label('description', 'Description') }}
            <br>
            {{ Form::textarea('description', null , ['class' => 'form-control', 'rows' => '10']) }}
        </div>
        {{ Form::submit('Update', ['class' => 'btn btn-primary mt-3']) }}
        {{ Form::close() }}
    </div>
@endsection
