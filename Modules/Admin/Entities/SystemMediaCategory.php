<?php

namespace Modules\Admin\Entities;

use Modules\Admin\Traits\ModelTree;

class SystemMediaCategory extends Model
{
    use ModelTree {
        delete as modelTreeDelete;
    }
    protected $fillable = ['parent_id', 'name'];
    protected $casts = [
        'parent_id' => 'integer',
    ];

    public function media()
    {
        return $this->hasMany(SystemMedia::class, 'category_id');
    }

    public function setParentIdAttribute($value)
    {
        $this->attributes['parent_id'] = $value ?: 0;
    }

    public function delete()
    {
        $res = $this->modelTreeDelete();
        $this->media()->update(['category_id' => 0]);

        return $res;
    }

    protected function orderColumn()
    {
        return 'id';
    }
}
