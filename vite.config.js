import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',

                // 下記JSファイルもビルド対象で追加する
                'resources/js/init-size-checker.js',
                'resources/js/init-item-category-select.js',
                'resources/js/clothing-item.js',
                'resources/js/init-size-checker-display.js',
                'resources/js/init-pref-city-select.js',
                'resources/js/calc-armpits-width.js',
                'resources/js/calc-kitake-length.js',
                'resources/js/init-item-image-display.js',
            ],
            refresh: true,
        }),
    ],
});
