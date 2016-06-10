<div>
	@if (array_key_exists('model', $field))
		@foreach ($field['model']::lists($field['attribute'], 'id')->all() as $key => $option)
	    	{!! Form::radio($field['name'], $key, $field['value'] == $key ?: $field['default'] == $key, ['id' => "option-{$key}"] + $field['attributes']) !!}
	    	{!! Form::label("option-{$key}", $option) !!}
		@endforeach
	@endif
</div>
