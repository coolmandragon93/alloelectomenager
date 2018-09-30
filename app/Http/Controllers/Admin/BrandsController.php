<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Aswo;

class BrandsController extends Controller
{
    /**
     * Update the given user.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    private $filejson = '';

    public function __construct()
    {
        $this->viewData = [];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // get brands list from db
        $brands = DB::table('brands')->orderBy('name')->get();
        $data = array();

        foreach ($brands as $brand)
        {
            $item['brand'] = $brand;

            // get products brand_id
            $product = DB::table('products')->where('brand_id', '=', $brand->id)->get();
            $item['products'] = $product;

            // add new item to data list
            $data[] = $item;
        }

        $this->viewData['data'] = $data;

        return view('admin.brands.index', $this->viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // get brands list from db
        $brands = DB::table('brands')->get();

        $this->viewData['brands'] = $brands;

        return view('admin.brands.create', $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store (Request $request)
    {
        $input = $request->all();
        DB::table('products')->insert([
            'name' => $input['product'],
            'brand_id' => $input['brand']
        ]);

        return redirect()->action('Admin\BrandsController@index');
    }

    /**
     * Show the form for editing product.
     *
     * @param  int  $keyBrand
     * @param  int  $keyProduct
     * @return \Illuminate\Http\Response
     */

    public function editProduct($keyBrand, $keyProduct)
    {
        $brand = DB::table('brands')->where('id', $keyBrand)->first();
        $products = DB::table('products')->where('id', $keyProduct)->first();

        $this->viewData['brand'] = $brand;
        $this->viewData['products'] = $products;
        $this->viewData['keyBrand'] = $keyBrand;
        $this->viewData['keyProduct'] = $keyProduct;
        return view('admin.brands.edit', $this->viewData);
    }

    /**
     * Update product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $keyBrand
     * @param  int  $keyProduct
     * @return \Illuminate\Http\Response
     */

    public function updateProduct ($keyBrand, $keyProduct, Request $request)
    {
        $input = $request->all();

        DB::table('products')
            ->where('id', $keyProduct)
            ->update([
                'name' => $input['product']
            ]);

        return redirect()->action('Admin\BrandsController@index');
    }

    /**
     * Remove Product.
     *
     * @param  int  $keyBrand
     * @param  int  $keyProduct
     * @return \Illuminate\Http\Response
     */

    public function deleteProduct ($keyBrand, $keyProduct)
    {
        DB::table('products')
            ->where('id', $keyProduct)
            ->delete();
        echo 1;
    }


    function trim_array_string($array_string)
    {
        $res = array();
        if (count($array_string) > 0)
            foreach ($array_string as $string)
            {
                $res[] = trim($string, " \n");
            }
        return $res;
    }

    /**
     * Add Brand
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param brand_name $string
     */

    public function createBrand (Request $request)
    {
        $file_logo = $_FILES['brand_logo'];

        if ($file_logo['type'] != 'image/png')
            return redirect()->action('Admin\BrandsController@index');

        $filename = str_replace(" ", '-', $request->brand_name) . '.png';
        $destinationPath = public_path() . "/assets/front/img/brand/$filename";

        move_uploaded_file($file_logo["tmp_name"], $destinationPath);

        $description = $this->trim_array_string($request->description);
        DB::table('brands')
            ->insert([
                'name'                => $request->brand_name,
                'description'         => json_encode($description)
            ]);

        return redirect()->action('Admin\BrandsController@index');
    }

    /**
     * Check if a product is valid
     *
     * @param Aswo $aswo
     * @param $product_code
     * @return \Illuminate\Http\Response
     * @internal param brand_name $string
     */

    public function checkValidProduct (Aswo $aswo, $product_code)
    {
        $product = $aswo->article_detail_information([
            'artnr'    => $product_code,
            'sperrgut' => 1
        ]);

        if(isset($product['error']))
            return 0;
        return 1;
    }

    /**
     * Delete Brand
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param brand $int -id (GET)
     */

    public function deleteBrand(Request $request)
    {
        $brand_id = isset($_GET['brand-id']) ? $_GET['brand-id'] : '';
        if ($brand_id != '')
        {
            $brand_name = DB::table('brands')->where('id', $brand_id)->first()->name;
            $brand_name = str_replace(" ", '-', $brand_name);

            $file_path = public_path() . "/assets/front/img/brand/$brand_name.png";
            if (file_exists($file_path))
                unlink($file_path);

            DB::table('products')
                ->where('brand_id', $brand_id)
                ->delete();
            DB::table('brands')
                ->where('id', $brand_id)
                ->delete();
        }

        return redirect()->action('Admin\BrandsController@index');
    }

    /**
     * Edit Brand
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param brand $int -id (GET)
     */

    public function editBrand(Request $request)
    {
        $brand_id = isset($_GET['brand-id']) ? $_GET['brand-id'] : '';
        if ($brand_id != '')
        {
            $brand_detail = DB::table('brands')->where('id', $brand_id)->first();

            $brand_name = str_replace(" ", '-', $brand_detail->name);

            $this->viewData['brand_detail'] = $brand_detail;

            return view('admin.brands.edit_brand', $this->viewData);
        }

        return redirect()->action('Admin\BrandsController@index');
    }

    /**
     * Edit Brand
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param brand $int -id (GET)
     */

    public function editBrandSave(Request $request)
    {
        $brand_detail = DB::table('brands')->where('id', $request->brand_id)->first();

        if (count($brand_detail) <= 0)
            return redirect()->action('Admin\BrandsController@index');


        $file_logo = isset($_FILES['brand_logo']) ? $_FILES['brand_logo'] : '';

        if ($file_logo != '') {
            if ($file_logo['type'] != 'image/png')
                return redirect()->action('Admin\BrandsController@index');

            $filename = str_replace(" ", '-', $request->brand_name) . '.png';
            $destinationPath = public_path() . "/assets/front/img/brand/$filename";

            if (file_exists($destinationPath))
                unlink($destinationPath);

            move_uploaded_file($file_logo["tmp_name"], $destinationPath);
        }
        else if ($request->brand_name != $brand_detail->name)
        {
            $old_file_name = str_replace(" ", '-', $brand_detail->name) . '.png';
            $old_file_path = public_path() . "/assets/front/img/brand/$old_file_name";

            $new_file_name = str_replace(" ", '-', $request->brand_name) . '.png';
            $new_file_path = public_path() . "/assets/front/img/brand/$new_file_name";

            if (file_exists($old_file_path))
                rename($old_file_path, $new_file_path);
            else
                move_uploaded_file($file_logo["tmp_name"], $new_file_path);
        }

        $description = $this->trim_array_string($request->description);

        DB::table('brands')
            ->where('id', $request->brand_id)
            ->update([
                'name'                => $request->brand_name,
                'description'         => $description[0]
            ]);

        return redirect()->action('Admin\BrandsController@index');
    }
}
