@foreach ($crud->fields() as $field)
	@include('crud::fields.layouts.field')
@endforeach
