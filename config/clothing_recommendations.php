<?php

return [
    'temperature_ranges' => [
        '30+' => [//topsではなくcategory_idをキーにした方がいい（DBよりデータを取得する場合の都合上）？
            'tops' => ['polo-shirt', 'shirt', 't-shirt', 'tanktop'],//itemsテーブルのcategory_id = 1
            'bottoms' => ['slacks', 'short-pants'],//itemsテーブルのcategory_id = 2
            'outers' => [],//itemsテーブルのcategory_id = 3
        ],
        '25-29' => [
            'tops' => ['polo-shirt', 'shirt', 't-shirt'],
            'bottoms' => ['slacks', 'jeans', 'jogger-pants', 'short-pants'],
            'outers' => [],
        ],
        '21-24' => [
            'tops' => ['shirt', 't-shirt'],
            'bottoms' => ['slacks', 'jeans', 'jogger-pants', 'cropped-pants'],
            'outers' => ['shirt', 'cardigan', 'denim-jacket', 'fleece', 'mountain-parka'],
        ],
        '17-20' => [
            'tops' => ['shirt', 'T-shirt', 'sweatshirt'],
            'bottoms' => ['chino-pants', 'jeans', 'knit-trousers', 'cargo-pants', 'slacks'],
            'outers' => ['cardigan', 'jacket', 'denim-jacket', 'tailored-jacket', 'fleece', 'blouson', 'mountain-parka', 'mods-coat', 'vest'],
        ],
        '13-16' => [
            'tops' => ['shirt', 't-shirt', 'knitwear', 'hoodie', 'pullover-sweater'],
            'bottoms' => ['chino-pants', 'jeans', 'knit-trousers', 'cargo-pants', 'slacks'],
            'outers' => ['boa-jacket',  'blouson', 'fleece', 'mountain-parka', 'mods-coat', 'tailored-jacket', 'chester-coat', 'balmacaan-coat', 'trench-coat'],
        ],
        '9-12' => [
            'tops' => ['shirt', 't-shirt', 'knitwear', 'hoodie', 'pullover-sweater'],
            'bottoms' => ['chino-pants', 'jeans', 'knit-trousers', 'slacks'],
            'outers' => ['down-jacket', 'boa-jacket', 'duffle-coat', 'chester-coat', 'balmacaan-coat', 'pea-coat', 'mods-coat', 'mountain-parka', 'fleece', 'boa-coat', 'blouson', 'trench-coat'],
        ],
        '6-8' => [
            'tops' => ['shirt', 't-shirt', 'knitwear', 'hoodie', 'pullover-sweater'],
            'bottoms' => ['chino-pants', 'jeans', 'knit-trousers', 'slacks'],
            'outers' => ['down-jacket', 'duffle-coat',  'boa-jacket', 'chester-coat', 'balmacaan-coat', 'pea-coat', 'down-coat', 'boa-coat', 'trench-coat'],
        ],
        'under5' => [
            'tops' => ['shirt', 't-shirt', 'knitwear', 'hoodie', 'pullover-sweater'],
            'bottoms' => ['chino-pants', 'jeans', 'knit-trousers', 'slacks'],
            'outers' => ['down-jacket', 'duffle-coat',  'boa-jacket', 'chester-coat', 'balmacaan-coat', 'pea-coat', 'down-coat', 'boa-coat', 'trench-coat'],
        ],
    ],
];
