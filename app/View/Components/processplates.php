<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class processplates extends Component
{
    public $processNumber;
    public $color;
    public $value;
    public function __construct($processNumber,$color,$value)
    {
       $this->processNumber = $processNumber;
       $this->color = $color;
       $this->value = $value;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.processplates');
    }
}
