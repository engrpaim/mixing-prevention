<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class showrange extends Component
{
    /**
     * Create a new component instance.
     */
    public $array;
    public function __construct($array)
    {
        //
        $this->array = $array;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.showrange');
    }
}
