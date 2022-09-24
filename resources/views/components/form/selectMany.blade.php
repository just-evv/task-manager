<div class="form-group">
    {{ Form::label($name, __($text)) }}
    <br>
    {{ Form::select($name. '[]', $array, $value, array_merge(['class' => 'rounded border-gray-300 w-1/3 h-32'. ($errors->has($name) ? ' is-invalid' : null), 'multiple' => 'multiple'], $attributes)) }}
    <br>
</div>
