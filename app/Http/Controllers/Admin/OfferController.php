<?php

namespace App\Http\Controllers\Admin;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{
    public function index() {
        $paginate = config('crud.paginate.default');

        $offers = Offer::orderBy('created_at', 'desc')->paginate($paginate);

        return view('adminend.pages.offer.index', [
            'offers' => $offers
        ]);
    }

    public function create() {
        return view('adminend.pages.offer.create');
    }

    public function store(Request $request) {
        $request->validate(
            [
                'title'         => ['required'],
                'offer_percent' => ['required', 'integer'],
                'img_src'       => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg'],
            ],
            [
                'img_src.required' => 'Image field is required'
            ]
        );

        $title        = $request->input('title');
        $status       = $request->input('status', 'active');
        $offerPercent = $request->input('offer_percent', null);

        try {
            DB::beginTransaction();

            $offer = new Offer();

            $offer->title         = $title;
            $offer->status        = $status;
            $offer->offer_percent = $offerPercent;
            $res = $offer->save();
            if ($res) {
                if ($request->hasFile('img_src')) {
                    $imgSRC = $request->file('img_src');
                    $imgPath = Storage::put('images/offers', $imgSRC);
                    $offer->img_src = $imgPath;
                    $offer->save();
                }
            }
            DB::commit();
            return redirect()->route('admin.offers.index')->with('message', 'Offer created successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went wrong');
        }
    }

    public function edit($id) {
        $offer = Offer::find($id);

        return view('adminend.pages.offer.edit', [
            'offer' => $offer
        ]);
    }

    public function update(Request $request, $id) {
        $request->validate(
            [
                'title'         => ['required'],
                'offer_percent' => ['required', 'integer'],
                'img_src'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg'],
            ],
            [
                'img_src.required' => 'Image field is required'
            ]
        );

        $title        = $request->input('title');
        $status       = $request->input('status', 'active');
        $offerPercent = $request->input('offer_percent', null);

        try {
            DB::beginTransaction();

            $offer = Offer::find($id);

            $offer->title         = $title;
            $offer->status        = $status;
            $offer->offer_percent = $offerPercent;
            $res = $offer->save();
            if ($res) {
                if ($request->hasFile('img_src')) {
                    $imgSRC = $request->file('img_src');
                    $oldPath = $offer->getOldPath($offer->img_src);
                    if ($oldPath) {
                        Storage::delete($oldPath);
                    }
                    $imgPath = Storage::put('images/offers', $imgSRC);
                    $offer->img_src = $imgPath;
                    $offer->save();
                }
            }
            DB::commit();
            return redirect()->route('admin.offers.index')->with('message', 'Offer created successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went wrong');
        }
    }
}
