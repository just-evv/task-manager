@extends('layouts.app')

@section('content')

    <h1 class="mb-5">{{__('Edit label')}}</h1>

        {{ Form::model($label, ['route' => ['labels.update', $label], 'method' => 'PATCH', 'class' => "form-group mb-3"]) }}

        {{ Form::bsText('name', 'Name') }}

        {{ Form::bsTextarea('description', 'Description', null, ['rows' => '10', 'cols' => '50']) }}

        {{ Form::submit(__('Update'), ['class' => 'btn btn-primary mt-3']) }}
        {{ Form::close() }}
@endsection
