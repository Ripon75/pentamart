<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\Family;
use App\Models\Attribute;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AttributeOption;
use App\Http\Controllers\Controller;

class FamilyController extends Controller
{
    public function index(Request $request)
    {
        $paginate   = config('crud.paginate.default');
        $result     = Family::orderBy('created_at', 'desc')->paginate($paginate);

        return view('adminend.pages.family.index', [
            'result' => $result
        ]);
    }

    public function create(Request $request)
    {
        $attrObj    = new Attribute();
        $inputTypes = $attrObj->inputTypes;
        $valueCasts = $attrObj->valueCasts;

        return view('adminend.pages.family.create', [
            'inputTypes' => $inputTypes,
            'valueCasts' => $valueCasts
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                          => ['required'], // TODO: Make it unique
            'attributes.*.name'             => ['required'],
            'attributes.*.input_type'       => ['required'],
            'attributes.*.required'         => ['required'],
            'attributes.*.visible_on_front' => ['required'],
            'attributes.*.value_cast'       => ['required'],
        ]);

        $name         = $request->input('name', null);
        $slug         = Str::slug($name, '-');
        $description  = $request->input('description', null);
        $attributes   = $request->input('attributes', null);

        try {
            DB::beginTransaction();
            $familyObj              = new Family();
            $familyObj->name        = $name;
            $familyObj->slug        = $slug;
            $familyObj->description = $description;
            $res = $familyObj->save();

            if ($res) {
                foreach ($attributes as $attr) {
                    $attrName           = $attr['name'];
                    $slug               = Str::slug($attrName, '-');
                    $attrInputType      = $attr['input_type'];
                    $attrGroup          = $attr['group'];
                    $attrRequired       = $attr['required'];
                    $attrVisibleOnFront = $attr['visible_on_front'];
                    $attrComparable     = $attr['comparable'];
                    $attrFiltetable     = $attr['filterable'];
                    $attrValueCast      = $attr['value_cast'];
                    $attrOptions        = $attr['options'];
                    $attrOptions        = explode(',', $attrOptions);

                    $attributeObj                   = new Attribute();
                    $attributeObj->slug             = $slug;
                    $attributeObj->name             = $attrName;
                    $attributeObj->input_type       = $attrInputType;
                    $attributeObj->attribute_group  = $attrGroup;
                    $attributeObj->required         = $attrRequired;
                    $attributeObj->visible_on_front = $attrVisibleOnFront;
                    $attributeObj->comparable       = $attrComparable;
                    $attributeObj->filterable       = $attrFiltetable;
                    $attributeObj->value_cast       = $attrValueCast;
                    $res = $attributeObj->save();

                    if ($res) {
                        $familyObj->attributes()->attach($attributeObj->id);

                        if (count($attrOptions)) {
                            foreach ($attrOptions as $opt) {
                                if ($opt) {
                                    $optObj = new AttributeOption();
                                    $optObj->attribute_id = $attributeObj->id;
                                    $optObj->label = Str::of($opt)->trim();
                                    $optObj->value = Str::slug($opt, '-');
                                    $optObj->save();
                                }
                            }
                        }
                    }
                }
                DB::commit();
                return redirect()->route('admin.families')->with('message', 'Family create successfully');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.families')->with('error', $e);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request, $id)
    {
        $attrObj    = new Attribute();
        $inputTypes = $attrObj->inputTypes;
        $valueCasts = $attrObj->valueCasts;
        $family     = Family::with(['attributes', 'attributes.options'])->find($id);

        return view('adminend.pages.family.edit', [
            'inputTypes' => $inputTypes,
            'valueCasts' => $valueCasts,
            'family'     => $family
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'                          => ['required'], // TODO: Make it unique
            'attributes.*.name'             => ['required'],
            'attributes.*.input_type'       => ['required'],
            'attributes.*.required'         => ['required'],
            'attributes.*.visible_on_front' => ['required'],
            'attributes.*.value_cast'       => ['required'],
        ]);

        $name         = $request->input('name', null);
        $slug         = Str::slug($name, '-');
        $description  = $request->input('description', null);
        $attributes   = $request->input('attributes', null);

        try {
            $familyObj = Family::find($id);

            if (!$familyObj) {
                return abort(404);
            }

            DB::beginTransaction();

            $familyObj->name        = $name;
            $familyObj->slug        = $slug;
            $familyObj->description = $description;
            $res = $familyObj->save();

            if ($res) {
                $familyObj->attributes()->detach();

                foreach ($attributes as $attr) {
                    $attrName           = $attr['name'];
                    $slug               = Str::slug($attrName, '-');
                    $attrInputType      = $attr['input_type'];
                    $attrGroup          = $attr['group'];
                    $attrRequired       = $attr['required'];
                    $attrVisibleOnFront = $attr['visible_on_front'];
                    $attrComparable     = $attr['comparable'];
                    $attrFiltetable     = $attr['filterable'];
                    $attrValueCast      = $attr['value_cast'];
                    $attrOptions        = $attr['options'];
                    $attrOptions        = explode(',', $attrOptions);

                    $attributeObj = Attribute::where('name', $attrName)->first();

                    if (!$attributeObj) {
                        $attributeObj = new Attribute();
                    }

                    $attributeObj->slug             = $slug;
                    $attributeObj->name             = $attrName;
                    $attributeObj->input_type       = $attrInputType;
                    $attributeObj->attribute_group  = $attrGroup;
                    $attributeObj->required         = $attrRequired;
                    $attributeObj->visible_on_front = $attrVisibleOnFront;
                    $attributeObj->comparable       = $attrComparable;
                    $attributeObj->filterable       = $attrFiltetable;
                    $attributeObj->value_cast       = $attrValueCast;
                    $res                            = $attributeObj->save();

                    if ($res) {
                        $familyObj->attributes()->attach($attributeObj->id);

                        if (count($attrOptions)) {
                            foreach ($attrOptions as $opt) {
                                if ($opt) {
                                    $label = Str::of($opt)->trim();
                                    $value = Str::slug($opt, '-');

                                    $optObj = AttributeOption::where('label', $label)
                                        ->where('attribute_id', $attributeObj->id)->first();

                                    if (!$optObj) {
                                        $optObj               = new AttributeOption();
                                        $optObj->attribute_id = $attributeObj->id;
                                        $optObj->label        = $label;
                                        $optObj->value        = $value;
                                        $optObj->save();
                                    }
                                }
                            }
                        }
                    }
                }
                DB::commit();
                return redirect()->route('admin.families')->with('message', 'Family updated successfully');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.families')->with('error', $e);
        }
    }

    public function destroy($id)
    {
        //
    }
}
