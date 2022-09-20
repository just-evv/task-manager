<div class="mt-2">
    {{ Form::label($name, __($text)) }}
    <br>
    {{ Form::text($name, $value, array_merge(['class' => 'rounded border-gray-300 w-1/3 my-4'. ($errors->has($name) ? ' is-invalid' : null)], $attributes)) }}
        @error($name)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    <br>
</div>
