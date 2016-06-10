@if (!$item->{$column['name']} || in_array($item->{$column['name']}, ['0000-00-00', '0000-00-00 00:00:00']))
@elseif ($column['type'] == 'active')
	@lang('crud::crud.general.active.'.$item->{$column['name']})
@elseif ($column['type'] == 'textarea')
	{{ str_limit(strip_tags($item->{$column['name']}, 150)) }}
@elseif ($column['type'] == 'email')
	<a href="mailto:{{ $item->{$column['name']} }}">{{ $item->{$column['name']} }}</a>
@elseif (in_array($column['type'], ['date', 'datepicker']))
	{{ \Carbon\Carbon::parse($item->{$column['name']})->format('Y-m-d') }}
@elseif ($column['type'] == 'datetime')
	{{ \Carbon\Carbon::parse($item->{$column['name']})->format('Y-m-d H:i:s') }}
@else
	{{ $item->{$column['name']} }}
@endif
