<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * Class AbstractBaseModel.
 *
 * @see <https://github.com/barryvdh/laravel-ide-helper/pull/618#issuecomment-364657196> PHPDoc reason
 *
 * @method static Builder              select($columns = ['*'])
 * @method static Model|Builder        create($attributes = [])
 * @method static Builder              distinct()
 * @method static Model|Collection|static[]|static|null find($id, $columns = [])
 * @method static Model|Builder        forceCreate($attributes)
 * @method static Builder              inRandomOrder($seed = '')
 * @method static bool                 insert($query, $bindings = [])
 * @method static Builder|QueryBuilder orderBy($column, $direction = 'asc')
 * @method static Builder|QueryBuilder orderByDesc($column)
 * @method static Collection           pluck($column, $key = null)
 * @method static Model                updateOrCreate($attributes, $values = [])
 * @method static Builder              when($value, $callback, $default = null)
 * @method static Builder              where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder              whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static Builder|static       whereNotExists($callback, $boolean = 'and')
 * @method static Builder|static       whereNotNull($column, $boolean = 'and')
 * @method static Builder              whereNull($column, $boolean = 'and', $not = false)
 * @method static Builder join($table, $first, $operator = null, $second = null, $type = 'inner', $where = false)
 */
abstract class AbstractBaseModel extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Получить имя таблицы, связанной с моделью.
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return (new static)->getTable();
    }

    /**
     * Получить имя основного поля модели.
     *
     * @return string
     */
    public static function getPrimaryKeyName(): string
    {
        return (new static)->getKeyName();
    }
}
