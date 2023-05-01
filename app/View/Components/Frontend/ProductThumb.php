<?php

namespace App\View\Components\Frontend;

use Illuminate\View\Component;

class ProductThumb extends Component
{
    public $type;
    public $product;
    public $badgeLabel;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = "default", $product, $badgeLabel = null)
    {
        $this->type       = $type;
        $this->product    = $product;
        $this->badgeLabel = $badgeLabel;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.frontend.product-thumb', [
            'currency' => 'Tk'
        ]);
    }
}
