<?php

namespace Modules\Organizational\App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasAutoCode;

class SubUnit extends Model
{
    use HasAutoCode;

    protected $fillable = [
        'unit_id',
        'code',
        'name',
        'created_by',
        'updated_by',
        'is_active'
    ];

    protected function getCodePrefix(): string
    {
        return 'SUB';
    }
}
