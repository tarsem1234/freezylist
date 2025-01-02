<?php
if (isset($businessUsers) || (isset($business)  && $business != false)) {
   $titles['all'] = 'All Business Users';
   $titles['create'] = 'Create Business Users';
   $titles['deactivated'] = 'Deactivated Business Users';
   $titles['deleted'] = 'Deleted Business Users';
} elseif (isset($adminUsers) || (isset ($admin) && $admin != false)) {
   $titles['all'] = 'All Admin Users';
   $titles['create'] = 'Create Admin Users';
   $titles['deactivated'] = 'Deactivated Admin Users';
   $titles['deleted'] = 'Deleted Admin Users';
} else if (isset($supportUsers) || (isset ($support) && $support != false)) {
   $titles['all'] = 'All Support Users';
   $titles['create'] = 'Create Support Users';
   $titles['deactivated'] = 'Deactivated Support Users';
   $titles['deleted'] = 'Deleted Support Users';
} else {
   $titles['all'] = 'All Users';
   $titles['create'] = 'Create Users';
   $titles['deactivated'] = 'Deactivated  Users';
   $titles['deleted'] = 'Deleted Users';
}
$user = 'all User';
?>
<div class="pull-right mb-10 hidden-sm hidden-xs">
         <?php if(\Request::route()->getName() == "admin.access.business.index" || (isset($business) && $business != false)) { ?>
         {{ html()->a(route('admin.access.business.index', []), $titles['all'])->class('btn btn-primary btn-xs') }}
         {{ html()->a(route('admin.access.business.create', []), $titles['create'])->class('btn btn-success btn-xs') }}
         {{ html()->a(route('admin.access.business.deactivated', []), $titles['deactivated'])->class('btn btn-warning btn-xs') }}
         {{ html()->a(route('admin.access.business.deleted', []), $titles['deleted'])->class('btn btn-danger btn-xs') }}
         <?php } elseif(\Request::route()->getName() == "admin.access.admin.index" || (isset ($admin) && $admin != false)) { ?>
         {{ html()->a(route('admin.access.admin.index', []), $titles['all'])->class('btn btn-primary btn-xs') }}
         {{ html()->a(route('admin.access.admin.create', []), $titles['create'])->class('btn btn-success btn-xs') }}
         {{ html()->a(route('admin.access.admin.deactivated', []), $titles['deactivated'])->class('btn btn-warning btn-xs') }}
         {{ html()->a(route('admin.access.admin.deleted', []), $titles['deleted'])->class('btn btn-danger btn-xs') }}
         <?php } elseif(\Request::route()->getName() == "admin.access.support.index" || (isset ($support) && $support != false)) { ?>
         {{ html()->a(route('admin.access.support.index', []), $titles['all'])->class('btn btn-primary btn-xs') }}
         {{ html()->a(route('admin.access.support.create', []), $titles['create'])->class('btn btn-success btn-xs') }}
         {{ html()->a(route('admin.access.support.deactivated', []), $titles['deactivated'])->class('btn btn-warning btn-xs') }}
         {{ html()->a(route('admin.access.support.deleted', []), $titles['deleted'])->class('btn btn-danger btn-xs') }}
         <?php } else { ?>
         {{ html()->a(route('admin.access.user.index', []), $titles['all'])->class('btn btn-primary btn-xs') }}
         {{ html()->a(route('admin.access.user.create', []), $titles['create'])->class('btn btn-success btn-xs') }}
         {{ html()->a(route('admin.access.user.deactivated', []), $titles['deactivated'])->class('btn btn-warning btn-xs') }}
         {{ html()->a(route('admin.access.user.deleted', []), $titles['deleted'])->class('btn btn-danger btn-xs') }}
         <?php } ?>
</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md">
   <div class="btn-group">
      <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
         {{ trans('menus.backend.access.users.main') }} <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
         <li>{{ html()->a(route('admin.access.user.index'), trans('menus.backend.access.users.all')) }}</li>
         @if(\Request::route()->getName() == "admin.access.user.index")
         <li>{{ html()->a(route('admin.access.user.create'), trans('menus.backend.access.users.create')) }}</li>
         @elseif(\Request::route()->getName() == "admin.access.business.index")
         <li>{{ html()->a(route('admin.access.business.create'), trans('menus.backend.access.users.business_create')) }}</li>
         @elseif(\Request::route()->getName() == "admin.access.admin.index")
         <li>{{ html()->a(route('admin.access.admin.create'), trans('menus.backend.access.users.admin_create')) }}</li>
         @elseif(\Request::route()->getName() == "admin.access.support.index")
         <li>{{ html()->a(route('admin.access.support.create'), trans('menus.backend.access.users.support_create')) }}</li>
         @endif
         <li class="divider"></li>
         <li>{{ html()->a(route('admin.access.user.deactivated'), trans('menus.backend.access.users.deactivated')) }}</li>
         <li>{{ html()->a(route('admin.access.user.deleted'), trans('menus.backend.access.users.deleted')) }}</li>
      </ul>
   </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>