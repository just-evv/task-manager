@extends('layouts.app')

@section('content')

    <h1 class="mb-5">{{__('Edit label')}}</h1>

        {{ Form::model($label, ['route' => ['labels.update', $label], 'method' => 'PATCH', 'class' => "form-group mb-3"]) }}
            {{ Form::label('name', __('Name')) }}
            <br>
            {{ Form::text('name', $value = null , ['class' => 'form-control'. ($errors->has('name') ? ' is-invalid' : null)]) }}
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            <br>
            {{ Form::label('description', __('Description')) }}
            <br>
            {{ Form::textarea('description', null , ['class' => 'form-control', 'rows' => '10']) }}

        {{ Form::submit(__('Update'), ['class' => 'btn btn-primary mt-3']) }}
        {{ Form::close() }}
@endsection
