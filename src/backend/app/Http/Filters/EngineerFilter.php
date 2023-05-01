<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
class EngineerFilter extends AbstractFilter
{
    /** @var string */
    public const NAME = 'name';

    /** @var string */
    public const SURNAME = 'surname';

    /**
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [
            self::NAME => [$this, 'name'],
            self::SURNAME => [$this, 'surname'],
        ];
    }

    /**
     * @param Builder $builder
     * @param $value
     *
     * @return void
     */
    public function name(Builder $builder, $value): void
    {
        $builder->where('name', $value);
    }

    /**
     * @param Builder $builder
     * @param $value
     *
     * @return void
     */
    public function surname(Builder $builder, $value): void
    {
        $builder->where('surname', $value);
    }
}
