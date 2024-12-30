<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;

class CreateDataFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:data {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Laravel-Spatie-Data File';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        /** @var string $path  */
        $path =
            str_replace(
                '/',
                '\\',
                $this->argument('name')
            );

        // Log::info($path);


        $class_name=
            explode(
                '\\',
                $path
            );

            $this->info($path);


            $this->info($class_name[0]);


        $fileContents = <<<EOT
        <?php

        namespace App\Data\\$path;

        use Spatie\LaravelData\Data;
        use Spatie\TypeScriptTransformer\Attributes\TypeScript;
        use OpenApi\Attributes as OAT;

        #[TypeScript]
        class $class_name[0] extends Data
        {
            public function __construct()
            {

            }
        }

        EOT;


        $written = \Storage::disk('app')->put('Data'.'\\' .$this->argument('name') . 'Data.php', $fileContents);


        // if($written) {
        //     $this->info('Created new Repo '.$this->argument('name').'Repository.php in App\Repositories.');
        // } else {
        //     $this->info('Something went wrong');
        // }
    }
}
