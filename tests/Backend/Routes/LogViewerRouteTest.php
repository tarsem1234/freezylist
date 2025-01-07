<?php

namespace Tests\Backend\Routes;

use Tests\BrowserKitTestCase;

/**
 * Class LogViewerRouteTest.
 */
class LogViewerRouteTest extends BrowserKitTestCase
{
    public function testLogViewerDashboard(): void
    {
        $this->actingAs($this->admin)
            ->visit('/admin/log-viewer')
            ->see('Log Viewer');
    }

    public function testLogViewerList(): void
    {
        $this->actingAs($this->admin)
            ->visit('/admin/log-viewer/logs')
            ->see('Logs');
    }

    public function testLogViewerSingle(): void
    {
        $this->actingAs($this->admin)
            ->visit('/admin/log-viewer/logs/'.date('Y-m-d'))
            ->see('Log ['.date('Y-m-d').']');
    }

    public function testLogViewerSingleType(): void
    {
        $this->actingAs($this->admin)
            ->visit('/admin/log-viewer/logs/'.date('Y-m-d').'/error')
            ->see('Log ['.date('Y-m-d').']');
    }
}
