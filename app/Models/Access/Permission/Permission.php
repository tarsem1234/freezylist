<?php

namespace App\Models\Access\Permission;

use App\Models\Access\Permission\Traits\Relationship\PermissionRelationship;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission.
 */
class Permission extends Model
{
    use PermissionRelationship;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'sort'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('access.permissions_table');
    }
}
