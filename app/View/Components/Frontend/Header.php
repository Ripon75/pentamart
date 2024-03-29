<?php

namespace App\View\Components\Frontend;

use App\Models\Cart;
use App\Models\Address;
use App\Models\District;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class Header extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // TODO: Get all data from config or db
        $customerId = Auth::id();
        $carObj     = new Cart();
        $cart       = $carObj->getCurrentCustomerCart();
        $areas       = District::orderBy('name', 'asc')->get();
        $userAddress = Address::where('user_id', $customerId)->orderBy('id', 'desc')->get();
        $menus       = [
            [ 'label' => 'Home', 'route' => route('home') ],
            [ 'label' => 'Products', 'route' => route('products.index')],
            [ 'label' => 'Category', 'route' => '#'],
            [ 'label' => 'My Order', 'route' => route('my.order')],
            [ 'label' => 'About', 'route' => route('about')],
            [ 'label' => 'Contact', 'route' => route('contact')],
        ];

        return view('components.frontend.header', [
            'logo'        => [ 'route' => 'home', 'imgSRC' => '/images/logos/logo.png' ],
            'menus'       => $menus,
            'cart'        => $cart,
            'areas'       => $areas,
            'userAddress' => $userAddress
        ]);
    }
}
