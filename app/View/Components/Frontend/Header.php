<?php

namespace App\View\Components\Frontend;

use App\Models\Cart;
use App\Models\Area;
use App\Models\UserAddress;
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
        $cart       = $carObj->_getCurrentCustomerCart();
        $areas       = Area::orderBy('name', 'asc')->get();
        $userAddress = UserAddress::where('user_id', $customerId)->orderBy('id', 'desc')->get();
        $menus       = [
            // [ 'label' => 'Home', 'route' => route('home') ],
            [ 'label' => 'Personal Care', 'route' => route('tag.page', ['personal-care'])],
            [ 'label' => 'Medical Devices', 'route' => route('category.page', ['medical-devices'])],
            [ 'label' => 'Offers', 'route' => route('offers.products')],
            [ 'label' => 'InstaMed', 'route' => route('home')],
            [ 'label' => 'Wishcart', 'route' => route('home')]
        ];
        $countries  = config('lang.countries');
        $currencies = config('lang.currencies');
        $languages  = config('lang.languages');

        return view('components.frontend.header', [
            'logo'        => [ 'route' => 'home', 'imgSRC' => '/images/logos/logo-full-color.svg' ],
            'menus'       => $menus,
            'cart'        => $cart,
            'areas'       => $areas,
            'userAddress' => $userAddress,
            'countries'   => $countries,
            'currencies'  => $currencies,
            'languages'   => $languages,
        ]);
    }
}
