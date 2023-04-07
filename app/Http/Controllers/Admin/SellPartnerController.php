<?php

namespace App\Http\Controllers\Admin;

use App\Models\SellPartner;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellPartnerController extends Controller
{
    public function index(Request $request)
    {
        $paginate = config('crud.paginate.default');

        $sellPartners = SellPartner::orderBy('created_at', 'DESC')->paginate($paginate);

        return view('adminend.pages.sellPartner.index', [
            'sellPartners' => $sellPartners
        ]);
    }

    public function create(Request $request)
    {
        return view('adminend.pages.sellPartner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:sell_partners,name']
        ]);

        $name          = $request->input('name', null);
        $contactName   = $request->input('contact_name', null);
        $contactNumber = $request->input('contact_number', null);
        $slug          = Str::slug($name, '-');

        $sellPartner = new  SellPartner();

        $sellPartner->name           = $name;
        $sellPartner->slug           = $slug;
        $sellPartner->contact_name   = $contactName;
        $sellPartner->contact_number = $contactNumber;
        $res = $sellPartner->save();
        if ($res) {
            return redirect()->route('admin.sell-partners.index')->with('message', 'Sell partner created successfully');
        } else {
            return back()->with('error', 'Something went to wrong');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request, $id)
    {
        $sellPartner = SellPartner::find($id);

        return view('adminend.pages.sellPartner.edit', [
            'sellPartner' => $sellPartner
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', "unique:sell_partners,name,$id"]
        ]);

        $name          = $request->input('name', null);
        $contactName   = $request->input('contact_name', null);
        $contactNumber = $request->input('contact_number', null);
        $slug          = Str::slug($name, '-');

        $sellPartner = SellPartner::find($id);

        $sellPartner->name           = $name;
        $sellPartner->slug           = $slug;
        $sellPartner->contact_name   = $contactName;
        $sellPartner->contact_number = $contactNumber;
        $res = $sellPartner->save();
        if ($res) {
            return redirect()->route('admin.sell-partners.index')->with('message', 'Sell partner updated successfully');
        } else {
            return back()->with('error', 'Something went to wrong');
        }
    }
}
