<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CreateDataFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:data {name} {--path} {--delete-many} {--pagination}';

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

        $this->info('hello world');

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

            $written = Storage::disk('app')
                ->put('Data'.'\\'.$this->argument('name').'PathParameterData.php', $fileContents);

            if ($written) {
                $this->info('Created new Repo '.$this->argument('name').'Repository.php in App\Repositories.');
            } else {
                $this->info('Something went wrong');
            }

            return;
        }

        $file_class_name_without_data =
            $class_name[count($class_name) - 1];

        $file_class_name =
            $file_class_name_without_data.'Data';

        $pagination_option = $this->option('pagination');

        $this->info('hello world');

        if ($pagination_option) {

            // /** @var string $path */
            // $pagination_path =
            // str_replace(
            //     '/',
            //     '\\',
            //     $this->argument('pagination')
            // );

            // $pagination_class_name =
            //     explode(
            //         '\\',
            //         $pagination_path
            //     );

            // $pagination_augmented_path =
            //     explode(
            //         '\\',
            //         $pagination_path
            //     ).'Data';

            // $pagination_file_class_name =
            //     $pagination_class_name[count($class_name) - 1].'Data';

            // $file_class_name =
            //     $file_class_name_without_data.'PaginationResultData';

            // $pagination_data_class = $pagination_option

            $file_class_name =
                $file_class_name_without_data.'PaginationResultData';

            $child_class_name = $file_class_name_without_data.'Data';

            $fileContents = <<<EOT
            <?php

            namespace App\Data\\$real_path;

            use App\Data\\$real_path\\$child_class_name;
            use App\Data\Shared\Pagination\PaginationResultData;
            use App\Data\Shared\Swagger\Property\ArrayProperty;
            use Illuminate\Support\Collection;
            use OpenApi\Attributes as OAT;

            #[TypeScript]
            #[Oat\Schema()]
            class $file_class_name  extends PaginationResultData
            {
                /** @param Collection<int, $child_class_name> \$data */
                public function __construct(
                    int \$current_page,
                    int \$per_page,
                    #[ArrayProperty($child_class_name::class)]
                    public Collection \$data,
                    int \$total
                ) {
                    parent::__construct(\$current_page, \$per_page, \$total);
                }
            }


            EOT;

            $written = Storage::disk('app')
                ->put('Data'.'\\'.$this->argument('name').'PaginationResultData.php', $fileContents);

            $file_class_name =
                $file_class_name_without_data.'QueryParameterData';

            $real_path = $real_path.'\\'.'QueryParameters';

            $fileContents = <<<EOT
            <?php

            namespace App\Data\\$real_path;

            use App\Data\Shared\Pagination\QueryParameters\PaginationQueryParameterData;

            class $file_class_name extends PaginationQueryParameterData
            {
                public function __construct(
                    ?int \$page,
                    ?int \$perPage,
                ) {
                    parent::__construct(\$page, \$perPage);
                }
            }

            EOT;

            $written = Storage::disk('app')
                ->put('Data'.'\\'.$real_path.'\\'.$file_class_name.'Data.php', $fileContents);

            if ($written) {
                $this->info('Created new Repo '.$this->argument('name').'Repository.php in App\Repositories.');
            } else {
                $this->info('Something went wrong');
            }

            return;
        }

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

            $written = Storage::disk('app')
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

        $written = Storage::disk('app')
            ->put('Data'.'\\'.$this->argument('name').'Data.php', $fileContents);

        if ($written) {
            $this->info('Created new Repo '.$this->argument('name').'Repository.php in App\Repositories.');
        } else {
            $this->info('Something went wrong');
        }
    }
}
