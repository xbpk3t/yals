<?php

namespace Modules\Common\Entities;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UploadFile extends Model
{
    const UPDATED_AT = null;
    protected $table = 'tz_upload_file';

    protected $guarded = ['id'];

    protected $casts = [
        'category_id' => 'integer',
        'size' => 'integer',
    ];

    protected $perPage = 30;

    // 删除文件(删除数据库+对应oss数据)
    public function delete()
    {
        DB::beginTransaction();

        $deleted = parent::delete();
        if (!$deleted) {
            throw new FileException('文件记录删除失败');
        }

        // 如果数据库中没有其他相同的文件，则删除物理文件
        if (!$this->hasSameFile()) {
            $storage = Storage::disk('uploads');
            // 如果文件存在，并且删除失败，则抛错
            if ($storage->exists($this->path) && !$storage->delete($this->path)) {
                DB::rollBack();
                throw new FileException('物理文件删除失败');
            }
        }

        DB::commit();

        return true;
    }

    /**
     * 数据库中是否还有相同文件的记录.
     *
     * @return bool
     */
    protected function hasSameFile()
    {
        return (bool) static::query()
            ->where('filename', $this->filename)
            ->where('id', '<>', $this->id)
            ->first();
    }
}
