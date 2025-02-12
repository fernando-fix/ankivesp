<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    private $configs = [
        [
            'name' => 'Prompt GPT',
            'key' => 'prompt_gpt',
            'value' => 'Exemplo de prompt',
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->configs as $config) {
            $new_config = Config::where('key', $config['key'])->first();
            if (!$new_config) {
                Config::create([
                    'name'  => $config['name'],
                    'key'   => $config['key'],
                    'value' => $config['value'],
                ]);
            }
        }
    }
}
