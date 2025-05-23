@props([
    'icon' => '',
    'desc' => '',
])

<div class="icon text-center">
  <div class="icon__img">
    <img src="https://openweathermap.org/img/wn/{{ $icon }}@2x.png" class="w-16">
  </div>
  <span class="block">{{ $desc }}</span>
</div>
