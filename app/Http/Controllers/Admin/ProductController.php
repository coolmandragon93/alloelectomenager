<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Product;
use App\Aswo;
use App\Sauver;

class ProductController extends Controller
{
    /**
     * Display a listing of the product.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with("brand")->orderBy('created_at', 'desc')->Where ('google_shopping', 1)->paginate(100);

        return view("admin.products.index", compact("products"));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.products.create");
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Aswo $aswo)
    {
        if($product_exists = Product::where('aswo_id', $request->get('artnr'))->first()) {
            return redirect()->route('admin.products.edit', $product_exists->id);
        }

        // Validate request
        $this->validate($request, [
            'artnr' => 'required|unique:products,aswo_id'
        ]);

        // Get detail information
        $product_detail = $aswo->article_detail_information($request->input());

        // If no product found
        if(isset($product_detail['error'])) {
            flash('Product not found', 'danger');

            return back();
        }

        // Get image for product
        $img_link = $aswo->article_pictures_800(['artnr' => $product_detail['artikelnummer']]);
        // filename
        $img_name = $product_detail['artikelnummer'].".jpg";

        // Store the img
        //$stored_img = Storage::put($img_name, file_get_contents($img_link['tempurl']));


        // Create Product
        // Find brand if possible
        $product = Product::create([
            'name' => trim($product_detail['artikelbezeichnung']),
            'description' => '',
            'condition' => '',
            'availability' => '',
            'google_product_category' => '',
            'gtin' => '',
            'mpn' => '',
            'aswo_id' => trim($product_detail['artikelnummer']),
            'brand_id' => 0,
            'brand_name' => trim($product_detail['artikelhersteller']),
            'image' => $img_name,
            'purchase_price' => $product_detail['ekpreis'],
            'price' => get_price($product_detail['ekpreis']),
            'google_shopping' => true
        ]);

        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->update($request->all());

        flash('Product updated', 'success');

        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return redirect()->route('admin.products.index');
    }

    /**
     * Get the latest aswo data
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function info(Aswo $aswo, $aswo_id)
    {
        return $aswo->article_detail_information(['artnr' => $aswo_id, 'sperrgut' => 1]);
    }

    /**
     * Update the purchase price
     *
     * @return \Illuminate\Http\Response
     */
    public function update_purchase_price(Aswo $aswo, $id)
    {
        // Get the product in db
        $product = Product::findOrFail($id);

        // Get the product detail
        $product_detail = $aswo->article_detail_information(['artnr' => $product['aswo_id'], 'sperrgut' => 1]);

        // Update the purchase price and save
        $product->purchase_price = $product_detail['ekpreis'];
        $product->save();

        flash('Purchase price updated', 'success');

        return redirect()->route('admin.products.edit', $id);
    }

    /**
     * Check the prices for all the products (cron job?)
     *
     * @return \Illuminate\Http\Response
     */
    public function check_all(Aswo $aswo)
    {
        $products = Product::whereNull('purchase_price')->take(50)->get();

        foreach ($products as $product) {


        }
    }

    /**
     * test the finder function
     *
     * @return \Illuminate\Http\Response
     */
    public function finder(Aswo $aswo)
    {
        // # 1
        // return $aswo->appliance_finder([]);

        // # 2
        // return $aswo->appliance_finder(["buchstabe" => "D"]);

        // # 3
        // return $aswo->appliance_finder(["hersteller" => "DYSON"]);

        # 4
        // return $aswo->appliance_finder(["hersteller" => "DYSON", "warensort" => "15250000"]);

        # 5
        return $aswo->appliance_finder(["hersteller" => "DYSON", "warensort" => "15250000", "vongeraet" => "CR01", "bisgeraet" => "CR01MEMORY"]);
    }

    /**
     * Get a direct link for a product 
     *
     * @return \Illuminate\Http\Response
     */
    public function link()
    {
        return view('admin.products.link');
    }

    /**
     * Get a direct link for a product 
     *
     * @return \Illuminate\Http\Response
     */
    public function getLink(Aswo $aswo, Request $request)
    {
        $product_detail = $aswo->article_detail_information($request->input());

        // If no product found
        if(isset($product_detail['error'])) {
            return response()->json([
                'error' => "Product not found"
            ]);
        }
        //D792084
        return response()->json([
            'link' => route('singleProduct', ['direct', $request->get('artnr')])
        ]);
    }

     public function sauv()
    {
        $products = Sauver::with("brand")->orderBy('created_at', 'desc')->Where ('google_shopping', 0)->paginate(100);

        return view("admin.sauv.index", compact("products"));
    }

    public function sauvshow($id)
    {
        $product = Sauver::findOrFail($id);

        return view('admin.sauv.show', compact('product'));
    }
}
