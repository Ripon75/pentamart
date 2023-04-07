<?php

namespace App\View\Components\Frontend;

use Illuminate\View\Component;

class HeaderTitle extends Component
{
    public $type;
    public $bgColor;
    public $bgImageSrc;
    public $title;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $type = 'default', $bgColor = "#fff", $bgImageSrc = null)
    {
        $this->type       = $type;
        $this->bgColor    = $bgColor;
        $this->bgImageSrc = $bgImageSrc;
        $this->title      = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.frontend.header-title');
    }
}
