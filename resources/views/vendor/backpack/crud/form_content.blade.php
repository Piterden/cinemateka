<form role="form">
  {{-- Show the erros, if any --}}
  @if ($errors->any())
  	<div class="callout callout-danger">
      <h4>{{ trans('validation.please_fix') }}</h4>
      <ul>
    		@foreach($errors->all() as $error)
    			<li>{{ $error }}</li>
    		@endforeach
  		</ul>
  	</div>
  @endif

  {{-- Show the inputs --}}
  @foreach ($fields as $field)
    <!-- load the view from the application if it exists, otherwise load the one in the package -->
  	@if(view()->exists('vendor.dick.crud.fields.'.$field['type']))
  		@include('vendor.dick.crud.fields.'.$field['type'], array('field' => $field))
  	@else
  		@include('crud::fields.'.$field['type'], array('field' => $field))
  	@endif
  @endforeach
</form>

{{-- Define blade stacks so css and js can be pushed from the fields to these sections. --}}

@section('after_styles')
	<!-- CRUD FORM CONTENT - crud_fields_styles stack -->
	@stack('crud_fields_styles')
@endsection

@section('after_scripts')
	<!-- CRUD FORM CONTENT - crud_fields_scripts stack -->
	@stack('crud_fields_scripts')
@endsection
