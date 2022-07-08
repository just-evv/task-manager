<div class="form-group">
    {{ Form::label($name, __($text)) }}
    <br>
    {{ Form::textarea($name, $value, array_merge(['class' => 'form-control'. ($errors->has($name) ? ' is-invalid' : null)], $attributes)) }}
    <br>
</div>
