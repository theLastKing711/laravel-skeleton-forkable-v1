<?php

namespace App\Http\Controllers\Student\OpenCourseRegisteration;

use App\Data\Student\OpenCourseRegisteration\QueryParameters\GetStudentRegisteredOpenCoursesQueryParameterData;
use App\Http\Controllers\Controller;
use App\Data\Shared\Swagger\Parameter\QueryParameter\QueryParameter;
use App\Data\Student\OpenCourseRegisteration\GetStudentRegisteredOpenCourses\Response\GetStudentRegisteredOpenCoursesResponsePaginationResultData;
use App\Data\Shared\Swagger\Response\SuccessItemResponse;
use OpenApi\Attributes as OAT;

class GetStudentRegisteredOpenCoursesController extends Controller
{

    #[OAT\Get(path: '/students/opencourseregisterations', tags: ['studentsOpenCourseRegisterations'])]
    #[QueryParameter('page', 'integer')]
    #[QueryParameter('perPage', 'integer')]
    #[SuccessItemResponse(GetStudentRegisteredOpenCoursesResponsePaginationResultData::class)]
    public function __invoke(GetStudentRegisteredOpenCoursesQueryParameterData $request)
    {

    }
}
