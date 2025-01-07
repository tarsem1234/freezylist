<?php

namespace App\Http\Controllers\Backend\Access\Role;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Access\Role\RoleRepository;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class RoleTableController.
 */
class RoleTableController extends Controller
{
    /**
     * @var RoleRepository
     */
    protected $roles;

    public function __construct(RoleRepository $roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function __invoke()
    {
        // dd($this->roles->getForDataTable());
        return DataTables::of($this->roles->getForDataTable())
            ->escapeColumns(['name', 'sort'])
            ->addColumn('permissions', function ($role) {
                if ($role->all) {
                    return '<span class="label label-success">'.trans('labels.general.all').'</span>';
                }

                return $role->permissions->count() ?
                    implode('<br/>', $role->permissions->pluck('display_name')->toArray()) :
                    '<span class="label label-danger">'.trans('labels.general.none').'</span>';
            })
            ->addColumn('users', function ($role) {
                return $role->users->count();
            })
            ->addColumn('actions', function ($role) {
                return $role->action_buttons;
            })
            ->make(true);
    }
}
