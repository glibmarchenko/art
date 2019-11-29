<?php

namespace App\Console\Commands;

use Barryvdh\TranslationManager\Models\Translation;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class BuildTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'build:translations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate lang.json from current php & database translations';

    /** @var \Illuminate\Filesystem\Filesystem  */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('inspire');
        $this->call('translations:import', ['--replace' => true]);
        $this->exportTranslations();
    }

    public function exportTranslations()
    {
        $locales = Translation::groupBy('locale')
            ->select('locale')
            ->get()
            ->pluck('locale');

        $groups = Translation::whereNotNull('value')->groupBy('group')->pluck('group');

        /** @var \Illuminate\Support\Collection $translationsValues */
        $translationsValues = Translation::whereNotNull('value')->get();

        $translations = [];
        foreach ($locales as $locale){
            foreach ($groups as $group){
                $translation = $translationsValues->where('status', 0)
                    ->where('locale', $locale)
                    ->where('group', $group)
                    ->pluck('value', 'key');

                $convertedTranslation = $this->convertDotToArray($translation);

                $translations[$locale][$group] = $convertedTranslation;
            }
        }

        //$path = public_path('static/lang.json');
        $path = resource_path('assets/web/vue/lang.json');

        $this->files->put($path, json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

    }

    protected function convertDotToArray($array) {
        $newArray = array();
        foreach($array as $key => $value) {
            $dots = explode(".", $key);
            if(count($dots) > 1) {
                $last = &$newArray[ $dots[0] ];
                foreach($dots as $k => $dot) {
                    if($k == 0) continue;
                    $last = &$last[$dot];
                }
                $last = $value;
            } else {
                $newArray[$key] = $value;
            }
        }
        return $newArray;
    }
}