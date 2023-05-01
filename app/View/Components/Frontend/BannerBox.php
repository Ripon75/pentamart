<?php

namespace App\View\Components\Frontend;

use Illuminate\View\Component;

class BannerBox extends Component
{   public $type;
    public $title;
    public $linkTitle;
    public $link;
    public $bgColor;
    public $imgSrc;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct ($type = 'default', $title = null, $linkTitle = null, $link = null, $bgColor = null, $imgSrc = null )
    {
        $this->type      = $type;
        $this->title     = $title;
        $this->linkTitle = $linkTitle;
        $this->link      = $link;
        $this->bgColor   = $bgColor ?? '#fff';
        $this->imgSrc    = $imgSrc;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.frontend.banner-box');
    }
}
