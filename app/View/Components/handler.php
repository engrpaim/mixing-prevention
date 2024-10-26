<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class handler extends Component
{
    public $process;
    public $compare;
    public $compareErr;
    public function __construct(string $process,$compare, $compareErr)
    {
        $this->process = $process;
        $this->compare =$compare;
        $this->compareErr =$compareErr;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.handler');
    }
}
