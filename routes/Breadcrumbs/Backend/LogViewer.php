<?php

Breadcrumbs::for('log-viewer::dashboard', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.log-viewer.main'), url('admin/log-viewer'));
});

Breadcrumbs::for('log-viewer::logs.list', function ($breadcrumbs) {
    $breadcrumbs->parent('log-viewer::dashboard');
    $breadcrumbs->push(trans('menus.backend.log-viewer.logs'), url('admin/log-viewer/logs'));
});

Breadcrumbs::for('log-viewer::logs.show', function ($breadcrumbs, $date) {
    $breadcrumbs->parent('log-viewer::logs.list');
    $breadcrumbs->push($date, url('admin/log-viewer/'.$date));
});

Breadcrumbs::for('log-viewer::logs.filter', function ($breadcrumbs, $date, $filter) {
    $breadcrumbs->parent('log-viewer::logs.show', $date);
    $breadcrumbs->push(ucfirst($filter), url('admin/log-viewer/'.$date.'/'.$filter));
});
