<div class="mt-4">
    {{ Form::label($name, __($text)) }}
    <br>
    {{ Form::textarea($name, $value, array_merge(['class' => 'rounded border-gray-300 w-1/3 h-32'. ($errors->has($name) ? ' is-invalid' : null)], $attributes)) }}
    <br>
</div>
