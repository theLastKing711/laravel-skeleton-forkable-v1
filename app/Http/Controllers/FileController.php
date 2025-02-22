<?php

namespace App\Http\Controllers;

use App\Data\Shared\File\PathParameters\FilePublicIdPathParameterData;
use App\Data\Shared\File\UploadFileData;
use App\Data\Shared\File\UploadFileListData;
use App\Data\Shared\File\UploadFileResponseData;
use App\Data\Shared\Swagger\Request\FormDataRequestBody;
use App\Data\Shared\Swagger\Response\SuccessItemResponse;
use App\Data\Shared\Swagger\Response\SuccessListResponse;
use App\Data\Shared\Swagger\Response\SuccessNoContentResponse;
use App\Models\Media;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OAT;

#[
    OAT\PathItem(
        path: '/files/{id}',
        parameters: [
            new OAT\PathParameter(
                ref: '#/components/parameters/filesPublicIdPathParameterData',
            ),
        ],
    ),
]
class FileController extends Controller
{
    #[OAT\Get(path: '/admin/files', tags: ['files'])]
    #[SuccessNoContentResponse('File uploaded successfully')]
    public function index()
    {
        return [];
    }

    #[OAT\Post(path: '/files', tags: ['files'])]
    #[FormDataRequestBody(UploadFileData::class)]
    #[SuccessItemResponse(UploadFileResponseData::class, 'File uploaded successfully')]
    public function store(UploadFileData $uploadFileData, Request $request)
    {
        $file = $uploadFileData->file;

        Log::info(
            'accessing FileController with files {files}',
            ['files' => $file]
        );
        //        abort(404);
        Log::info('hello world');
        Log::info($uploadFileData);
        $file_path = $file->getRealPath();

        //https://cloudinary.com/documentation/image_upload_api_reference#upload_method
        //https://cloudinary.com/documentation/image_upload_api_reference
        //https://cloudinary.com/documentation/transformation_reference
        //https://cloudinary.com/documentation/image_optimization
        //https://cloudinary.com/documentation/eager_and_incoming_transformations#eager_transformations
        ///eager which apply multiple transformations on the fly during upload
        // and return multiple transformed images, as opposed the transformation
        //which works only on the main image and return it
        // alternative to eager is eager_async,
        //which apply transformation after upload request is done
        // when first visited by user i.e end-user using front end
        //https://cloudinary.com/documentation/transformation_reference
        // if width => value used with quality => auto will be the same as width => value alone
        // 'effect' => ['bgremoval|make_transparent'] to remove background  is bad and doesn't work
        $result = Cloudinary::upload($file_path, [
            'eager' => [ //list of transformation objects -> https://cloudinary.com/documentation/transformation_reference
                [
                    'width' => 500,
                    // 'height' => 500,
                    'crop' => 'pad',
                    // 'pad',
                    // 'scale' => 'auto',
                ],
            ],
            // 'eager' => [ //list of transformation objects -> https://cloudinary.com/documentation/transformation_reference
            //     //here we upload and get x images for the provided file_path in response where x is number of objects in below array
            //     // [
            //     //     'width' => 90,
            //     // ],
            //     [
            //         'width' => 700,
            //         'height' => 700,
            //         'crop' => 'pad',
            //         // 'pad',
            //         // 'scale' => 'auto',
            //     ],
            //     // [
            //     //     'width' => 700,
            //     //     // 'pad',
            //     //     // 'scale' => 'auto',
            //     // ],
            //     //             "width": 700,
            //     //   "height": 1941,
            //     //   "bytes": 148109,
            //     // 'transformation' => [ // transforms the uploaded image and return it with transformations applied to it in response
            //     //     // 'quality' => 'auto',
            //     // 'width' => 90,
            //     //     'effect' => [
            //     //         'make_transparent',
            //     //         // 'bgremoval',
            //     // ],
            //     //     // 'height' => 90,
            //     // ],
            // ],
            // 'transformation' => [
            //     'width' => 700,
            //     'quality' => 'auto',
            // ],
        ]);

        // get request response object
        $response = $result->getResponse();

        return $response;

        return new UploadFileResponseData(
            url: $eager_file['secure_url'],
            public_id: $eager_file['secure_url'],
        );

        // the url of the uploaded image -> real image on usage
        //example result: https:cloudinary$pathToImage
        $cloudinary_image_path = $result->getSecurePath();

        // unique identifer for the image can
        // can be used to get the image cloudinary resource
        // example result: jasldkjGAsdfkj
        $cloudinary_public_id = $result->getPublicId();

        Log::info($cloudinary_image_path);

        return new UploadFileResponseData(
            url: $cloudinary_image_path,
            public_id: $cloudinary_public_id,
        );
    }

    #[OAT\Post(path: '/files/many', tags: ['files'])]
    #[FormDataRequestBody(UploadFileListData::class)]
    #[SuccessListResponse(UploadFileListData::class, 'Files uploaded successfully')]
    public function storeMany(UploadFileListData $uploadFileData, Request $request)
    {
        Log::info($uploadFileData);

        $files = $uploadFileData->files;

        /** @var Collection<int, Media> $uploaded_medias */
        $session_uploaded_media = collect([]);

        /** @var Collection<int, Media> $uploaded_medias */
        $uploaded_medias_data = $files->map(
            function ($file) use ($session_uploaded_media) {

                Log::info(
                    'accessing FileController with files {files}',
                    ['files' => $file]
                );

                $file_path = $file->getRealPath();

                //https://cloudinary.com/documentation/image_upload_api_reference
                //https://cloudinary.com/documentation/transformation_reference
                //https://cloudinary.com/documentation/image_optimization
                //https://cloudinary.com/documentation/eager_and_incoming_transformations#eager_transformations
                ///eager which apply multiple transformations on the fly during upload
                // and return multiple transformed images, as opposed the transformation
                //which works only on the main image and return it
                // alternative to eager is eager_async,
                //which apply transformation after upload request is done
                // when first visited by user i.e end-user using front end
                //https://cloudinary.com/documentation/transformation_reference
                // if width => value used with quality => auto will be the same as width => value alone
                // 'effect' => ['bgremoval|make_transparent'] to remove background  is bad and doesn't work
                //return base image plus two images one with transformation of width 90 and auto height
                // and second is width 700 and height is 700 plus cropping
                $response = Cloudinary::upload($file_path, [
                    'eager' => [ //list of transformation objects -> https://cloudinary.com/documentation/transformation_reference
                        [
                            'width' => 500,
                            // 'height' => 500,
                            'crop' => 'pad',
                        ],
                        // [
                        //     'width' => 700,
                        // ],

                    ],
                ]);

                // get request response object
                // return $result->getResponse();
                // the url of the uploaded image -> real image on usage
                //example result: https:cloudinary$pathToImage
                // $cloudinary_image_path = $response->getSecurePath();

                // unique identifer for the image
                // can be used to get the image cloudinary resource
                // example result: jasldkjGAsdfkj
                // $cloudinary_public_id = $response->getPublicId();

                $uploaded_media = Media::fromCloudinaryUploadResponse($response);

                $session_uploaded_media->push($uploaded_media);

                return new UploadFileResponseData(
                    url: $uploaded_media->file_url,
                    public_id: $response->getPublicId()
                );
            }
        );

        $upload_cars_images_session_key = config('constants.session.upload_car_images');

        $request
            ->session()
            ->put(
                $upload_cars_images_session_key,
                $session_uploaded_media
            );

        \Storage::disk('app')
            ->put(
                'Test.php',
                $request
                    ->session()
                    ->get($upload_cars_images_session_key)
            );

        return $uploaded_medias_data;

    }

    //eager upload with 2 transformation response
    // {
    //     "asset_id": "e993e6a01e81b12c360e4ce2757cd9b9",
    //     "public_id": "sg8oi7r0xr3cknbddbe7",
    //     "version": 1729950437,
    //     "version_id": "e2d0f7ad394cf1c2bd0aeb4a116cc7cb",
    //     "signature": "84d708aec3b07af6444a12453dfa06c723a050c1",
    //     "width": 851,
    //     "height": 2360,
    //     "format": "jpg",
    //     "resource_type": "image",
    //     "created_at": "2024-10-26T13:47:17Z",
    //     "tags": [],
    //     "bytes": 427811,
    //     "type": "upload",
    //     "etag": "ace3b53cdb09459b36e05a621b765b02",
    //     "placeholder": false,
    //     "url": "http://res.cloudinary.com/dkmsfsa7c/image/upload/v1729950437/sg8oi7r0xr3cknbddbe7.jpg",
    //     "secure_url": "https://res.cloudinary.com/dkmsfsa7c/image/upload/v1729950437/sg8oi7r0xr3cknbddbe7.jpg",
    //     "folder": "",
    //     "original_filename": "phpZnCtHW",
    //     "eager": [
    //       {
    //         "transformation": "w_90",
    //         "width": 90,
    //         "height": 250,
    //         "bytes": 5323,
    //         "format": "jpg",
    //         "url": "http://res.cloudinary.com/dkmsfsa7c/image/upload/w_90/v1729950437/sg8oi7r0xr3cknbddbe7.jpg",
    //         "secure_url": "https://res.cloudinary.com/dkmsfsa7c/image/upload/w_90/v1729950437/sg8oi7r0xr3cknbddbe7.jpg"
    //       },
    //       {
    //         "transformation": "w_700",
    //         "width": 700,
    //         "height": 1941,
    //         "bytes": 148109,
    //         "format": "jpg",
    //         "url": "http://res.cloudinary.com/dkmsfsa7c/image/upload/w_700/v1729950437/sg8oi7r0xr3cknbddbe7.jpg",
    //         "secure_url": "https://res.cloudinary.com/dkmsfsa7c/image/upload/w_700/v1729950437/sg8oi7r0xr3cknbddbe7.jpg"
    //       }
    //     ],
    //     "api_key": "379721987165773"
    //   }

    #[OAT\Delete(path: '/files/{public_id}', tags: ['files'])]
    #[SuccessNoContentResponse]
    public function delete(FilePublicIdPathParameterData $deleteFileData)
    {
        \Storage::disk('app')
            ->put(
                'Test.php',
                $deleteFileData->public_id
            );

        Cloudinary::destroy($deleteFileData->public_id);

        \Storage::disk('app')
            ->put(
                'Test2.php',
                $deleteFileData->public_id
            );

        return 1;
    }
}
