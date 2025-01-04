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
    protected $signature = 'make:data {name} {--path} {--delete-many}';

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

            $main_route =
            strtolower(
                $class_name[0]
            ).'s';

            $file_name =
                $class_name[count($class_name) - 1];

            $file_class_name =
                $file_name.'PathParameterData';

            $ref =
                $main_route.$file_name.'PathParameterData';

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
                            parameter: '$ref', //the name used in ref
                            name: 'id',
                            schema: new OAT\Schema(
                                type: 'integer',
                            ),
                        ),
                        FromRouteParameter('id'),
                        Exists('$main_route', 'id')
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

        if ($this->option('delete-many')) {
            $collection_import =
                'use Illuminate\Support\Collection';

            $array_property_import =
             'use App\Data\Shared\Swagger\Property\ArrayProperty;';

            $delete_many_data =
            '#[ArrayProperty]
            public Collection $ids,';

            $fileContents = <<<EOT
            <?php

            namespace App\Data\\$real_path;
            $array_property_import;
            $collection_import;
            use Spatie\LaravelData\Data;
            use Spatie\TypeScriptTransformer\Attributes\TypeScript;
            use OpenApi\Attributes as OAT;


            #[TypeScript]
            #[Oat\Schema()]
            class $file_class_name extends Data
            {
                public function __construct(
                    $delete_many_data
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

            return;
        }

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
