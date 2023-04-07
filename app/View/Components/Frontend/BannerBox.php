<?php

namespace App\View\Components\Frontend;

use Illuminate\View\Component;

class BannerBox extends Component
{   public $type;
    public $preTitle;
    public $title;
    public $bgColor;
    public $imgSrc;
    public $postTitle;
    public $postTitleLink;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct ($type = 'default', $bgColor = null, $preTitle = null, $title, $imgSrc, $postTitle = null, $postTitleLink = null )
    {
        $this->type          = $type;
        $this->bgColor       = $bgColor ?? '#fff';
        $this->preTitle      = $preTitle;
        $this->title         = $title;
        $this->imgSrc        = $imgSrc;
        $this->postTitle     = $postTitle;
        $this->postTitleLink = $postTitleLink;
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
