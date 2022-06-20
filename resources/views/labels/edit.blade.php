@extends('layouts.app')

@section('content')

    <h1 class="mb-5">{{__('Edit label')}}</h1>

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
            {{ Form::label('name', __('Name')) }}
            <br>
            {{ Form::text('name', $value = null , ['class' => 'form-control']) }}
            <br>
            {{ Form::label('description', __('Description')) }}
            <br>
            {{ Form::textarea('description', null , ['class' => 'form-control', 'rows' => '10']) }}
        </div>
        {{ Form::submit(__('Edit-btn'), ['class' => 'btn btn-primary mt-3']) }}
        {{ Form::close() }}
    </div>
@endsection
