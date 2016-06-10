<ol class="breadcrumb tabs pull-right">
    @foreach ($crud->buttons() as $key => $button)
        @if ($key != 'delete')
            @if (in_array($key, ['view', 'edit', 'delete']))
                @if ($crud->item)
                    <li class="{{ $key == $crud->state() ? 'active' : '' }}"><a href="{{ str_replace('%d', $crud->item->id, $button['route']) }}" class="text-capitalize"  {!! array_key_exists('extra', $button) ? implode(' ', array_map(function($value, $key) { return "{$key}='{$value}'"; }, $button['extra'], array_keys($button['extra']))) : '' !!}>{{ $button['label'] }}</a></li>
                @endif
            @else
                <li class="{{ $key == $crud->state() ? 'active' : '' }}"><a href="{{ $button['route'] }}" class="text-capitalize">{{ $button['label'] }}</a></li>
            @endif
        @endif
    @endforeach
    <li class="{{ $crud->state() == 'list' ? 'active' : '' }}"><a href="{{ url($crud->getRoute()) }}" class="text-capitalize">@lang('crud::crud.list.index')</a></li>
</ol>
