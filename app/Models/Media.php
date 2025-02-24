<?php

namespace App\Models;

use CloudinaryLabs\CloudinaryLaravel\CloudinaryEngine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $medially_type
 * @property int $medially_id
 * @property string $file_url
 * @property string $file_name
 * @property string|null $file_type
 * @property int $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Database\Factories\MediaFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media query()
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereMediallyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereMediallyType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUpdatedAt($value)
 *
 * @property-read Model|\Eloquent $medially
 *
 * @method static joinRelationship()
 * @method static Illuminate\Database\Eloquent\Builder<static> orderByLeftPowerJoins(string|array<string, \Illuminate\Contracts\Database\Query\Expression> $column)
 * @method static Illuminate\Database\Eloquent\Builder<static> orderByLeftPowerJoinsCount(string $column, string|null $order)
 * @method static Illuminate\Database\Eloquent\Builder<static> orderByPowerJoins(string|array<string, \Illuminate\Contracts\Database\Query\Expression> $column)
 * @method static Illuminate\Database\Eloquent\Builder<static> orderByPowerJoinsAvg(string $column, string|null $order)
 * @method static Illuminate\Database\Eloquent\Builder<static> orderByPowerJoinsCount(string $column, string|null $order)
 * @method static Illuminate\Database\Eloquent\Builder<static> orderByPowerJoinsMax(string $column, string|null $order)
 * @method static Illuminate\Database\Eloquent\Builder<static> orderByPowerJoinsMin(string $column, string|null $order)
 * @method static Illuminate\Database\Eloquent\Builder<static> orderByPowerJoinsSum(string $column, string|null $order)
 * @method static Illuminate\Database\Eloquent\Builder<static> orderByPowerLeftJoinsAvg(string $column, string|null $order)
 * @method static Illuminate\Database\Eloquent\Builder<static> orderByPowerLeftJoinsMax(string $column, string|null $order)
 * @method static Illuminate\Database\Eloquent\Builder<static> orderByPowerLeftJoinsMin(string $column, string|null $order)
 * @method static Illuminate\Database\Eloquent\Builder<static> orderByPowerLeftJoinsSum(string $column, string|null $order)
 * @method static Illuminate\Database\Eloquent\Builder<static> powerJoinHas(string $relations, mixed operater, mixed value)
 * @method static Illuminate\Database\Eloquent\Builder<static> powerJoinWhereHas(string $relations, \Closure(Illuminate\Database\Query\JoinClause $join)|array $join_callback_or_array)
 *
 * @mixin \Eloquent
 */
class Media extends \CloudinaryLabs\CloudinaryLaravel\Model\Media
{
    protected $table = 'media';

    // we did made this custom media class that ovveride cloudinary's
    //to allow usage of factory for the model
    //and possibly add more features for the model in the future
    use HasFactory;

    public static function fromCloudinaryUploadResponse(CloudinaryEngine $response_file): self
    {

        $response =
            $response_file
                ->getResponse();

        $first_eager_response =
            $response['eager'][0];

        $media = new Media;
        $media->file_name = $response_file->getFileName();
        // $media->file_url = $response_file->getSecurePath();
        // $media->file_url = $response_file->getSecurePath();
        $media->file_url = $first_eager_response['secure_url'];
        // $media->size = $first_eager_response->getSize();
        $media->size = $first_eager_response['bytes'];
        $media->file_type = $response_file->getFileType();

        return $media;
    }
}
