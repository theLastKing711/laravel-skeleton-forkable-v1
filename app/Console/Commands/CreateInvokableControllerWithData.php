<?php

namespace App\Console\Commands;

use Artisan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CreateInvokableControllerWithData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:data-controller {name} {--path==} {--post==} {--post-form==} {--patch==} {--patch-form==} {--get-one==} {--get-many==} {--delete-one}';

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

        // Log::info($path);

        $class_name =
            explode(
                '\\',
                $path
            );

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

            namespace App\Controller\\$real_path;


            use App\Http\Controllers\Controller;
            use App\Data\\$post_final_name;
            use App\Data\Shared\Swagger\Request\JsonRequestBody;
            use App\Data\Shared\Swagger\Response\SuccessNoContentResponse;
            use OpenApi\Attributes as OAT;

            class $file_class_name extends Controller
            {

                #[OAT\Post(path: 'tests', tags: ['tests'])]
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

            namespace App\Controller\\$real_path;


            use App\Http\Controllers\Controller;
            use App\Data\\$patch_final_name;
            use App\Data\Shared\Swagger\Request\JsonRequestBody;
            use App\Data\Shared\Swagger\Response\SuccessNoContentResponse;
            use OpenApi\Attributes as OAT;

            class $file_class_name extends Controller
            {

                #[OAT\Patch(path: 'tests/{id}', tags: ['tests'])]
                #[JsonRequestBody($patch_data_name)]
                #[SuccessNoContentResponse]
                public function __invoke($patch_data_class \$request)
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

            namespace App\Controller\\$path;

            use App\Http\Controllers\Controller;
            use App\Data\\$get_one_final_name;
            use App\Data\Shared\Swagger\Response\SuccessItemResponse;
            use OpenApi\Attributes as OAT;

            #[
                OAT\PathItem(
                    path: '/tests/{id}',
                    parameters: [
                        new OAT\PathParameter(
                            ref: '#/components/parameters/testIdPathParameter',
                        ),
                    ],
                ),
            ]
            class $file_class_name extends Controller
            {

                #[OAT\Get(path: '/tests/{id}', tags: ['tests'])]
                #[SuccessItemResponse($get_one_data_name)]
                public function __invoke()
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

            $get_many_data_class =
                $get_many_option_array[count($get_many_option_array) - 1].'Data';

            $get_many_data_name =
                $get_many_data_class.'::class';

            $get_many_final_name = $get_many_path.'Data';

            $fileContents = <<<EOT
            <?php

            namespace App\Controller\\$path;

            use App\Http\Controllers\Controller;
            use App\Data\\$get_many_final_name;
            use App\Data\Shared\Swagger\Response\SuccessListResponse;
            use OpenApi\Attributes as OAT;

            class $file_class_name extends Controller
            {

                #[OAT\Get(path: '/tests/{id}', tags: ['tests'])]
                #[SuccessListResponse($get_many_data_name)]
                public function __invoke()
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

            // $delete_one_path =
            // str_replace(
            //     '/',
            //     '\\',
            //     $delete_one_option
            // );

            // $delete_one_option_array =
            // explode(
            //     '\\',
            //     $delete_one_path,
            // );

            // $delete_one_data_class =
            //     $delete_one_option_array[count($delete_one_option_array) - 1].'Data';

            // $delete_one_data_name =
            //     $delete_one_data_class.'::class';

            // $delete_one_final_name = $delete_one_path.'Data';

            $fileContents = <<<EOT
            <?php

            namespace App\Controller\\$path;

            use App\Http\Controllers\Controller;
            use App\Data\Shared\Swagger\Response\SuccessNoContentResponse;
            use OpenApi\Attributes as OAT;

            #[
                OAT\PathItem(
                    path: '/tests/{id}',
                    parameters: [
                        new OAT\PathParameter(
                            ref: '#/components/parameters/testIdPathParameter',
                        ),
                    ],
                ),
            ]
            class $file_class_name extends Controller
            {

                #[OAT\Delete(path: '/tests/{id}', tags: ['tests'])]
                #[SuccessNoContentResponse]
                public function __invoke()
                {

                }
            }

            EOT;

            $written = \Storage::disk('app')
                ->put('Http\Controllers'.'\\'.$this->argument('name').'Controller.php', $fileContents);

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

            namespace App\Controller\\$real_path;


            use App\Http\Controllers\Controller;
            use App\Data\\$post_form_final_name;
            use App\Data\Shared\Swagger\Request\JsonRequestBody;
            use App\Data\Shared\Swagger\Response\SuccessNoContentResponse;
            use OpenApi\Attributes as OAT;

            class $file_class_name extends Controller
            {

                #[OAT\Post(path: 'tests', tags: ['tests'])]
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

            namespace App\Controller\\$real_path;


            use App\Http\Controllers\Controller;
            use App\Data\\$patch_form_final_name;
            use App\Data\Shared\Swagger\Request\FormDataRequestBody;
            use App\Data\Shared\Swagger\Response\SuccessNoContentResponse;
            use OpenApi\Attributes as OAT;

            class $file_class_name extends Controller
            {

                #[OAT\Patch(path: 'tests/{id}', tags: ['tests'])]
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

            namespace App\Controller\\$real_path;

            use App\Http\Controllers\Controller;
            use OpenApi\Attributes as OAT;

            #[
                OAT\PathItem(
                    path: '/tests/{id}',
                    parameters: [
                        new OAT\PathParameter(
                            ref: '#/components/parameters/testIdPathParameter',
                        ),
                    ],
                ),
            ]
            class $file_class_name extends Controller
            {

                #[OAT\Get(path: 'tests', tags: ['tests'])]
                public function __invoke()
                {

                }
            }

            EOT;

        $written = \Storage::disk('app')
            ->put('Http\Controllers'.'\\'.$this->argument('name').'Controller.php', $fileContents);

    }
}
