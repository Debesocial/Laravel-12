<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait HasAutoCode
{
    /**
     * Boot the trait.
     * Auto-generate code before creating record.
     */
    protected static function bootHasAutoCode(): void
    {
        static::creating(function ($model) {

            // Skip if code already set (manual / seeder)
            if (!empty($model->code)) {
                return;
            }

            $prefix = $model->getCodePrefix();
            $column = $model->getCodeColumn();
            $length = $model->getCodeLength();

            $lastCode = DB::table($model->getTable())
                ->where($column, 'like', $prefix . '%')
                ->orderBy($column, 'desc')
                ->value($column);

            $nextNumber = 1;

            if ($lastCode) {
                $nextNumber = (int) substr($lastCode, strlen($prefix)) + 1;
            }

            $model->{$column} = $prefix . str_pad($nextNumber, $length, '0', STR_PAD_LEFT);
        });
    }

    /**
     * Prefix code (WAJIB override di model)
     */
    abstract protected function getCodePrefix(): string;

    /**
     * Code column name
     */
    protected function getCodeColumn(): string
    {
        return 'code';
    }

    /**
     * Numeric length
     */
    protected function getCodeLength(): int
    {
        return 3;
    }
}
