<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class updatehandler extends Component
{

    public $update;
    public $compare;

    public function __construct(string $update,$compare)
    {
        $this->update = $update;
        $this->compare = $compare;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.update-handler');
    }
}
