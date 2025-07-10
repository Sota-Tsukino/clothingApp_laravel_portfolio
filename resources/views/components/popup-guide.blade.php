@props(['field', 'guides'])

<button type="button" @click="show = !show" @click.away="show = false" class="focus:outline-none w-7">
  <img src="{{ asset('images/question.png') }}" alt="ガイド" class="w-full h-full inline hover:opacity-75">
</button>

<!-- ポップアップ -->
<div x-show="show" x-transition
  class="absolute bottom-1/2 right-1/2 mb-2 w-64 text-sm text-blue-600 bg-blue-100 border border-gray-300 rounded-lg shadow-md p-2 z-10"
  style="display: none;" {{-- Alpine.js の初期状態に必要 --}}>
  {{ $guides[$field] ?? '説明は準備中です。' }}
</div>
