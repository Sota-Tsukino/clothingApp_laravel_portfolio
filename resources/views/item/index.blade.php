@php
  $categories = [
      'all' => '全て',
      'topps' => 'トップス',
      'bottoms' => 'ボトムズ',
      'outer' => 'アウター',
      'setup' => 'セットアップ',
      'others' => 'その他',
  ];
@endphp

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      衣類アイテム一覧
    </h2>
  </x-slot>

  <section class="text-gray-600 body-font">
    <div class="container px-5 py-8 mx-auto bg-white rounded-lg my-24 shadow-lg">
      <x-auth-validation-errors class="mb-4" :errors="$errors" />
      <x-flash-message status="session('status')" />

      <div x-data="{ tab: '{{ array_key_first($categories) }}' }">
        <!-- タブメニュー -->
        <div class="flex space-x-4 mb-6">
          @foreach ($categories as $key => $label)
            <button class="px-4 py-2 text-sm text-gray-600"
              :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === '{{ $key }}' }" @click="tab = '{{ $key }}'">
              {{ $label }}
            </button>
          @endforeach
        </div>

        <!-- アイテムリスト -->
        <div class="flex flex-wrap -m-2">
          @foreach ($items as $item)
            <template x-if="tab === 'all' || tab === '{{ $item->category->name }}'">
              <x-item-card :item="$item" />
            </template>
          @endforeach
        </div>
      </div>
    </div>
  </section>
</x-app-layout>
