<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{

    public $name;
    public $show;
    public $placeholder;
    public $inputeId;
    public $inputName;
    public $buttonType;
    public $buttonOnclick;
    public $style;
    public $btnName;
    public $btnId;
    public $btnLabel;
    public $formName;
    public $formId;
    public $method;
    public $action;





    public function __construct(string  $name, $show, $placeholder,$inputeId,$inputName,$buttonType,$buttonOnclick,$style,$btnName,$btnId,$btnLabel,$formName,$formId,$method,$action)
    {

        $this->name = $name;
        $this->show = $show;
        $this->inputeId = $inputeId;
        $this->inputName = $inputName;
        $this->buttonType = $buttonType;
        $this->buttonOnclick = $buttonOnclick;
        $this->style = $style;
        $this->btnName = $btnName;
        $this->btnId = $btnId;
        $this->btnLabel = $btnLabel;
        $this->placeholder = $placeholder;
        $this->formName = $formName;
        $this->formId = $formId;
        $this->method = $method;
        $this->action = $action;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form');
    }
}
