<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\Controller;
use App\PriceRule;

class PriceRulesController extends Controller
{

    public function index()
    {
        $price_rules = PriceRule::paginate(50);

        return view('admin.price_rules.index', compact('price_rules'));
    }

    public function create()
    {
        return view('admin.price_rules.create');
    }

    public function store(Request $request)
    {
        $price_rules = PriceRule::create($request->all());

        flash('Price Rule Created', 'success');

        return redirect()->route('admin.price_rules.index');
    }

    public function show($id){
        $price_rule = PriceRule::find($id);

        return view('price_rules.show', compact('price_rule'));
    }

    public function edit($id)
    {
        $price_rule = PriceRule::findOrFail($id);

        return view('admin.price_rules.edit', compact('price_rule'));
    }

    public function update(Request $request, $id)
    {
        $price_rule = PriceRule::findOrFail($id)->update($request->all());

        flash('Price Rule Updated', 'success');

        return redirect()->route('admin.price_rules.index');
    }

    public function delete($id)
    {
        $price_rule = PriceRule::findOrFail($id)->delete();

        flash('Price Rule Deleted', 'danger');

        return redirect()->route('admin.price_rules.index');
    }
}
