@props(['items'])
<!-- モーダル本体 -->
<div class="modal micromodal-slide" id="modal-item-list" aria-hidden="true">
  <div class="modal__overlay" tabindex="-1" data-micromodal-close>
    <div class="modal__container bg-white rounded-lg p-6 max-w-3xl mx-auto shadow-lg" role="dialog" aria-modal="true"
      aria-labelledby="modal-item-list-title">
      <header class="modal__header">
        <h2 class="text-xl font-semibold" id="modal-item-list-title">衣類を選択</h2>
        <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
      </header>
      <main class="modal__content" id="modal-item-list-content">
        <div class="flex flex-wrap -m-2">
          @if ($items->count() > 0)
            @foreach ($items as $item)
              <x-modal-item-card :item="$item" />
            @endforeach
          @else
            <p class="text-xl text-gray-700">衣類アイテムが登録されていません。</p>
          @endif
        </div>
      </main>
      <footer class="modal__footer">
        <button class="bg-indigo-500 text-white px-4 py-2 rounded" data-micromodal-close>完了</button>
      </footer>
    </div>
  </div>
</div>
