@if ($item->{$crud->getRelations()[$column['name']]['name']})
    @if ($crud->getRelations()[$column['name']]['pivot'])
        {!! implode(', ', $item->{$crud->getRelations()[$column['name']]['name']}()->get()->lists($crud->getRelations()[$column['name']]['field'])->toArray()) !!}
    @else
        {{ $item->{$crud->getRelations()[$column['name']]['name']}->{$crud->getRelations()[$column['name']]['field']} }}
    @endif
@endif
