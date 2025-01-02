<?php

namespace Tests\Backend\Forms\Search;

use Tests\BrowserKitTestCase;

/**
 * Class SearchFormTest.
 */
class SearchFormTest extends BrowserKitTestCase
{
    public function testSearchPageWithNoQuery(): void
    {
        $this->actingAs($this->admin)
            ->visit('/admin/search')
            ->seePageIs('/admin/dashboard')
            ->see('Please enter a search term.');
    }

    public function testSearchFormRedirectsToResults(): void
    {
        $this->actingAs($this->admin)
            ->visit('/admin/dashboard')
            ->type('Test Query', 'q')
            ->press('search-btn')
            ->seePageIs('/admin/search?q=Test%20Query')
            ->see('Search Results for Test Query');
    }
}
