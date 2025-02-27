<?php

namespace App\Models\Access\Role\Traits\Attribute;

/**
 * Class RoleAttribute.
 */
trait RoleAttribute
{
    public function getEditButtonAttribute(): string
    {
        return '<a href="'.route('admin.access.role.edit', $this).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.edit').'"></i></a> ';
    }

    public function getDeleteButtonAttribute(): string
    {
        //Can't delete master admin role
        if ($this->id != 1) {
            return '<a href="'.route('admin.access.role.destroy', $this).'"
                data-method="delete"
                data-trans-button-cancel="'.trans('buttons.general.cancel').'"
                data-trans-button-confirm="'.trans('buttons.general.crud.delete').'"
                data-trans-title="'.trans('strings.backend.general.are_you_sure').'"
                class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.delete').'"></i></a>';
        }

        return '';
    }

    public function getActionButtonsAttribute(): string
    {
        return $this->edit_button.$this->delete_button;
    }
}
