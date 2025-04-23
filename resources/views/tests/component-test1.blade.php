<x-tests.app>
  <x-slot name="header">ヘッダー１</x-slot>
  component test1 が$slotに挿入される
  <x-tests.card title="タイトル1" content="本文1" :message="$message" />
  <x-tests.card title="タイトル2" />
  <x-tests.card title="このカードだけCSSを変更したい" class="bg-red-300" />
</x-tests.app>
