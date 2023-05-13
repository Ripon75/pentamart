<?php

namespace App\View\Components\Frontend;

use Illuminate\View\Component;

class Footer extends Component
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
        $about = [
            'logo'        => '/images/logos/logo.png',
            'email'       => 'pentamart@gmail.com',
            'phone'       => '+8801**********',
        ];

        $nav1 = [
            'about'                 => 'About',
            'aboutLink'             => '#',
            'termsAndConditions'    => 'Terms & Conditions',
            'termsAndConditionsLink'=> '#',
            'faq'                   => 'FAQ',
            'faqLink'               => '#',
        ];

        $nav2 = [
            'products'      => 'All Product',
            'productLink'   => '#',
            'ordertrac'     => 'Order Tracking',
            'orderTracLink' => '#',
            'wishList'      => 'Wish List',
            'wishListLink'  => '#',
            'login'         => 'Login',
            'loginLink'     => '#',
            'myAccount'     => 'My Account',
            'myAccountLink' => '#',
            'promotion'     => "Promotional Offers",
            'promotionLink' => "#"
        ];

        $nav3 = [
            'contact'     => "Contact Us",
            'contactLink' => '#',
            'privacy'     => 'Privacy & Policy',
            'privacyLink' => '#',
            'return'      => 'Return & Refund',
            'returnRefundLink'=> '',
        ];

        $nav4 = [
            'title'       => 'Download Our App',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'title2'      => 'Join with us'
        ];

        $logos = [
            '/images/logos/cash-on-delivery.jpg',
            '/images/logos/bkash.png',
            '/images/logos/nagad.png',
        ];

        return view('components.frontend.footer', [
            'about' => $about,
            'nav1'  => $nav1,
            'nav2'  => $nav2,
            'nav3'  => $nav3,
            'nav4'  => $nav4,
            'logos' => $logos
        ]);
    }
}
