@if ($crud->showButtons())
    <td class="actions text-center">
        @foreach ($crud->buttons() as $key => $button)
            @if ($key !== 'add')
                <a href="{{ str_replace('%d', $item->id, $button['route']) }}"
                  class="btn btn-xs btn-default {{ array_key_exists('class', $button) ? $button['class'] : '' }}"
                  {!! array_key_exists('extra', $button)
                    ? implode(' ', array_map(function($value, $key) { return "{$key}='{$value}'"; }, $button['extra'], array_keys($button['extra'])))
                    : '' !!}
                >
                    @if (array_key_exists('icon', $button))
                        <i class="fa {{ $button['icon'] }}"></i>
                    @endif

                    {{ $button['label'] }}
                </a>
            @endif
        @endforeach
    </td>
@endif
