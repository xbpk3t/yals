<?php
namespace Utils;

use Illuminate\Support\Facades\Redis;

class RedisUtils
{
    public $redis;

    public $dbName = 'list_data';
    public $dbNameSort = 'list_data_sort';

    protected $nowStamp;
    protected $todayFormat;
    protected $currentMonth;

    public function __construct()
    {
        $this->redis = Redis::connection();
        $this->nowStamp = time();
        $this->todayFormat = todayDate();
        $this->currentMonth = date('Y-m', time());
    }

    /**
     * @param string $key
     *
     * @return int
     */
    public function isKeyExist(string $key): bool
    {
        return $this->redis->exists($key);
    }

    /**
     * todo matchKeys有问题
     *
     * @param string ...$redisKeys
     *
     * @return string
     */
    public function deleteRedisKeys(string ...$redisKeys)
    {
        try {
            $list = $this->matchKeys($redisKeys);

            if (0 === count($list)) {
                return 'empty';
            }

            $this->redis->del($list);

            return 'success';
        } catch (\Exception $e) {
            return 'fail';
        }

//        dd($redisKeyList);
    }

    /**
     * 模糊匹配所有的key.
     *
     * @param array $redisKeys
     *
     * @return array
     */
    public function matchKeys(array $redisKeys): array
    {
        // 一直scan到cursor为0为止
        Redis::setOption(\Redis::OPT_SCAN, \Redis::SCAN_RETRY);

        $list = collect($redisKeys)->map(function ($item, $key) {
            return $redisKeyArr[$key] = $this->redis->scan(null, $item);
        })->flatten()->toArray();

        return $list;
    }

    /**
     * @description: 获取列表
     * @author: injurys
     *
     * @param int    $page
     * @param int    $pageSize
     * @param array  $field
     * @param string $sort
     *
     * @return array
     */
    public function getPageList($page = 1, $pageSize = 20, $field = [], $sort = 'asc')
    {
        if (!is_numeric($page) || !is_numeric($pageSize)) {
            return [];
        }
        $pageSize = ($pageSize < 1 || $pageSize > 100) ? 20 : $pageSize;
        $limitStart = ($page - 1) * $pageSize;       //查询开始索引
        $limitEnd = $limitStart + $pageSize - 1;   //查询结束索引
        if ('asc' == $sort) {
            $range = $this->redis->zRange($this->dbNameSort, $limitStart, $limitEnd);
        } else {
            $range = $this->redis->zRevRange($this->dbNameSort, $limitStart, $limitEnd);
        }

        $count = $this->redis->zCard($this->dbNameSort);
        $pageCount = ceil($count / $pageSize); //总共多少页
        $pageList = [];
        foreach ($range as $id) {
            $pageList[] = $this->getHashData($this->dbName . '_' . $id, $field);
        }
        $data = [
            'list' => $pageList,
            'count' => $count,
            'pageCount' => $pageCount,
        ];

        return $data;
    }

    /**
     * @description: 添加纪录
     * @author: injurys
     *
     * @param int   $id   记录ID
     * @param array $data 数据详情
     *
     * @return bool
     */
    public function addDataBase($id, $data = [])
    {
        if (empty($id) || empty($data) || !is_array($data)) {
            return false;
        }
        $this->pushHashData($this->dbName . '_' . $id, $data);
        $this->redis->zAdd($this->dbNameSort, $id, $id);

        return true;
    }

    /**
     * @description: 删除一条数据
     * @author: injurys
     *
     * @param int $id 主键ID
     *
     * @return bool
     */
    public function delDataBase($id = 0)
    {
        if (empty($id)) {
            return false;
        }
        $this->hDel($this->dbName . '_' . $id);
        $this->delZsetData($this->dbNameSort, $id);

        return true;
    }

    /**
     * @description: Hash存储
     * @author: injurys
     *
     * @param string $tableName 存储表名
     * @param array  $info      存储数据
     *
     * @return bool|int
     */
    public function pushHashData($tableName = 'table', $info = [])
    {
        $data = [];
        foreach ($info as $k => $v) {
            $data[$k] = json_encode($v, JSON_UNESCAPED_SLASHES);
        }

        return $this->redis->hMset($tableName, $data);
    }

    /**
     * @description: 移除Zset指定数据
     * @author: injurys
     *
     * @param string       $tableName 存储表名
     * @param string|array $value     内容
     *                                字符串 删除单个 'key1'
     *                                数组  删除多个 ['key1', 'key2']
     *
     * @return int
     */
    public function delZsetData($tableName = 'table', $value = '')
    {
        if (is_array($value)) {
            foreach ($value as $k) {
                $this->redis->zRem($tableName, $k);
            }

            return 1;
        }

        return $this->redis->zRem($tableName, $value);
    }

    /**
     * @description: 删除Hash数据
     * @author: injurys
     *
     * @param string $tableName 存储表名
     * @param string $key       删除的键 (为空删除所有)
     *
     * @return bool|int
     */
    public function hDel($tableName = 'table', $key = '')
    {
        if (empty($key)) {
            $name = $this->redis->hGetAll($tableName);
            if ($name) {
                foreach ($name as $k => $n) {
                    $this->redis->hDel($tableName, $k);
                }
            }

            return 1;
        }

        return $this->redis->hDel($tableName, $key);
    }

    public function set($key, $val)
    {
        return $this->redis->set($key, $val);
    }

    public function get($key):string
    {
        return $this->redis->get($key);
    }

    public function exists($key):bool
    {
        return $this->redis->exists($key) == 1;
    }
}
