<?php

namespace App\Http\Controllers;

use App\Data\Example\PathParameters\ExampledPathParameterData;
use App\Data\Example\QueryParameters\ExampleQueryParameterData;
use App\Data\Shared\Swagger\Parameter\QueryParameter\ListQueryParameter;
use App\Data\Shared\Swagger\Parameter\QueryParameter\QueryParameter;
use App\Data\Shared\Swagger\Request\FormDataRequestBody;
use App\Data\Shared\Swagger\Request\JsonRequestBody;
use App\Data\Shared\Swagger\Response\SuccessItemResponse;
use App\Data\Shared\Swagger\Response\SuccessListResponse;
use App\Data\Shared\Swagger\Response\SuccessNoContentResponse;
use App\Models\User;
use OpenApi\Attributes as OAT;


#[
    OAT\PathItem(
        path: '/admin/admin/{id}',
        parameters: [
            new OAT\PathParameter(
                ref: '#/components/parameters/ExampleIdPathParameter',
            ),
        ],
    )
]
class ExampleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OAT\Get(path: '/admin/tests', tags: ['tests'])]
    #[SuccessItemResponse(true)]
    public function get_success_item()
    {
        //
    }

    #[OAT\Get(path: '/admin/tests/list', tags: ['tests'])]
    #[SuccessListResponse(User::class)]
    public function get_success_list()
    {
        //
    }

    #[OAT\Get(path: '/admin/tests/queryParameters', tags: ['tests'])]
    #[QueryParameter('name')]
    #[ListQueryParameter()]
    #[SuccessItemResponse(User::class)]
    public function get_query_parameters(ExampleQueryParameterData $query_parameters)
    {
        return [];
    }

    #[OAT\Post(path: '/admin/tests', tags: ['tests'])]
    #[JsonRequestBody(User::class)]
    #[SuccessNoContentResponse('User created successfully')]
    public function post_json(User $user)
    {
        //
    }

    #[OAT\Post(path: '/admin/tests/form_data', tags: ['tests'])]
    #[FormDataRequestBody(User::class)]
    #[SuccessNoContentResponse('User successfully created')]
    public function post_form_data(User $user)
    {
    }

    #[OAT\Get(path: '/admin/tests/{id}', tags: ['tests'])]
    #[SuccessItemResponse(User::class, 'Fetched item successfully')]
    public function show_item(ExampledPathParameterData $request)
    {

    }

    #[OAT\Patch(path: '/admin/tests/{id}', tags: ['tests'])]
    #[SuccessNoContentResponse('Update User Successfuly')]
    public function patch_json(ExampledPathParameterData $path_parameters, User $user)
    {

    }

    #[OAT\Delete(path: '/admin/tests/{id}', tags: ['tests'])]
    #[SuccessNoContentResponse('Item Deleted Successfully')]
    public function delete_json(ExampledPathParameterData $path_parameters)
    {

    }

}
