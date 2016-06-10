<!-- \nav-bar -->
<div class="col s8 nav-bar center">
  <div class="wrap">
    <!-- \main-nav -->
    <ul class="main-nav">
      @foreach ($menuItems as $item)
      <li class="nav-item">
        <a v-link="{ path: '/{{ $item->link }}' }">{{ $item->name }}</a>
      </li>
      @endforeach
    </ul>
    <!-- /main-nav -->
  </div>
</div>
<!-- /nav-bar -->
