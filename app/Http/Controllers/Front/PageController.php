<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\Area;
use App\Models\Cart;
use App\Models\Brand;
use App\Models\Rating;
use App\Models\Banner;
use App\Models\Section;
use App\Models\Company;
use App\Models\Product;
use App\Models\Address;
use App\Classes\Utility;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\DosageForm;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\DeliveryGateway;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function home()
    {
        Utility::setUserEvent('pageview', [
            'page' => 'home'
        ]);

        $sliderBanners = Banner::where('position', 'slider')->where('status', 'active')->get();

        $hotSales = Banner::where('position', 'medical-device-offer')->where('status', 'active')->get();

        $brands = Brand::where('status', 'active')->where('is_top', 1)->get();

        $topCategories = Category::where('status', 'active')->where('is_top', 1)->get();

        // Top products
        $topProduct = Section::with(['products'])->where('slug', 'top-products')->first();

        // Medical device products
        $watch = Section::with(['products'])->where('slug', 'watch')->first();

        $features = [
            [
                'icon'      => 'fa-truck-fast',
                'title'     => 'Free Shipping',
                'postTitle' => 'On orders over tk. 499'
            ],
            [
                'icon'      => 'fa-shield',
                'title'     => 'Secure Checkout',
                'postTitle' => 'COD and Digital payment'
            ],
            [
                'icon'      => 'fa-capsules',
                'title'     => 'Genuine Products',
                'postTitle' => 'Authentic and original products'
            ]
        ];

        return view('frontend.pages.home', [
            'sliderBanners' => $sliderBanners,
            'topProduct'    => $topProduct,
            'watch'         => $watch,
            'brands'        => $brands,
            'topCategories' => $topCategories,
            'hotSales'      => $hotSales,
            'features'      => $features,
        ]);
    }

    public function index(Request $request, $thumbOnly = false)
    {
        Utility::setUserEvent('pageview', [
            'page' => 'all-products'
        ]);

        $searchKey           = $request->input('search_key', null);
        $filterCategoryIds   = $request->input('filter_category_ids', []);
        $filterBrandIds    = $request->input('filter_brand_ids', []);

        if ($filterCategoryIds && !empty($filterCategoryIds && $filterCategoryIds != 'null')) {
            $filterCategoryIds = explode(",", $filterCategoryIds);
        } else {
            $filterCategoryIds = [];
        }

        if ($filterBrandIds && !empty($filterBrandIds && $filterBrandIds != 'null')) {
            $filterBrandIds = explode(",", $filterBrandIds);
        } else {
            $filterBrandIds = [];
        }

        $products = $this->getProducts($request);

        $categories = Category::distinct()
            ->join('products', 'categories.id', '=', 'products.category_id')
            ->select('categories.id', 'categories.name')
            ->where('categories.status', 'active')
            ->whereNull('products.deleted_at')
            ->where('products.status', 'active')
            ->orderBy('categories.name', 'ASC')
            ->get();

        $barnds = Brand::distinct()
            ->join('products', 'brands.id', '=', 'products.brand_id')
            ->select('brands.id', 'brands.name')
            ->whereNull('products.deleted_at')
            ->where('products.status', 'active')
            ->where('brands.status', 'active')
            ->orderBy('brands.name', 'ASC')
            ->get();

        $viewPage = $thumbOnly ? 'frontend.pages.product-thumbs-page' : 'frontend.pages.product-index';

        return view($viewPage, [
            'products'          => $products,
            'brands'            => $barnds,
            'categories'        => $categories,
            'filterCategoryIds' => $filterCategoryIds,
            'filterBrandIds'    => $filterBrandIds,
            'pageTitle'         => 'All product'
        ]);
    }

    public function productShow(Request $request, $id, $slug = null)
    {
        Utility::setUserEvent('pageview', [
            'page' => 'product-details'
        ]);

        $currentURL = url()->current();
        Utility::saveIntendedURL($currentURL);
        $product = Product::where('status', 'active')->getDefaultMetaData()->find($id);
        $productSizes  = $product->sizes;
        $productColors =  $product->colors;

        if (!$product) {
            abort(404);
        }

        // Calculate ratings
        $ratingValue   = 0;
        $ratingPercent = 0;

        $ratings = Rating::with(['ratingImages'])->where('product_id', $id)->orderBy('created_at', 'desc')
            ->get();

        $ratingCount = $ratings->count();
        $rateSum     = $ratings->sum('rate');
        if ($ratingCount > 0) {
            $ratingValue   = $rateSum / $ratingCount;
            $ratingPercent = $ratingValue * 100 / 5;
        }

        $ratingReport = Rating::select(DB::raw('
            SUM((CASE WHEN rate = 5 THEN 1 ELSE 0 END)) as five_star,
            SUM((CASE WHEN rate = 4 THEN 1 ELSE 0 END)) as four_star,
            SUM((CASE WHEN rate = 3 THEN 1 ELSE 0 END)) as three_star,
            SUM((CASE WHEN rate = 2 THEN 1 ELSE 0 END)) as two_star,
            SUM((CASE WHEN rate = 1 THEN 1 ELSE 0 END)) as one_star
        '))->first();

        $userId  = Auth::id();
        $wishlistedProduct = null;

        if ($userId) {
            $wishlistedProduct = Wishlist::where('product_id', $id)->where('user_id', $userId)->first();
        }

        $isWishListed = $wishlistedProduct ? true : false;

        $relatedProducts = Product::getDefaultMetaData()->take(3)->get();

        $otherProducts = Product::inRandomOrder()->getDefaultMetaData()
            ->where('id', '<>', $product->id)->take(4)->get();

        return view('frontend.pages.product-single', [
            'product'         => $product,
            'productSizes'    => $productSizes,
            'productColors'   => $productColors,
            'relatedProducts' => $relatedProducts,
            'isWishListed'    => $isWishListed,
            'otherProducts'   => $otherProducts,
            'ratings'         => $ratings,
            'ratingValue'     => $ratingValue,
            'ratingPercent'   => $ratingPercent,
            'ratingReport'    => $ratingReport,
            'currency'        => 'Tk'
        ]);
    }

    public function about()
    {
        Utility::setUserEvent('pageview', [
            'page' => 'about'
        ]);

        return view('frontend.pages.about');
    }

    public function termsAndConditions()
    {
        Utility::setUserEvent('pageview', [
            'page' => 'terms-and-conditions'
        ]);

        return view('frontend.pages.terms-and-conditions');
    }

    public function frequentlyAskedQuestions()
    {
        Utility::setUserEvent('pageview', [
            'page' => 'frequently-asked-questions'
        ]);

        $questions = [
            [
                'q' => 'When will I receive my order?',
                'a' => 'Your order will be delivered within <strong>24-48</strong> hours inside dhaka city',
            ],
            [
                'q' => 'I have received damaged items.',
                'a' => 'We are sorry you had to experience this. Please do not accept the delivery of that order and let us know what happened.',
            ],
            [
                'q' => 'Items are different from what I ordered.',
                'a' => 'We are sorry you have had to experience this. Please do not accept it from delivery man. Reject the order straightaway and call to medicart customer care.',
            ],
            [
                'q' => 'Items are different from what I ordered.',
                'a' => 'We are sorry you have had to experience this. Please do not accept it from delivery man. Reject the order straightaway and call to medicart customer care.',
            ],
            [
                'q' => 'What if Items are missing from my order?',
                'a' => 'In no circumstances, you should receive an order that is incomplete. Once delivery man reaches your destination, be sure to check expiry date of medicines and your all ordered items was delivered.',
            ],
            [
                'q' => 'How do I cancel my order?',
                'a' => 'Please call us with your order ID and we will cancel it for you.',
            ],
            [
                'q' => 'I want to modify my order.',
                'a' => 'Sorry, once your order is confirmed, it cannot be modified. Please place a fresh order with any modifications.',
            ],
            [
                'q' => 'What is the shelf life of medicines being provided?',
                'a' => 'We ensure that the shelf life of the medicines being supplied by our partner retailers is, at least, a minimum of 3 months from the date of delivery.',
            ],
            [
                'q' => 'Order status showing delivered but I have not received my order.',
                'a' => 'Sorry that you are experiencing this. Please call to connect with us immediately.',
            ],
            [
                'q' => 'Which cities do you operate in?',
                'a' => 'Currently, we deliver only in Dhaka City',
            ],
            [
                'q' => 'How can I get my order delivered faster?',
                'a' => 'Sorry, we currently do not have a feature available to expedite the order delivery. We surely have a plan to introduce 2 hour expedite delivery soon.',
            ],
            [
                'q' => 'Can I modify my address after Order placement?',
                'a' => 'Sorry, once the order is placed, we are unable to modify the address.',
            ],
            [
                'q' => 'What is the meaning of Delivered status?',
                'a' => 'When delivery man reaches your destination and hand over the products to you the delivery status changes to <strong>Delivered</strong>. Status <strong>Delivered</strong> also means Medicart has already collected the payment from you via cash or online payment.',
            ]
        ];
        return view('frontend.pages.frequently-asked-questions', [
            'questions' => $questions
        ]);
    }

    public function promotionOffers()
    {
        Utility::setUserEvent('pageview', [
            'page' => 'promotion'
        ]);

        return view('frontend.pages.promotion');
    }

    public function privacyPolicy()
    {
        Utility::setUserEvent('pageview', [
            'page' => 'privacy-policy'
        ]);

        return view('frontend.pages.privacy-policy');
    }

    public function returnPolicy()
    {
        Utility::setUserEvent('pageview', [
            'page' => 'return-policy'
        ]);

        return view('frontend.pages.return-policy');
    }

    public function contact()
    {
        Utility::setUserEvent('pageview', [
            'page' => 'contact'
        ]);

        return view('frontend.pages.contact');
    }

    public function checkout(Request $request)
    {
        Utility::setUserEvent('pageview', [
            'page' => 'checkout'
        ]);

        $products = [];
        $carObj   = new Cart();
        $cart     = $carObj->getCurrentCustomerCart();
        if ($cart) {
            $products = $cart->items()->orderBy('id', 'desc')->getDefaultMetaData()->get();
        }

        $areas            = Area::orderBy('name', 'asc')->get();
        $userAddress      = Address::where('user_id', Auth::id())->orderBy('id', 'desc')->get();
        $deliveryGateways = DeliveryGateway::where('status', 'active')->get();
        $paymentGateways  = PaymentGateway::where('status', 'active')->get();
        $currency         = 'Tk';

        return view('frontend.pages.cart', [
            'cart'             => $cart,
            'areas'            => $areas,
            'products'         => $products,
            'userAddress'      => $userAddress,
            'deliveryGateways' => $deliveryGateways,
            'paymentGateways'  => $paymentGateways,
            'currency'         => $currency
        ]);
    }

    public function categoryPage(Request $request, $id)
    {
        Utility::setUserEvent('pageview', [
            'page' => 'category'
        ]);

        $category = Category::find($id);

        if(!$category) {
            abort(404);
        }

        $filterBrandIds = $request->input('filter_brand_ids', []);

        if ($filterBrandIds && !empty($filterBrandIds && $filterBrandIds != 'null')) {
            $filterBrandIds = explode(",", $filterBrandIds);
        } else {
            $filterBrandIds = [];
        }

        $products = $this->getProducts($request, 'category', $id);

        $brands = Brand::distinct()
            ->join('products', 'brands.id', '=', 'products.brand_id')
            ->select('brands.id', 'brands.name')
            ->where('category_id', $id)
            ->orderBy('brands.name', 'ASC')
            ->get();

        return view('frontend.pages.category', [
            'id'             => $id,
            'products'       => $products,
            'brands'         => $brands,
            'filterBrandIds' => $filterBrandIds,
            'pageTitle'      => $category->name
        ]);
    }

    public function brandPage(Request $request, $id)
    {
        Utility::setUserEvent('pageview', [
            'page' => 'brand'
        ]);

        $brand = Brand::find($id);

        if(!$brand) {
            abort(404);
        }

        $filterCategoryIds = $request->input('filter_category_ids', []);

        if ($filterCategoryIds && !empty($filterCategoryIds && $filterCategoryIds != 'null')) {
            $filterCategoryIds = explode(",", $filterCategoryIds);
        } else {
            $filterCategoryIds = [];
        }

        $products = $this->getProducts($request, 'brand', $id);

       $categories = Category::distinct()
            ->join('products', 'categories.id', '=', 'products.category_id')
            ->select('categories.id', 'categories.name')
            ->where('brand_id', $id)
            ->orderBy('categories.name', 'ASC')
            ->get();

        $viewPage = 'frontend.pages.brand';

        return view($viewPage, [
            'products'            => $products,
            'categories'          => $categories,
            'filterCategoryIds'   => $filterCategoryIds,
            'pageTitle'           => $brand->name,
            'id'                  => $id
        ]);
    }

    public function offerProduct(Request $request, $thumbOnly=false)
    {
        Utility::setUserEvent('pageview', [
            'page' => 'offer-product'
        ]);

        $paginate = config('crud.paginate.default');
        $now = Carbon::now();
        $searchKey           = $request->input('search_key', null);
        $filterCategoryIds   = $request->input('filter_category_ids', []);
        $filterCompanyIds    = $request->input('filter_company_ids', []);
        $filterDosageFormIds = $request->input('filter_dosageForm_ids', []);

        if ($filterCategoryIds && !empty($filterCategoryIds && $filterCategoryIds != 'null')) {
            $filterCategoryIds = explode(",", $filterCategoryIds);
        } else {
            $filterCategoryIds = [];
        }

        if ($filterCompanyIds && !empty($filterCompanyIds && $filterCompanyIds != 'null')) {
            $filterCompanyIds = explode(",", $filterCompanyIds);
        } else {
            $filterCompanyIds = [];
        }

        if ($filterDosageFormIds && !empty($filterDosageFormIds && $filterDosageFormIds != 'null')) {
            $filterDosageFormIds = explode(",", $filterDosageFormIds);
        } else {
            $filterDosageFormIds = [];
        }

        $products = $this->getOfferProducts($request);

        $categories = Category::distinct()
            ->join('products', 'categories.id', '=', 'products.category_id')
            ->select('categories.id', 'categories.name')
            ->orderBy('categories.name', 'ASC')
            ->get();

        $companies = Company::distinct()
            ->join('products', 'companies.id', '=', 'products.company_id')
            ->select('companies.id', 'companies.name')
            ->whereNull('products.deleted_at')
            ->where('products.selling_price', '>', 0)
            ->where('products.status', 'activated')
            ->orderBy('companies.name', 'ASC')
            ->get();

        $dosageForms = DosageForm::distinct()
            ->join('products', 'dosage_forms.id', '=', 'products.dosage_form_id')
            ->select('dosage_forms.id', 'dosage_forms.name')
            ->whereNull('products.deleted_at')
            ->where('products.selling_price', '>', 0)
            ->where('products.status', 'activated')
            ->orderBy('dosage_forms.name', 'ASC')
            ->get();

        $viewPage = $thumbOnly ? 'frontend.pages.product-thumbs-page' : 'frontend.pages.offer-products';

        return view($viewPage, [
            'products'            => $products,
            'companies'           => $companies,
            'categories'          => $categories,
            'dosageForms'         => $dosageForms,
            'filterCategoryIds'   => $filterCategoryIds,
            'filterCompanyIds'    => $filterCompanyIds,
            'filterDosageFormIds' => $filterDosageFormIds
        ]);
    }

    private function getProducts($request, $relation = null, $id = null)
    {
        $searchKey         = $request->input('search_key', null);
        $filterBrandIds    = $request->input('filter_brand_ids', []);
        $filterCategoryIds = $request->input('filter_category_ids', []);

        $products = Product::getDefaultMetaData();

        // Brand wise product find
        if ($relation && $relation === 'brand') {
            $products = $products->where('brand_id', $id);
        }

        // Category wise product find
        if ($relation && $relation === 'category') {
            $products = $products->where('category_id', $id);
        }

        if ($filterCategoryIds && !empty($filterCategoryIds && $filterCategoryIds != 'null')) {
            $filterCategoryIds = explode(",", $filterCategoryIds);

            $products = $products->whereIn('category_id', $filterCategoryIds);
        }

        if ($filterBrandIds && !empty($filterBrandIds && $filterBrandIds != 'null')) {
            $filterBrandIds = explode(",", $filterBrandIds);

            $products = $products->whereIn('brand_id', $filterBrandIds);
        }

        // $order = $order === 'desc' ? 'desc' : 'asc';
        // $products = $products->orderBy($orderBy, $order);

        $paginate = config('crud.paginate.default');
        if ($searchKey) {
            $products = Product::search($searchKey)->query(function ($query) {
                $query->where('status', 'active');
            })->paginate($paginate);
        } else {
            $products = $products->where('price', '>', 0)->paginate($paginate);
        }

        return $products;
    }

    private function getOfferProducts($request, $relation = null, $slug = null)
    {
        $orderBy = 'price';
        $searchKey           = $request->input('search_key', null);
        $order               = $request->input('order', null);
        $percent             = $request->input('percent', null);
        $subCategorySlug     = $request->input('sub_category', null);
        $filterCategoryIds   = $request->input('filter_category_ids', []);
        $filterCompanyIds    = $request->input('filter_company_ids', []);
        $filterDosageFormIds = $request->input('filter_dosageForm_ids', []);

        $products = Product::getDefaultMetaData();
        $products = $products->where('offer_price', '>', 0);

        if ($relation && $relation === 'categories' && $slug) {
            if ($percent) {
                $products = $products->where('offer_price', '<=', $percent);
                if ($subCategorySlug) {
                    $products = $products->whereHas('categories', function ($query) use ($subCategorySlug) {
                        $query->where('slug', $subCategorySlug);
                    });
                }
            } else {
                $products = $products->whereHas('categories', function ($query) use ($slug) {
                    $query->where('slug', $slug);
                });
            }
        }

        if ($filterCategoryIds && !empty($filterCategoryIds && $filterCategoryIds != 'null')) {
            $filterCategoryIds = explode(",", $filterCategoryIds);

            $products = $products->whereHas('categories', function ($query) use ($filterCategoryIds) {
                $query->whereIn('id', $filterCategoryIds);
            });
        }

        // if ($filterCompanyIds && !empty($filterCompanyIds && $filterCompanyIds != 'null')) {
        //     $filterCompanyIds = explode(",", $filterCompanyIds);

        //     $products = $products->whereHas('company', function($query) use ($filterCompanyIds) {
        //         $query->whereIn('id', $filterCompanyIds);
        //     });
        // }

        // if ($filterDosageFormIds && !empty($filterDosageFormIds && $filterDosageFormIds != 'null')) {
        //     $filterDosageFormIds = explode(",", $filterDosageFormIds);

        //     $products = $products->whereHas('dosageForm', function($query) use ($filterDosageFormIds) {
        //         $query->whereIn('id', $filterDosageFormIds);
        //     });
        // }

        $order = $order === 'desc' ? 'desc' : 'asc';
        $products = $products->orderBy($orderBy, $order);

        $paginate = config('crud.paginate.default');
        if ($searchKey) {
            $products = Product::search($searchKey)->paginate($paginate);
        } else {
            $products = $products->where('price', '>', 0)->paginate($paginate);
        }

        return $products;
    }
}
