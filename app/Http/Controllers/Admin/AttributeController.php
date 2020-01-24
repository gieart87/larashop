<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\AttributeRequest;
use App\Http\Requests\AttributeOptionRequest;

use App\Models\Attribute;
use App\Models\AttributeOption;

use Session;

use App\Authorizable;

class AttributeController extends Controller
{
    use Authorizable;

    public function __construct()
    {
        $this->data['types'] = Attribute::types();
        $this->data['booleanOptions'] = Attribute::booleanOptions();
        $this->data['validations'] = Attribute::validations();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['attributes'] = Attribute::orderBy('name', 'ASC')->paginate(10);

        return view('admin.attributes.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['attribute'] = null;
        
        return view('admin.attributes.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeRequest $request)
    {
        $params = $request->except('_token');
        $params['is_required'] = (bool) $params['is_required'];
        $params['is_unique'] = (bool) $params['is_unique'];
        $params['is_configurable'] = (bool) $params['is_configurable'];
        $params['is_filterable'] = (bool) $params['is_filterable'];

        if (Attribute::create($params)) {
            Session::flash('success', 'Attribute has been saved');
        }

        return redirect('admin/attributes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attribute = Attribute::findOrFail($id);

        $this->data['attribute'] = $attribute;
        
        return view('admin.attributes.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttributeRequest $request, $id)
    {
        $params = $request->except('_token');
        $params['is_required'] = (bool) $params['is_required'];
        $params['is_unique'] = (bool) $params['is_unique'];
        $params['is_configurable'] = (bool) $params['is_configurable'];
        $params['is_filterable'] = (bool) $params['is_filterable'];

        unset($params['code']);
        unset($params['type']);

        $attribute = Attribute::findOrFail($id);

        if ($attribute->update($params)) {
            Session::flash('success', 'Attribute has been saved');
        }

        return redirect('admin/attributes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);

        if ($attribute->delete()) {
            Session::flash('success', 'Attribute has been deleted');
        }

        return redirect('admin/attributes');
    }

    public function options($attributeID)
    {
        if (empty($attributeID)) {
            return redirect('admin/attributes');
        }

        $attribute = Attribute::findOrFail($attributeID);
        $this->data['attribute'] = $attribute;

        return view('admin.attributes.options', $this->data);
    }

    public function store_option(AttributeOptionRequest $request, $attributeID)
    {
        if (empty($attributeID)) {
            return redirect('admin/attributes');
        }
        
        $params = [
            'attribute_id' => $attributeID,
            'name' => $request->get('name'),
        ];

        if (AttributeOption::create($params)) {
            Session::flash('success', 'option has been saved');
        }

        return redirect('admin/attributes/'. $attributeID .'/options');
    }

    public function edit_option($optionID)
    {
        $option = AttributeOption::findOrFail($optionID);

        $this->data['attributeOption'] = $option;
        $this->data['attribute'] = $option->attribute;

        return view('admin.attributes.options', $this->data);
    }

    public function update_option(AttributeOptionRequest $request, $optionID)
    {
        $option = AttributeOption::findOrFail($optionID);
        $params = $request->except('_token');

        if ($option->update($params)) {
            Session::flash('success', 'Option has been updated');
        }

        return redirect('admin/attributes/'. $option->attribute->id .'/options');
    }

    public function remove_option($optionID)
    {
        if (empty($optionID)) {
            return redirect('admin/attributes');
        }

        $option = AttributeOption::findOrFail($optionID);

        if ($option->delete()) {
            Session::flash('success', 'option has been deleted');
        }

        return redirect('admin/attributes/'. $option->attribute->id .'/options');
    }
}
