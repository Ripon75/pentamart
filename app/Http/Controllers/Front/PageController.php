<?php

namespace App\Http\Controllers\Front;

use App\Models\Offer;
use App\Models\Brand;
use App\Models\Rating;
use App\Models\Slider;
use App\Models\Section;
use App\Models\Product;
use App\Classes\Utility;
use App\Models\Category;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function home()
    {
        $sliders = Slider::where('status', 'active')->get();

        $topBrands = Brand::where('status', 'active')->where('is_top', 1)->get();

        $topCategories = Category::where('status', 'active')->where('is_top', 1)->get();

        // Top products
        $topProduct = Section::with(['products'])->where('slug', 'first-section')->first();

        // Medical device products
        $otherProduct = Section::with(['products'])->where('slug', 'second-section')->first();

        //New arrival Product Section
        $newArrival = Section::with(['products'])->where('slug', 'new-arrival')->first();

        $offers = Offer::where('status', 'active')->get();

        $features = [
            [
                'imgSrc'    => 'images/sample/delivery.png',
                'title'     => 'Cash on delivery',
                'postTitle' => ''
            ],
            [
                'imgSrc'    => 'images/sample/quality.png',
                'title'     => 'Qualityful Product',
                'postTitle' => ''
            ],
            [
                'imgSrc'    => 'images/sample/customer-service.png',
                'title'     => 'Support 24/7',
                'postTitle' => ''
            ]
        ];

        return view('frontend.pages.home', [
            'sliders'       => $sliders,
            'topCategories' => $topCategories,
            'topBrands'     => $topBrands,
            'topProduct'    => $topProduct,
            'otherProduct'  => $otherProduct,
            'offers'        => $offers,
            'features'      => $features,
            'newArrival'    => $newArrival
        ]);
    }

    public function index(Request $request)
    {
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

        $brands = Brand::distinct()
            ->join('products', 'brands.id', '=', 'products.brand_id')
            ->select('brands.id', 'brands.name')
            ->whereNull('products.deleted_at')
            ->where('products.status', 'active')
            ->where('brands.status', 'active')
            ->orderBy('brands.name', 'ASC')
            ->get();

        return view('frontend.pages.product-index', [
            'products'          => $products,
            'brands'            => $brands,
            'categories'        => $categories,
            'filterCategoryIds' => $filterCategoryIds,
            'filterBrandIds'    => $filterBrandIds,
            'pageTitle'         => 'All product'
        ]);
    }

    public function productShow($id)
    {
        $currentURL = url()->current();
        Utility::saveIntendedURL($currentURL);

        $product       = Product::where('status', 'active')->getDefaultMetaData()->find($id);
        $productSizes  = $product->sizes;
        $productColors = $product->colors;

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
        '))->where('product_id', $id)->first();

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
            'currency'        => 'tk'
        ]);
    }

    public function categoryPage(Request $request, $id)
    {
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

    public function offerProduct(Request $request, $offerPercent)
    {
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

        $products = $this->getOfferProducts($request, $offerPercent);

        $categories = Category::distinct()
            ->join('products', 'categories.id', '=', 'products.category_id')
            ->select('categories.id', 'categories.name')
            ->where('categories.status', 'active')
            ->whereNull('products.deleted_at')
            ->where('products.status', 'active')
            ->orderBy('categories.name', 'ASC')
            ->get();

        $brands = Brand::distinct()
            ->join('products', 'brands.id', '=', 'products.brand_id')
            ->select('brands.id', 'brands.name')
            ->whereNull('products.deleted_at')
            ->where('products.status', 'active')
            ->where('brands.status', 'active')
            ->orderBy('brands.name', 'ASC')
            ->get();

        return view('frontend.pages.offer-products', [
            'products'          => $products,
            'brands'            => $brands,
            'categories'        => $categories,
            'filterCategoryIds' => $filterCategoryIds,
            'filterBrandIds'    => $filterBrandIds,
            'offerPercent'      => $offerPercent,
            'pageTitle'         => 'Offer products'
        ]);
    }

    private function getProducts($request, $relation = null, $id = null)
    {
        $paginate          = config('crud.paginate.default');
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

        $products = $products->where('mrp', '>', 0)->paginate($paginate);

        return $products;
    }

    private function getOfferProducts($request, $offerPercent)
    {
        $paginate          = config('crud.paginate.default');
        $filterBrandIds    = $request->input('filter_brand_ids', []);
        $filterCategoryIds = $request->input('filter_category_ids', []);

        $products = Product::getDefaultMetaData();

        if ($filterCategoryIds && !empty($filterCategoryIds && $filterCategoryIds != 'null')) {
            $filterCategoryIds = explode(",", $filterCategoryIds);

            $products = $products->whereIn('category_id', $filterCategoryIds);
        }

        if ($filterBrandIds && !empty($filterBrandIds && $filterBrandIds != 'null')) {
            $filterBrandIds = explode(",", $filterBrandIds);

            $products = $products->whereIn('brand_id', $filterBrandIds);
        }

        $products = $products
                    ->where('offer_percent', '<=', $offerPercent)
                    ->where('offer_percent', '>', 0)
                    ->orderBy('offer_percent', 'desc')
                    ->paginate($paginate);

        return $products;
    }

    public function about()
    {
        return view('frontend.pages.about');
    }

    public function termsAndConditions()
    {
        return view('frontend.pages.terms-and-conditions');
    }

    public function privacyPolicy()
    {
        return view('frontend.pages.privacy-policy');
    }

    public function returnPolicy()
    {
        return view('frontend.pages.return-policy');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }
}
