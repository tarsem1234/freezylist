<!-- Left side column. contains the logo and sidebar -->
<div class="collapse navbar-collapse" id="toggle-navbar">
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ access()->user()->picture }}" class="img-circle" alt="User Image" />
                </div><!--pull-left-->
                <div class="pull-left info">
                    <p>{{ access()->user()->full_name }}</p>
                    <!-- Status -->
                </div><!--pull-left-->  
            </div><!--user-panel-->

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <li class="header">{{ trans('menus.backend.sidebar.general') }}</li>

                <li class="{{ active_class(Active::checkUriPattern('admin/dashboard')) }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fa fa-dashboard"></i>
                        <span>{{ trans('menus.backend.sidebar.dashboard') }}</span>
                    </a>
                </li>

                <li class="{{ active_class(Active::checkUriPattern('admin/forums*')) }}">
                    <a href="{{ route('admin.forums.index') }}">
                        <i class="fa fa-forumbee" aria-hidden="true"></i>
                        <span>Forum</span>
                    </a>
                </li>

                <li class="{{ active_class(Active::checkUriPattern('admin/blogs*')) }} ">

                    <a href="{{ route('admin.blogs.index') }}">
                        <i class="fa fa-list"></i>
                        <span>Blog</span>
                    </a>
                </li>
                <li class="{{ active_class(Active::checkUriPattern('admin/industries*')) }} ">
                    <a href="{{ route('admin.industries.index') }}">
                        <i class="fa fa-industry" aria-hidden="true"></i>
                        <span>Industry</span>
                    </a>
                </li>
                <li class="{{ active_class(Active::checkUriPattern('admin/services*')) }} ">
                    <a href="{{ route('admin.services.index') }}">
                        <i class="fa fa-server" aria-hidden="true"></i>
                        <span>Service</span> 
                    </a>
                </li>
                <li class="{{ active_class(Active::checkUriPattern('admin/pages*')) }} ">
                    <a href="{{ route('admin.pages.index') }}">
                        <i class="fa fa-file-text" aria-hidden="true"></i>
                        <span>CMS</span> 
                    </a>
                </li>
                <li class="{{ active_class(Active::checkUriPattern('admin/auto-email-logs')) }} ">  
                    <a href="{{ route('admin.autoEmailLogs') }}"> 
                        <i class="fa fa-envelope"></i> 
                        <span>Auto-Email Logs</span>  
                    </a>
                </li>
                <li class="{{ active_class(Active::checkUriPattern('admin/document-listing*')) }} ">
                    <a href="{{ route('admin.document-listing.index') }}">
                        <i class="fa fa-file" aria-hidden="true"></i>
                        <span>Document List</span>
                    </a>
                </li>
                <li class="{{ active_class(Active::checkUriPattern('admin/sale*')) }} ">
                    <a href="{{ route('admin.saleIndex') }}">
                        <i class="fa fa-home"></i>
                        <span>Sale List</span>
                    </a>
                </li>
                <li class="{{ active_class(Active::checkUriPattern('admin/rent*')) }} ">
                    <a href="{{ route('admin.rentIndex') }}">
                        <i class="fa fa-hotel"></i>
                        <span>Rent List</span>
                    </a>
                </li>
                <li class="{{ active_class(Active::checkUriPattern('admin/vacation*')) }} ">
                    <a href="{{ route('admin.vacationIndex') }}">
                        <i class="fa fa-spotify"></i>
                        <span>Vacation List</span>
                    </a>
                </li>
                <li class="{{ active_class(Active::checkUriPattern('admin/advertise-images*')) }} ">
                    <a href="{{ route('admin.advertise-images.index') }}">
                        <i class="fa fa-picture-o"></i>
                        <span>Advertise Images</span>
                    </a>
                </li>

                <li class="{{ active_class(Active::checkUriPattern('admin/learning-center/*')) }} treeview">
                    <a>
                        <i class="fa fa-graduation-cap"></i>
                        <span>Learning Center</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/learning-center/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/learning-center/*'), 'display: block;') }}">
                        <li class="{{ active_class(Active::checkUriPattern('admin/learning-center/categories*')) }}">
                            <a href="{{ route('admin.categories.index') }}">
                                <i class="fa fa-circle-o"></i>
                                <span>Categories</span>
                            </a>
                        </li>

                        <li class="{{ active_class(Active::checkUriPattern('admin/learning-center/sessions*')) }}">
                            <a href="{{ route('admin.sessions.index') }}">
                                <i class="fa fa-circle-o"></i>
                                <span>Sessions</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="{{ active_class(Active::checkUriPattern('admin/xml-feed/*')) }} treeview">
                    <a>
                        <i class="fa fa-shield"></i>
                        <span>XML Feed</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/xml-feed/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/xml-feed/*'), 'display: block;') }}">
                        <li class="{{ active_class(Active::checkUriPattern('admin/xml-feed/users')) }}">
                            <a href="{{ route('admin.xmlFeedIndex') }}">
                                <i class="fa fa-circle-o"></i>
                                <span>All Users</span>
                            </a>
                        </li>

                        <li class="{{ active_class(Active::checkUriPattern('admin/xml-feed/create*')) }}">
                            <a href="{{ route('admin.xmlFeedCreate') }}">
                                <i class="fa fa-circle-o"></i>
                                <span>Add New User</span>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="header">{{ trans('menus.backend.sidebar.system') }}</li>

                @role(1)
                <li class="{{ active_class(Active::checkUriPattern('admin/access/*')) }} treeview">
                    <a href="#">
                        <i class="fa fa-users"></i>
                        <span>{{ trans('menus.backend.access.title') }}</span>

                        @if ($pending_approval > 0)
                        <span class="label label-danger pull-right">{{ $pending_approval }}</span>
                        @else
                        <i class="fa fa-angle-left pull-right"></i>
                        @endif
                    </a>

                    <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/access/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/access/*'), 'display: block;') }}">
                        <li class="{{ active_class(Active::checkUriPattern('admin/access/user*')) }}">
                            <a href="{{ route('admin.access.user.index') }}">
                                <i class="fa fa-circle-o"></i>
                                <span>{{ trans('labels.backend.access.users.management') }}</span>

                                @if ($pending_approval > 0)
                                <span class="label label-danger pull-right">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="{{ active_class(Active::checkUriPattern('admin/access/business*')) }}">
                            <a href="{{ route('admin.access.business.index') }}">
                                <i class="fa fa-circle-o"></i>
                                <span>Business Management</span>

                                @if ($pending_approval > 0)
                                <span class="label label-danger pull-right">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="{{ active_class(Active::checkUriPattern('admin/access/admin*')) }}">
                            <a href="{{ route('admin.access.admin.index') }}">
                                <i class="fa fa-circle-o"></i>
                                <span>Admin Management</span>

                                @if ($pending_approval > 0)
                                <span class="label label-danger pull-right">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>

                        <li class="{{ active_class(Active::checkUriPattern('admin/access/support*')) }}">
                            <a href="{{ route('admin.access.support.index') }}">
                                <i class="fa fa-circle-o"></i>
                                <span>Support Management</span>

                                @if ($pending_approval > 0)
                                <span class="label label-danger pull-right">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>

                        <li class="{{ active_class(Active::checkUriPattern('admin/access/role*')) }}">
                            <a href="{{ route('admin.access.role.index') }}">
                                <i class="fa fa-circle-o"></i>
                                <span>{{ trans('labels.backend.access.roles.management') }}</span>
                            </a>
                        </li>

                    </ul>
                </li>
                @endauth

                <li class="{{ active_class(Active::checkUriPattern('admin/log-viewer*')) }} treeview">
                    <a href="#">
                        <i class="fa fa-list"></i>
                        <span>{{ trans('menus.backend.log-viewer.main') }}</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'display: block;') }}">
                        <li class="{{ active_class(Active::checkUriPattern('admin/log-viewer')) }}">
                            <a href="{{ route('log-viewer::dashboard') }}">
                                <i class="fa fa-circle-o"></i>
                                <span>{{ trans('menus.backend.log-viewer.dashboard') }}</span>
                            </a>
                        </li>

                        <li class="{{ active_class(Active::checkUriPattern('admin/log-viewer/logs')) }}">
                            <a href="{{ route('log-viewer::logs.list') }}">
                                <i class="fa fa-circle-o"></i>
                                <span>{{ trans('menus.backend.log-viewer.logs') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul><!-- /.sidebar-menu -->
        </section><!-- /.sidebar -->
    </aside>
</div>