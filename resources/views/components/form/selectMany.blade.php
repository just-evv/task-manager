<div class="form-group">
    {{ Form::label($name, __($text)) }}
    <br>
    {{ Form::select($name. '[]', $array, $value, array_merge(['class' => 'form-control', 'multiple' => 'multiple'], $attributes)) }}
    <br>
</div>
