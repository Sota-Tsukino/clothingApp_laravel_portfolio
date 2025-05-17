@props(['items'])
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

<!-- モーダル本体 -->
<div class="modal micromodal-slide" id="modal-item-list" aria-hidden="true">
  <div class="modal__overlay" tabindex="-1" data-micromodal-close>
    <div class="modal__container bg-white rounded-lg p-5 max-w-3xl mx-auto shadow-lg fixed top-0 w-full" role="dialog" aria-modal="true"
      aria-labelledby="modal-item-list-title">
      <header class="modal__header">
        <h2 class="text-xl font-semibold" id="modal-item-list-title">衣類を選択</h2>
        <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
      </header>
      <main class="modal__content" id="modal-item-list-content" x-data="{ tab: '{{ array_key_first($categories) }}' }">
        <!-- タブメニュー -->
        <div class="flex space-x-4 mb-6">
          @foreach ($categories as $key => $label)
            <button type="button" class="px-4 py-2 text-sm text-gray-600"
              :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === '{{ $key }}' }"
              @click="tab = '{{ $key }}'">
              {{ $label }}
            </button>
          @endforeach
        </div>
        <div class="flex flex-wrap -m-2">
          @if ($items->count() > 0)
            @foreach ($items as $item)
              <template x-if="tab === 'all' || tab === '{{ $item->category->name }}'">
                <x-modal-item-card :item="$item" />
              </template>
            @endforeach
          @else
            <p class="text-xl text-gray-700">衣類アイテムが登録されていません。</p>
          @endif
        </div>
      </main>
      <footer class="modal__footer">
        <button class="bg-indigo-500 text-white px-4 py-2 rounded" data-micromodal-close>閉じる</button>
      </footer>
    </div>
  </div>
</div>
