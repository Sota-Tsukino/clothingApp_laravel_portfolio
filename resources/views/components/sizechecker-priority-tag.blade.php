@props(['priorityMap', 'field'])
@php
  $priorityBadgeClass = [
      'high' => 'text-red-600 font-bold bg-red-100',
      'middle' => 'text-yellow-600 bg-yellow-100',
      'low' => 'text-gray-600 bg-gray-100',
  ];

@endphp
<span
  class="inline-block px-2 py-1 text-sm font-semibold rounded-full {{ $priorityBadgeClass[$priorityMap[$field]] }}">{{ __("priority.$priorityMap[$field]") }}</span>
