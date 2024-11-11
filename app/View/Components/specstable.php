<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class specstable extends Component
{
    /**
     * Create a new component instance.
     */
    public $fourth;
    public function __construct($fourth)
    {
        //
        $this->fourth = $fourth;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.specstable');
    }
}
