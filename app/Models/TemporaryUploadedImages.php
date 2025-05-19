<?php

namespace App\Models;

use CloudinaryLabs\CloudinaryLaravel\CloudinaryEngine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TemporaryUploadedImages extends Model
{
    /** @use HasFactory<\Database\Factories\TemporaryUploadedImagesFactory> */
    use HasFactory;

    /**
     * Get the user that owns the TemporaryUploadedImages
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function fromCloudinaryUploadResponse(CloudinaryEngine $response_file, int $user_id): self
    {

        $response =
            $response_file
                ->getResponse();

        // first transformed file
        $first_eager_response =
            $response['eager'][0];

        // $media->file_url = $response_file->getSecurePath();
        // $media->size = $first_eager_response->getSize();

        $temporary_uploaded_image = new TemporaryUploadedImages;
        $temporary_uploaded_image->user_id = $user_id;
        $temporary_uploaded_image->public_id = $response_file->getPublicId();
        $temporary_uploaded_image->file_name = $response_file->getFileName();
        $temporary_uploaded_image->file_url = $first_eager_response['secure_url'];
        $temporary_uploaded_image->size = $first_eager_response['bytes'];
        $temporary_uploaded_image->file_type = $response_file->getFileType();

        return $temporary_uploaded_image;
    }
}
