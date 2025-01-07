<?php

namespace Tests\Backend\History;

use Tests\BrowserKitTestCase;

/**
 * Class HistoryRenderTest.
 */
class HistoryRenderTest extends BrowserKitTestCase
{
    public function testDashboardDisplaysHistory(): void
    {
        $this->actingAs($this->admin);

        history()
            ->withType('User')
            ->withText(trans('history.backend.users.created').$this->user->name)
            ->withEntity($this->user->id)
            ->withIcon('plus')
            ->withClass('bg-green')
            ->log();

        $this->visit('/admin/dashboard')
            ->see('<strong>'.$this->admin->name.'</strong> '.trans('history.backend.users.created').$this->user->name);
    }

    public function testTypeDisplaysHistory(): void
    {
        $this->actingAs($this->admin);

        history()
            ->withType('User')
            ->withText(trans('history.backend.users.created').$this->user->name)
            ->withEntity($this->user->id)
            ->withIcon('plus')
            ->withClass('bg-green')
            ->log();

        $this->visit('/admin/access/user')
            ->see('<strong>'.$this->admin->name.'</strong> '.trans('history.backend.users.created').$this->user->name);
    }

    public function testEntityDisplaysHistory(): void
    {
        $this->actingAs($this->admin);

        history()
            ->withType('User')
            ->withText(trans('history.backend.users.created').$this->user->name)
            ->withEntity($this->user->id)
            ->withIcon('plus')
            ->withClass('bg-green')
            ->log();

        $this->visit('/admin/access/user/3')
            ->see('<strong>'.$this->admin->name.'</strong> '.trans('history.backend.users.created').$this->user->name);
    }
}
