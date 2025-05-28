@props([
    'icon' => '',
    'desc' => '',
])

<div class="icon text-center">
  <div class="icon__img">
    <img src="https://openweathermap.org/img/wn/{{ $icon }}@2x.png"
         class="w-12 sm:w-16 mx-auto"
         alt="{{ $desc }}">
  </div>
  <span class="block text-xs sm:text-sm text-gray-600 mt-1">{{ $desc }}</span>
</div>
