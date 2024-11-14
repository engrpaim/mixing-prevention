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
    public $min;
    public $max;

    public function __construct($fifth,$min,$max)
    {
        //
        $this->fifth = $fifth;
        $this->min = $min;
        $this->max = $max;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.specstable2');
    }
}
