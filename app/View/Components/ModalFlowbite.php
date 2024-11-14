<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModalFlowbite extends Component
{
    /**
     * Create a new component instance.
     */
    public $id;
    public $title;
    public $footer;

    public function __construct($id, $title, $footer = '')
    {
        $this->id = $id;
        $this->title = $title;
        $this->footer = $footer;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal-flowbite');
    }
}
