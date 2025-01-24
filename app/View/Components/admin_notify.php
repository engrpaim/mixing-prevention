<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class admin_notify extends Component
{
    /**
     * Create a new component instance.
     */
    protected $notify;
    public function __construct($notify)
    {
        $this->notify = $notify;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin_notify');
    }
}
