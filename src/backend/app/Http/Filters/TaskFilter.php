<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class TaskFilter extends AbstractFilter
{
    /** @var string */
    public const TEXT = 'text';

    /** @var string */
    public const STATUS = 'status';

    /**
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [
            self::TEXT => [$this, 'text'],
            self::STATUS => [$this, 'status'],
        ];
    }

    /**
     * @param Builder $builder
     * @param $value
     *
     * @return void
     */
    public function text(Builder $builder, $value): void
    {
        $builder->where('text', 'like', "%{$value}%");
    }

    /**
     * @param Builder $builder
     * @param $value
     *
     * @return void
     */
    public function status(Builder $builder, $value): void
    {
        $builder->whereHas('status', function(Builder $query) use ($value) {
            $query->where('name', $value);
        });
    }
}
