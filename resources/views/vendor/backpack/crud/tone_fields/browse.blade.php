{!! Form::text($field['name'], $field['value'] ?: $field['default'], ['id' => "{$field['name']}-filemanager", 'readonly'] + array_merge(['class' => 'form-control'], $field['attributes'])) !!}

<div class="btn-group" role="group" aria-label="..." style="margin-top: 3px;">
  	<button type="button" data-inputid="{{ $field['name'] }}-filemanager" class="btn btn-default popup_selector"><i class="fa fa-cloud-upload"></i> @lang('crud.fields.browse.index')</button>
	<button type="button" data-inputid="{{ $field['name'] }}-filemanager" class="btn btn-default clear_elfinder_picker"><i class="fa fa-eraser"></i> @lang('crud.fields.browse.clear')</button>
</div>
<div class="clearfix"></div>
