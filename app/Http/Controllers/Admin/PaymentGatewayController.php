<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
class PaymentGatewayController extends Controller
{
   public function index()
   {
        $defaultPaginate = config('crud.paginate.default');

        $pgs = PaymentGateway::orderBy('name', 'asc')->paginate($defaultPaginate);

        return view('adminend.pages.paymentGateway.index', [
            'pgs' => $pgs
        ]);
   }

    public function create()
    {
        return view('adminend.pages.paymentGateway.create');
    }

   public function store(Request $request)
   {
        $request->validate([
            'name'    => ['required', 'unique:payment_gateways,name'],
            'img_src' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg'],
        ]);

        $name   = $request->input('name');
        $status = $request->input('status', 'active');
        $slug   = Str::slug($name, '-');

        try {
            DB::beginTransaction();

            $pg = new PaymentGateway();

            $pg->name   = $name;
            $pg->slug   = $slug;
            $pg->status = $status;
            $res = $pg->save();
            if ($res) {
                if ($request->hasFile('img_src')) {
                    $imgSRC = $request->file('img_src');
                    $imgPath = Storage::put('images/paymentGateways', $imgSRC);
                    $pg->img_src = $imgPath;
                    $pg->save();
                }
            }
            DB::commit();
            return redirect()->route('admin.payments.index')->with('message', 'Payment gateway created successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went wrong');
        }
   }

   public function edit($id)
   {
        $pg = PaymentGateway::find($id);

        if (!$pg) {
            abort(404);
        }

        return view('adminend.pages.paymentGateway.edit', [
            'pg' => $pg
        ]);
   }

   public function update(Request $request, $id)
   {
        $request->validate([
            'name'    => ['required', "unique:payment_gateways,name,$id"],
            'img_src' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg'],
        ]);

        $name   = $request->input('name');
        $status = $request->input('status', 'active');
        $slug   = Str::slug($name, '-');

        try {
            DB::beginTransaction();

            $pg = PaymentGateway::find($id);

            $pg->name   = $name;
            $pg->slug   = $slug;
            $pg->status = $status;
            $res = $pg->save();
            if ($res) {
                if ($request->hasFile('img_src')) {
                    $oldPath = $pg->getOldPath($pg->img_src);
                    if ($oldPath) {
                        Storage::delete($oldPath);
                    }
                    $imgSRC  = $request->file('img_src');
                    $imgPath = Storage::put('images/paymentGateways', $imgSRC);
                    $pg->img_src = $imgPath;
                    $pg->save();
                }
            }
            DB::commit();
            return redirect()->route('admin.payments.index')->with('message', 'Payment gateway updated successfully');
        } catch (\Exception $e) {
            info($e);
            DB::rollback();
            return back()->with('error', 'Something went wrong');
        }
   }
}
