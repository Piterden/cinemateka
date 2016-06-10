@if ($field['type'] == 'hidden')
	@include("crud::fields.{$field['type']}")
@else
	<div class="form-group {{ $field['type'] }}">
	    <label for="{{ $field['name'] }}">
	    	{!! $field['label'] or $crud->labels()[$field['name']] !!}{!! in_array($field['name'], $crud->required()) || (array_key_exists('required', $field) && $field['required']) ? '<span class="required">*</span>' : '' !!}:
	    </label>

		@if (array_key_exists('callback', $field) && $field['callback'])
			{!! call_user_func($field['callback'], $field, $crud->item) !!}
		@elseif(array_key_exists('callback_create', $field) && $field['callback_create'] && !$crud->item)
			{!! call_user_func($field['callback_create'], $field, $crud->item) !!}
		@elseif(array_key_exists('callback_edit', $field) && $field['callback_edit'] && $crud->item)
			{!! call_user_func($field['callback_edit'], $field, $crud->item) !!}
		@else
			@include("crud::fields.{$field['type']}")
		@endif

		@if (array_key_exists('hint', $field) && $field['hint'])
		    <span class="hint">*{{ $field['hint'] }}</span>
		@endif
	</div>
@endif
