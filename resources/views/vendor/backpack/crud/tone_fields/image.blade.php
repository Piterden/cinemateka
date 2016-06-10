@if($field['value'])
	<div style="padding-bottom: 20px;">
		<img src="{{ $entry->{'get'.ucfirst(camel_case($field['name']))}() }}" class="img img-responsive" style="max-height:100px;">
	</div>
	{!! Form::hidden('current_'.$field['name'], $field['value']) !!}
@endif

{!! Form::file($field['name']) !!}
