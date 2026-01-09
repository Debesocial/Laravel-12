<?php

namespace Modules\Organizational\App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAutoCode;

class Unit extends Model
{
    use HasAutoCode;

    protected $fillable = [
        'section_id',
        'code',
        'name',
        'created_by',
        'updated_by',
        'is_active'
    ];

    protected function getCodePrefix(): string
    {
        return 'UNT';
    }
}
