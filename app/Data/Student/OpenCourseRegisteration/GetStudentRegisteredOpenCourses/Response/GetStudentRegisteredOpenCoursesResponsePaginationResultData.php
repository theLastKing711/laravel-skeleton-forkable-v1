<?php

namespace App\Data\Student\OpenCourseRegisteration\GetStudentRegisteredOpenCourses\Response;

use App\Data\Student\OpenCourseRegisteration\GetStudentRegisteredOpenCourses\Response\GetStudentRegisteredOpenCoursesResponseData;
use App\Data\Shared\Pagination\PaginationResultData;
use App\Data\Shared\Swagger\Property\ArrayProperty;
use Illuminate\Support\Collection;
use OpenApi\Attributes as OAT;

#[TypeScript]
#[Oat\Schema()]
class GetStudentRegisteredOpenCoursesResponsePaginationResultData  extends PaginationResultData
{
    /** @param Collection<int, GetStudentRegisteredOpenCoursesResponseData> $data */
    public function __construct(
        int $current_page,
        int $per_page,
        #[ArrayProperty(GetStudentRegisteredOpenCoursesResponseData::class)]
        public Collection $data,
        int $total
    ) {
        parent::__construct($current_page, $per_page, $total);
    }
}

