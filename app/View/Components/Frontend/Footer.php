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
            'logo'        => '/images/logos/logo-full-color.svg',
            'description' => 'Pharmacy at Home.',
            'loc1'        => 'J K Tower, 31, Segun Bagicha, Ramna,',
            'loc2'        => 'Dhaka-1000, Bangladesh.',
            'email'       => 'info@medicart.health',
            'phone'       => '+8809609080706',
            'phone2'       => '+8801322800327',
            'phone3'       => '+8801322800320'
        ];

        $nav1 = [
            'title'                 => 'Information',
            'about'                 => 'About',
            'aboutLink'             => '#',
            'termsAndConditions'    => 'Terms & Conditions',
            'termsAndConditionsLink'=> '#',
            'faq'                   => 'FAQ',
            'faqLink'               => '#',
        ];

        $nav2 = [
            'title'         => 'Service',
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
            'title'       => 'Customer Care',
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
            '/images/logos/master-card.png'
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
