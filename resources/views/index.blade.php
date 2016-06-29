@extends('layout')

@section('top-block')
  <swipe class="index-page-swipe"
    :speed="500"
    :auto="5000"
  >
    @foreach ($slides as $item)
      <swipe-item
        class="slide@{{ $index }}"
        style="background-image: url('{{ $item->src }}')"
      >
        <div class="caption center-align">
          @if (!empty($item->caption['title']))
            <h3>{{ $item->caption['title'] }}</h3>
          @endif
          @if (!empty($item->caption['content']))
            <h5 class="light grey-text text-lighten-3">
              {{ $item->caption['content'] }}
            </h5>
          @endif
        </div>
      </swipe-item>
    @endforeach
  </swipe>
@endsection
