@extends('layouts.app')

@section('content')

    <h1 class="mb-5">{{__('Edit status')}}</h1>

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
    {{ Form::model($status, ['route' => ['task_statuses.update', $status], 'method' => 'PATCH']) }}
        <div class="form-group mb-3">
    {{ Form::label('name', __('Name')) }}
    <br>
    {{ Form::text('name', $value = null , ['class' => 'form-control']) }}
        </div>
    {{ Form::submit(__('Edit-btn'), ['class' => 'btn btn-primary mt-3']) }}
    {{ Form::close() }}
    </div>
@endsection
