<?php

namespace Cboxdk\StatamicOverseer\Widgets;

use Statamic\Widgets\Widget;

class StatamicOverseer extends Widget
{
    /**
     * The HTML that should be shown in the widget.
     *
     * @return string|\Illuminate\View\View
     */
    public function html()
    {
        return view('statamic_overseer::widgets.statamic_overseer');
    }
}
