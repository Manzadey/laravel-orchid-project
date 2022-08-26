<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\LogsActivity;
use Orchid\Attachment\Models\Attachment as BaseAttachment;

class Attachment extends BaseAttachment
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'original_name',
        'mime',
        'extension',
        'size',
        'path',
        'user_id',
        'description',
        'alt',
        'sort',
        'hash',
        'disk',
        'group',
        'manipulations',
    ];

    protected $casts = [
        'sort'          => 'integer',
        'manipulations' => 'json',
    ];
}
