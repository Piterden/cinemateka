@extends('layout')

@section('top-block')
  <swipe class="index-page-swipe"
    :speed="500"
    :auto="5000"
  >
    @foreach ($slides as $item)
      <swipe-item class="slide1">
        <img src="{{ $item->src }}">
        <div class="caption center-align">
          <h3>{{ $item->caption['title'] }}</h3>
          <h5 class="light grey-text text-lighten-3">{{ $item->caption['content'] }}</h5>
        </div>
      </swipe-item>
    @endforeach
  </swipe>
@endsection
