@extends('layouts.app')

@section('content')

    <h1 class="mb-5">Create label</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{ Form::model($label, ['route' => 'labels.store', 'class' => "form-group mb-3"]) }}

    {{ Form::label('name', 'Name') }}
    <br>
    {{ Form::text('name', $value = null , ['class' => 'form-control']) }}
    <br>
    {{ Form::label('description', 'Description') }}
    <br>
    {{ Form::textarea('description', null , ['class' => 'form-control', 'rows' => '10']) }}
    <br>
    {{ Form::submit('Create',  ['class' => 'btn btn-primary mt-3']) }}

    {{ Form::close() }}

@endsection
