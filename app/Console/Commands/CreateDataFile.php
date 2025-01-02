<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateDataFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:data {name} {--path}';

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

        /** @var string $path */
        $path =
            str_replace(
                '/',
                '\\',
                $this->argument('name')
            );

        $class_name =
            explode(
                '\\',
                $path
            );

        $augmented_path =
            explode(
                '\\',
                $path
            );

        array_splice($augmented_path, -1, 1);

        $real_path = implode('\\', $augmented_path);

        if ($this->option('path')) {

            $file_class_name =
                $class_name[count($class_name) - 1].'PathParameterData';

            $fileContents = <<<EOT
            <?php

            namespace App\Data\\$real_path;

            use Spatie\LaravelData\Attributes\Validation\Exists;
            use Spatie\LaravelData\Data;
            use OpenApi\Attributes as OAT;
            use Spatie\LaravelData\Attributes\FromRouteParameter;

            class $file_class_name extends Data
            {
                public function __construct(
                    #[
                        OAT\PathParameter(
                            parameter: 'testIdPathParameter', //the name used in ref
                            name: 'id',
                            schema: new OAT\Schema(
                                type: 'integer',
                            ),
                        ),
                        FromRouteParameter('id'),
                        Exists('tests', 'id')
                    ]
                    public int \$id,
                ) {
                }
            }

            EOT;

            $written = \Storage::disk('app')
                ->put('Data'.'\\'.$this->argument('name').'PathParameterData.php', $fileContents);

            if ($written) {
                $this->info('Created new Repo '.$this->argument('name').'Repository.php in App\Repositories.');
            } else {
                $this->info('Something went wrong');
            }

            return;
        }

        $file_class_name =
                $class_name[count($class_name) - 1].'Data';
        $fileContents = <<<EOT
        <?php

        namespace App\Data\\$real_path;

        use Spatie\LaravelData\Data;
        use Spatie\TypeScriptTransformer\Attributes\TypeScript;
        use OpenApi\Attributes as OAT;

        #[TypeScript]
        #[Oat\Schema()]
        class $file_class_name extends Data
        {
            public function __construct(

            ) {}

        }

        EOT;

        $written = \Storage::disk('app')
            ->put('Data'.'\\'.$this->argument('name').'Data.php', $fileContents);

        if ($written) {
            $this->info('Created new Repo '.$this->argument('name').'Repository.php in App\Repositories.');
        } else {
            $this->info('Something went wrong');
        }
    }
}
