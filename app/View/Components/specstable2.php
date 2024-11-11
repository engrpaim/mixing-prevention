<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class specstable2 extends Component
{
    /**
     * Create a new component instance.
     */
    public $fifth;

    public function __construct($fifth)
    {
        //
        $this->fifth = $fifth;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.specstable2');
    }
}
