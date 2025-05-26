<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class GenerateColorTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
        protected $signature = 'translate:colors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate color translations for lang/ja/colors.php';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = storage_path('app/data/colors.csv');
        $rows = array_map('str_getcsv', file($path));
        $header = array_shift($rows); // ヘッダを除外

        $translations = [];
        foreach ($rows as $row) {
            $data = array_combine($header, $row);
            $translations[$data['name']] = $data['jp_name'];
        }

        // 出力するファイルのパス
        $file = resource_path('lang/ja/color.php');

        // dd($translations);

        // PHP配列として書き出し
        file_put_contents($file, "<?php\n\nreturn " . var_export($translations, true) . ";\n");

        $this->info('lang/ja/color.php generated successfully.');
    }
}
