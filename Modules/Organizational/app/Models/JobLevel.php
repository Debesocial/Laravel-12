<?php

namespace Modules\Organizational\App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAutoCode;

class JobLevel extends Model
{
    use HasAutoCode;

    protected $fillable = [
        'position_id',
        'code',
        'name',
        'level_order',
        'created_by',
        'updated_by',
        'is_active'
    ];

    protected function getCodePrefix(): string
    {
        return 'JL';
    }
}
