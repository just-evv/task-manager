<div class="form-group">
    {{ Form::label($name, __($text)) }}
    <br>
    {{ Form::select($name, $array, $value, array_merge(['class' => 'form-control'. ($errors->has('name') ? ' is-invalid' : null)], $attributes)) }}
    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <br>
</div>
