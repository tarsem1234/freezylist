<?php

namespace App\Http\Composers;

use Illuminate\View\View;

/**
 * Class GlobalComposer.
 */
class GlobalComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with('logged_in_user', access()->user());
    }
}
