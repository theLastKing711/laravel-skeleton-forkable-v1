<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;

class CreateInvokableControllerWithData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:data-controller {name} {--path==} {--query==} {--post==} {--post-form==} {--patch==} {--patch-form==} {--get-one==} {--get-many==} {--delete-one} {--delete-many==} {--pagination==} ';

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

        $tag = strtolower(
            $class_name[0]
        ).'s'
        .$class_name[1]
        .'s';

        $main_route =
        strtolower(
            $class_name[0]
        )
        .'s'.'/'.
        strtolower(
            $class_name[1]
        ).'s';

        $input_file_name =
            $class_name[count($class_name) - 1];

        $file_class_name =
            $input_file_name.'Controller';

        $this->info($path);

        $this->info($class_name[0]);

        $augmented_path =
            explode(
                '\\',
                $path
            );

        array_splice($augmented_path, -1, 1);

        $real_path = implode('\\', $augmented_path);

        $data_path_option = $this->option('path');

        if ($data_path_option) {
            Artisan::call('make:data', [
                'name' => $data_path_option,
                '--path' => 'default',
            ]);
        }
        $path_class_import = '';

        $path_variable_declaration = '';

        $path_ref = 'usersTestPathParameterData';

        if ($this->option('path')) {

            $path_option = $this->option('path');

            $path_path =
            str_replace(
                '/',
                '\\',
                $path_option
            );

            $path_option_array =
            explode(
                '\\',
                $path_path,
            );

            $path_data_class =
                // $path_option_array[count($path_option_array) - 1].'Data';
                $path_option_array[count($path_option_array) - 1].'PathParameterData';

            $path_data_name =
                $path_data_class;

            $path_final_name = $path_path.'PathParameterData';

            $path_class_import = 'use App\Data\\'.$path_final_name;

            $path_variable_declaration = $path_data_name.' $pathId,';

            $path_ref =
            strtolower(
                $class_name[0]
            )
            .'s'
            .$path_data_class;
            // .'PathParameterData';

        }

        $data_query_option = $this->option('query');

        if ($data_query_option) {
            Artisan::call('make:data', [
                'name' => $data_query_option.'QueryParameter',
            ]);
        }
        $query_class_import = '';

        $query_variable_declaration = '';

        if ($this->option('query')) {

            $query_option = $this->option('query');

            $query_query =
            str_replace(
                '/',
                '\\',
                $query_option
            );

            $query_option_array =
            explode(
                '\\',
                $query_query,
            );

            $query_data_class =
                $query_option_array[count($query_option_array) - 1].'QueryParameterData';

            $query_data_name =
                $query_data_class;

            $query_final_name = $query_query.'QueryParameterData;';

            $query_class_import = 'use App\Data\\'.$query_final_name;

            $query_variable_declaration = $query_data_name.' $request,';

        }

        $post_option = $this->option('post');

        if ($post_option) {

            $post_path =
                str_replace(
                    '/',
                    '\\',
                    $post_option
                );

            $post_option_array =
            explode(
                '\\',
                $post_path,
            );

            $post_data_class =
                $post_option_array[count($post_option_array) - 1].'Data';

            $post_data_name =
                $post_data_class.'::class';

            $post_final_name = $post_path.'Data';

            $fileContents = <<<EOT
            <?php

            namespace App\Http\Controllers\\$real_path;


            use App\Http\Controllers\Controller;
            use App\Data\\$post_final_name;
            use App\Data\Shared\Swagger\Request\JsonRequestBody;
            use App\Data\Shared\Swagger\Response\SuccessNoContentResponse;
            use OpenApi\Attributes as OAT;

            class $file_class_name extends Controller
            {

                #[OAT\Post(path: '/$main_route', tags: ['$tag'])]
                #[JsonRequestBody($post_data_name)]
                #[SuccessNoContentResponse]
                public function __invoke($post_data_class \$request)
                {

                }
            }

            EOT;

            $written = \Storage::disk('app')
                ->put('Http\Controllers'.'\\'.$this->argument('name').'Controller.php', $fileContents);

            Artisan::call('make:data', [
                'name' => $post_option,
            ]);

            return;

        }

        $patch_option = $this->option('patch');

        if ($patch_option) {

            if ($patch_option == 'null') {

                $fileContents = <<<EOT
                <?php

                namespace App\Http\Controller\\$real_path;

                use App\Http\Controllers\Controller;
                use App\Data\Shared\Swagger\Response\SuccessNoContentResponse;
                use OpenApi\Attributes as OAT;

                #[
                    OAT\PathItem(
                        path: '/$main_route/{id}',
                        parameters: [
                            new OAT\PathParameter(
                                ref: '#/components/parameters/$path_ref',
                            ),
                        ],
                    ),
                ]
                class $file_class_name extends Controller
                {

                    #[OAT\Patch(path: '/$main_route/{id}', tags: ['$tag'])]
                    #[SuccessNoContentResponse]
                    public function __invoke($path_variable_declaration)
                    {

                    }
                }

                EOT;

                $written = \Storage::disk('app')
                    ->put('Http\Controllers'.'\\'.$this->argument('name').'Controller.php', $fileContents);

                return;
            }

            $patch_path =
                str_replace(
                    '/',
                    '\\',
                    $patch_option
                );

            $patch_option_array =
            explode(
                '\\',
                $patch_path,
            );

            $patch_data_class =
                $patch_option_array[count($patch_option_array) - 1].'Data';

            $patch_data_name =
                $patch_data_class.'::class';

            $patch_final_name = $patch_path.'Data';

            $fileContents = <<<EOT
            <?php

            namespace App\Http\Controller\\$real_path;


            use App\Http\Controllers\Controller;
            $path_class_import;
            use App\Data\\$patch_final_name;
            use App\Data\Shared\Swagger\Request\JsonRequestBody;
            use App\Data\Shared\Swagger\Response\SuccessNoContentResponse;
            use OpenApi\Attributes as OAT;

            #[
                OAT\PathItem(
                    path: '/$main_route/{id}',
                    parameters: [
                        new OAT\PathParameter(
                            ref: '#/components/parameters/$path_ref',
                        ),
                    ],
                ),
            ]
            class $file_class_name extends Controller
            {

                #[OAT\Patch(path: '/$main_route/{id}', tags: ['$tag'])]
                #[JsonRequestBody($patch_data_name)]
                #[SuccessNoContentResponse]
                public function __invoke($path_variable_declaration $patch_data_class \$request)
                {

                }
            }

            EOT;

            $written = \Storage::disk('app')
                ->put('Http\Controllers'.'\\'.$this->argument('name').'Controller.php', $fileContents);

            Artisan::call('make:data', [
                'name' => $post_option,
            ]);

            return;

        }

        $get_one_option = $this->option('get-one');

        if ($get_one_option) {

            $get_one_path =
            str_replace(
                '/',
                '\\',
                $get_one_option
            );

            $get_one_option_array =
            explode(
                '\\',
                $get_one_path,
            );

            $get_one_data_class =
                $get_one_option_array[count($get_one_option_array) - 1].'Data';

            $get_one_data_name =
                $get_one_data_class.'::class';

            $get_one_final_name = $get_one_path.'Data';

            $fileContents = <<<EOT
            <?php

            namespace App\Http\Controllers\\$real_path;

            use App\Http\Controllers\Controller;
            $path_class_import;
            use App\Data\\$get_one_final_name;
            use App\Data\Shared\Swagger\Response\SuccessItemResponse;
            use OpenApi\Attributes as OAT;

            #[
                OAT\PathItem(
                    path: '/$main_route/{id}',
                    parameters: [
                        new OAT\PathParameter(
                            ref: '#/components/parameters/$path_ref',
                        ),
                    ],
                ),
            ]
            class $file_class_name extends Controller
            {

                #[OAT\Get(path: '/$main_route/{id}', tags: ['$tag'])]
                #[SuccessItemResponse($get_one_data_name)]
                public function __invoke($path_variable_declaration)
                {

                }
            }

            EOT;

            $written = \Storage::disk('app')
                ->put('Http\Controllers'.'\\'.$this->argument('name').'Controller.php', $fileContents);

            Artisan::call('make:data', [
                'name' => $get_one_option,
            ]);

            return;

        }

        $get_many_option = $this->option('get-many');

        if ($get_many_option) {

            $get_many_path =
            str_replace(
                '/',
                '\\',
                $get_many_option
            );

            $get_many_option_array =
            explode(
                '\\',
                $get_many_path,
            );

            $get_many_data_class_without_data =
                $get_many_option_array[count($get_many_option_array) - 1];

            $get_many_data_class =
                $get_many_data_class_without_data.'Data';

            $get_many_data_name =
                $get_many_data_class.'::class';

            $get_many_final_name = $get_many_path.'Data';

            $this->info($this->option('pagination'));

            if ($this->option('pagination')) {

                $get_many_data_name = $get_many_data_class.

                $this->info('hello worlds');
                $query_option = $this->argument('name');

                $query_parameter_file_name = $input_file_name.'QueryParameterData';

                $pagination_class =
                    $get_many_data_class_without_data.'PaginationResultData';

                $pagination_path = $get_many_path.'PaginationResultData';

                $fileContents = <<<EOT
                <?php

                namespace App\Http\Controllers\\$real_path;

                use App\Data\\$real_path\\QueryParameters\\$query_parameter_file_name;
                use App\Http\Controllers\Controller;
                use App\Data\Shared\Swagger\Parameter\QueryParameter\QueryParameter;
                use App\Data\\$pagination_path;
                use App\Data\Shared\Swagger\Response\SuccessItemResponse;
                use OpenApi\Attributes as OAT;

                class $file_class_name extends Controller
                {

                    #[OAT\Get(path: '/$main_route', tags: ['$tag'])]
                    #[QueryParameter('page', 'integer')]
                    #[QueryParameter('perPage', 'integer')]
                    #[SuccessItemResponse($pagination_class::class)]
                    public function __invoke($query_parameter_file_name \$request)
                    {

                    }
                }

                EOT;

                $written = \Storage::disk('app')
                    ->put('Http\Controllers'.'\\'.$this->argument('name').'Controller.php', $fileContents);

                Artisan::call('make:data', [
                    'name' => $get_many_option,
                    '--pagination' => 'default',
                ]);

                Artisan::call('make:data', [
                    'name' => $get_many_option,
                ]);

                return;
            }

            $get_many_final_name = $get_many_path.'Data';

            $fileContents = <<<EOT
            <?php

            namespace App\Http\Controllers\\$real_path;

            $query_class_import
            use App\Http\Controllers\Controller;
            use App\Data\\$get_many_final_name;
            use App\Data\Shared\Swagger\Response\SuccessListResponse;
            use OpenApi\Attributes as OAT;

            class $file_class_name extends Controller
            {

                #[OAT\Get(path: '/$main_route', tags: ['$tag'])]
                #[SuccessListResponse($get_many_data_name)]
                public function __invoke($query_variable_declaration)
                {

                }
            }

            EOT;

            $written = \Storage::disk('app')
                ->put('Http\Controllers'.'\\'.$this->argument('name').'Controller.php', $fileContents);

            Artisan::call('make:data', [
                'name' => $get_many_option,
            ]);

            return;
        }

        $delete_one_option = $this->option('delete-one');

        if ($delete_one_option) {

            $fileContents = <<<EOT
            <?php

            namespace App\Http\Controllers\\$real_path;

            use App\Http\Controllers\Controller;
            $path_class_import;
            use App\Data\Shared\Swagger\Response\SuccessNoContentResponse;
            use OpenApi\Attributes as OAT;

            #[
                OAT\PathItem(
                    path: '/$main_route/{id}',
                    parameters: [
                        new OAT\PathParameter(
                            ref: '#/components/parameters/$path_ref',
                        ),
                    ],
                ),
            ]
            class $file_class_name extends Controller
            {

                #[OAT\Delete(path: '/$main_route/{id}', tags: ['$tag'])]
                #[SuccessNoContentResponse]
                public function __invoke($path_variable_declaration)
                {

                }
            }

            EOT;

            $written = \Storage::disk('app')
                ->put('Http\Controllers'.'\\'.$this->argument('name').'Controller.php', $fileContents);

            return;
        }

        $delete_many_option = $this->option('delete-many');

        if ($delete_many_option) {

            $delete_many_path =
                str_replace(
                    '/',
                    '\\',
                    $delete_many_option
                );

            $delete_many_option_array =
            explode(
                '\\',
                $delete_many_path,
            );

            $delete_many_final_form =
                $delete_many_path.'Data';

            $delete_many_data_class =
                $delete_many_option_array[count($delete_many_option_array) - 1].'Data';

            $delete_many_data_name =
                $delete_many_data_class.' $request';

            $fileContents = <<<EOT
            <?php

            namespace App\Http\Controllers\\$real_path;

            use App\Http\Controllers\Controller;
            use App\Data\Shared\Swagger\Parameter\QueryParameter\ListQueryParameter;
            use App\Data\Shared\Swagger\Response\SuccessNoContentResponse;
            use App\Data\\$delete_many_final_form;
            use OpenApi\Attributes as OAT;

            class $file_class_name extends Controller
            {

                #[OAT\Delete(path: ''/$main_route', tags: ['$tag'])]
                #[ListQueryParameter]
                #[SuccessNoContentResponse]
                public function __invoke($delete_many_data_name)
                {

                }
            }

            EOT;

            $written = \Storage::disk('app')
                ->put('Http\Controllers'.'\\'.$this->argument('name').'Controller.php', $fileContents);

            Artisan::call('make:data', [
                'name' => $delete_many_option,
                '--delete-many' => 'default',
            ]);

            return;
        }

        $post_form_option = $this->option('post-form');

        if ($post_form_option) {

            $post_form_path =
                str_replace(
                    '/',
                    '\\',
                    $post_form_option
                );

            $post_form_option_array =
            explode(
                '\\',
                $post_form_path,
            );

            $post_form_data_class =
                $post_form_option_array[count($post_form_option_array) - 1].'Data';

            $post_form_data_name =
                $post_form_data_class.'::class';

            $post_form_final_name = $post_form_path.'Data';

            $fileContents = <<<EOT
            <?php

            namespace App\Http\Controllers\\$real_path;


            use App\Http\Controllers\Controller;
            use App\Data\\$post_form_final_name;
            use App\Data\Shared\Swagger\Request\JsonRequestBody;
            use App\Data\Shared\Swagger\Response\SuccessNoContentResponse;
            use OpenApi\Attributes as OAT;

            class $file_class_name extends Controller
            {

                #[OAT\Post(path: ''/$main_route', tags: ['$tag'])]
                #[JsonRequestBody($post_form_data_name)]
                #[SuccessNoContentResponse]
                public function __invoke($post_form_data_class \$request)
                {

                }
            }

            EOT;

            $written = \Storage::disk('app')
                ->put('Http\Controllers'.'\\'.$this->argument('name').'Controller.php', $fileContents);

            Artisan::call('make:data', [
                'name' => $post_form_option,
            ]);

            return;

        }

        $patch_form_option = $this->option('patch-form');

        if ($patch_form_option) {

            $patch_form_path =
                str_replace(
                    '/',
                    '\\',
                    $patch_form_option
                );

            $patch_form_option_array =
            explode(
                '\\',
                $patch_form_path,
            );

            $patch_form_data_class =
                $patch_form_option_array[count($patch_form_option_array) - 1].'Data';

            $patch_form_data_name =
                $patch_form_data_class.'::class';

            $patch_form_final_name = $patch_form_path.'Data';

            $fileContents = <<<EOT
            <?php

            namespace App\Http\Controllers\\$real_path;


            use App\Http\Controllers\Controller;
            use App\Data\\$patch_form_final_name;
            use App\Data\Shared\Swagger\Request\FormDataRequestBody;
            use App\Data\Shared\Swagger\Response\SuccessNoContentResponse;
            use OpenApi\Attributes as OAT;

            #[
                OAT\PathItem(
                    path: '/$main_route/{id}',
                    parameters: [
                        new OAT\PathParameter(
                            ref: '#/components/parameters/$path_ref',
                        ),
                    ],
                ),
            ]
            class $file_class_name extends Controller
            {

                #[OAT\Patch(path: '/$main_route/{id}', tags: ['$tag'])]
                #[FormDataRequestBody($patch_form_data_name)]
                #[SuccessNoContentResponse]
                public function __invoke($patch_form_data_class \$request)
                {

                }
            }

            EOT;

            $written = \Storage::disk('app')
                ->put('Http\Controllers'.'\\'.$this->argument('name').'Controller.php', $fileContents);

            Artisan::call('make:data', [
                'name' => $patch_form_option,
            ]);

            return;
        }

        $fileContents = <<<EOT
            <?php

            namespace App\Http\Controllers\\$real_path;

            use App\Http\Controllers\Controller;
            use OpenApi\Attributes as OAT;

            #[
                OAT\PathItem(
                    path: '/$main_route/{id}',
                    parameters: [
                        new OAT\PathParameter(
                            ref: '#/components/parameters/testIdPathParameter',
                        ),
                    ],
                ),
            ]
            class $file_class_name extends Controller
            {

                #[OAT\Get(path: '/$main_route', tags: ['$tag'])]
                public function __invoke()
                {

                }
            }

            EOT;

        $written = \Storage::disk('app')
            ->put('Http\Controllers'.'\\'.$this->argument('name').'Controller.php', $fileContents);

    }
}
