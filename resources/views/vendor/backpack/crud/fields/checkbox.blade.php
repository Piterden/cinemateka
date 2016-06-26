<!-- checkbox field -->
<div class="checkbox col-md-{{ $field['colspan'] or 12 }} {{ $field['cssclass'] or '' }}">
	<label>
	  <input type="hidden" name="{{ $field['name'] }}" value="0">
	  <input type="checkbox" value="1" @foreach ($field as $attribute => $value)
        @if (is_string($attribute) )
    		@if( $attribute == 'value' )
    			@if( ((int) $value == 1 || old($field['name']) == 1) && old($field['name']) !== '0' )
    			 checked = "checked"
    			@endif

    		@else
    			{{ $attribute }}="{{ $value }}"
    		@endif
        @endif
	@endforeach> {{ $field['label'] }}
	</label>
</div>
