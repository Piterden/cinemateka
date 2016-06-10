{{-- {!! Form::hidden($field['name'], 0) !!} --}}
<label>
    {!! Form::checkbox($field['name'], $field['value'] ?: $field['default'], $field['value'] == $field['default'], $field['attributes']) !!}
    {{ $field['label'] }}
</label>
<br>

