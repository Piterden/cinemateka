<nav>
  <div class="nav-wrapper">
    <a v-link="{ path: '/' }" class="brand-logo left">
      <img src="{{ config('app.logo.img') }}" alt="{{ config('app.logo.alt') }}">
    </a>
    <ul>
      @foreach ($menuItems as $item)
      <li>
        <a v-link="{ path: '/{{ $item->link }}' }">{{ $item->name }}</a>
      </li>
      @endforeach
    </ul>
    <a href="http://seance.ru" class="brand-logo right" target="_blank">
      <img src="{{ config('app.logo.s-img') }}" alt="{{ config('app.logo.alt') }}">
    </a>
  </div>
</nav>
