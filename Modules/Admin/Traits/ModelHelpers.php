<?php

namespace Modules\Admin\Traits;

use Modules\Admin\Filters\Filter;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Builder;

/**
 * 通用模型中的方法.
 *
 * Trait ModelHelpers
 */
trait ModelHelpers
{
    /**
     * 最大每页数，避免瞎搞的人.
     *
     * @var int
     */
    protected $maxPerPage = 200;

    public function getPerPage()
    {
        $perPage = Request::get('per_page');
        $intPerPage = (int) $perPage;
        if (($intPerPage > 0) && ((string) $intPerPage === $perPage)) {
            return min($intPerPage, $this->maxPerPage);
        }

        return $this->perPage;
    }

    /**
     * 应用过滤器.
     *
     * @param Builder $builder
     * @param Filter  $filter
     *
     * @return mixed
     */
    public function scopeFilter(Builder $builder, Filter $filter)
    {
        return $filter->apply($builder);
    }
}
