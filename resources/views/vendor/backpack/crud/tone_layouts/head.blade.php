<section class="content-header">
    <h1>
       	<span class="text-capitalize">{{ $crud->getTitle() }}</span>
       	@if ($crud->getSubTitle())
       		<br><small>{{ $crud->getSubTitle() }}</small>
       	@endif
    </h1>
    <ol class="breadcrumb">
  	    <li><a>@lang('crud::crud.manage')</a></li>
  	    <li><a href="{{ url($crud->getRoute()) }}" class="text-capitalize">{{ $crud->getTitle() }}</a></li>
  	    <li class="active">{!! $crud->getState() !!}</li>
    </ol>
</section>
<br>
