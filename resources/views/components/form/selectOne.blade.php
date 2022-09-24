<div class="mt-4">
    {{ Form::label($name, __($text)) }}
    <br>
    {{ Form::select($name, $array, $value, array_merge(['class' => 'rounded border-gray-300 w-1/3'. ($errors->has($name) ? ' is-invalid' : null)], $attributes)) }}
        @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    <br>
</div>
