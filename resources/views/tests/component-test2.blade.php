<x-tests.app>
  <x-slot name="header">ヘッダ―2が$headerに挿入される</x-slot>
  component test2 が$slotに挿入される
  <x-test-class-base classBaseMessage="メッセージです" />
  <x-test-class-base classBaseMessage="メッセージです" defaultMessage="初期値から変更しています。" />
</x-tests.app>
