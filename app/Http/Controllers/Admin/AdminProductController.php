<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Category;
use Carbon\Carbon;
use Auth;
use App\Http\Controllers\FileHandler;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::orderBy('created_at', 'DESC')->with('get_category')->get();
        
        $view = "backendViews.products.index";
        if (Auth::user()->type === "Kitchen Staff") {
            $view = "ks_panel.products.index";
        }
        return view($view, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        return view("backendViews.products.create", compact('categories'));
    }

    public function get_categories_type_wise(Request $reqeust){
        $categoriesList = Category::where('type', $reqeust->type)->orderBy('name', 'ASC')->get();
        return view("backendViews.products.partials.categories", compact('categoriesList', 'reqeust'))->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = Validator::make($request->all(), [
            "type"=>"required|string|in:Main,Staff",
            "item_type"=>"nullable|string|in:Product,Meal",
            "title"=>"required|string|max:".\Config::get("constants.PRODUCT.TITLE_LENGTH"),
            "category"=>"required|string",
            "description"=>"required|string|max:".\Config::get("constants.PRODUCT.DESCRIPTION_LENGTH"),
            "price"=>"required|min:1",
            "discount_price"=>"required|min:0",

            "field_names"=>"nullable|array|max:20",
            "field_names.*"=>"required|string",
            "field_values"=>"nullable|array|max:20",
            "field_values.*"=>"required|string",
            "options"=>"nullable|array",

            "images"=>"required|array|min:1|max:".\Config::get("constants.PRODUCT.ALLOW_IMAGES"),
            "images.*"=>"required|image|mimes:png,jpeg,jpg,gif",
            "size"=>"required|string|in:large,small",
            "note"=>"nullable|string|max:".\Config::get("constants.PRODUCT.NOTE_STRING_MAX")
        ]);

        if ($validations->fails()) {
            return response()->json([
                "msg"=>$validations->errors()->first()
            ], 422);
        }

        if ($request->type === "Staff") {
            if ($request->item_type == '') {
                return response()->json(["msg"=>"Item type is required"], 422);
            }
        }

        //validate category
        $category = Category::where('id', $request->category)->first();
        if (!$category) {
            return response()->json(["msg"=>"Category Not Found"], 422);
        }

        //validate discount price
        if ($request->price <= $request->discount_price) {
            return response()->json(["msg"=>"Price can't be equal or less of discount price."], 422);
        }


        //create slug
        $slug = $this->createSlug($request->title.'-'.$request->size);

        //upload images
        $images = NULL;
        $location = \Config::get("constants.PUBLIC.ASSETS_START_PATH").\Config::get("constants.FILE_PATH.PRODUCT");

        foreach ($request->file('images') as $key => $image) {
            $fileName ='product-'.uniqid().microtime('now').mt_rand(10, 9999);
            $images[] = FileHandler::uploadFile($image, $fileName, $location);
        }
        
        $product = new Product([
            "type"=>$request->type,
            "item_type"=>$request->item_type,
            "category_id"=>$category->id,
            "title"=>$request->title,
            "slug"=>$slug,
            "description"=>$request->description,
            "price"=>$request->price,
            "discount_price"=>$request->discount_price,
            "field_names"=>($request->field_names == '' ? NULL : json_encode($request->field_names)),
            "field_values"=>($request->field_values == '' ? NULL : json_encode($request->field_values)),
            "options"=>($request->options == '' ? NULL : json_encode($request->options)),
            "images"=>json_encode($images),
            "size"=>$request->size,
            "note"=>$request->note,
            "created_at"=>Carbon::now(),
            "updated_at"=>Carbon::now()
        ]);
        if ($product->save()) {
            $productID = mt_rand(10, 9999).$product->id;
            Product::where('id', $product->id)->update(['product_id'=>$productID]);
            return response()->json([
                'success'=>true, 
                'msg'=>"Product Created Successfully",
                'data'=>['html_content'=>false]
            ], 200);
        }
        return response()->json([
            "msg"=>"Internal server error | please try again later"
        ], 422);
    }

    //Create Slug
    private function createSlug($title, $id = 0){
        // Normalize the title
        $slug = Str::slug($title, '-');
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = $this->getRelatedSlugs($slug, $id);
        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }
        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 25; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }
        throw new \Exception('Can not create a unique slug');
    }

    private function getRelatedSlugs($slug, $id = 0)
    {
        return Product::select('slug')->where('slug', 'like', $slug.'%')
        ->where('id', '<>', $id)
        ->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::where("id", decrypt($id))->first();
        if (!$product) {
            return abort(404);
        }
        $categories = Category::orderBy('name', 'ASC')->get();
        $editData = $product;
        return view("backendViews.products.edit", compact('categories', 'product', 'editData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validations = Validator::make($request->all(), [
            //"type"=>"required|string|in:Main,Staff",
            "item_type"=>"nullable|string|in:Product,Meal",
            "title"=>"required|string|max:".\Config::get("constants.PRODUCT.TITLE_LENGTH"),
            "category"=>"required|string",
            "description"=>"required|string|max:".\Config::get("constants.PRODUCT.DESCRIPTION_LENGTH"),
            "price"=>"required|min:1",
            "discount_price"=>"required|min:0",
            "field_names"=>"nullable|array|max:20",
            "field_names.*"=>"required|string",
            "field_values"=>"nullable|array|max:20",
            "field_values.*"=>"required|string",
            "images"=>"nullable|array|min:1|max:".\Config::get("constants.PRODUCT.ALLOW_IMAGES"),
            "images.*"=>"nullable|image|mimes:png,jpeg,jpg,gif",
            "size"=>"required|string|in:large,small",
            "note"=>"nullable|string|max:".\Config::get("constants.PRODUCT.NOTE_STRING_MAX"),
            "status"=>"required|string|in:Active,Inactive"
        ]);

        if ($validations->fails()) {
            return response()->json([
                "msg"=>$validations->errors()->first()
            ], 422);
        }

        if ($request->type === "Staff") {
            if ($request->item_type == '') {
                return response()->json(["msg"=>"Item type is required"], 422);
            }
        }

        //check product is exists
        $currentData = Product::where('id', decrypt($id))->first();
        if (!$currentData) {
            return response()->json([
                "msg"=>"Product Not Found"
            ], 422);
        }

        //validate category
        $category = Category::where('id', $request->category)->first();
        if (!$category) {
            return response()->json([
                "msg"=>"Category Not Found"
            ], 422);
        }

        //validate category shifting
        if ($currentData->category_id != $request->category) {
            if ($currentData->type === "Staff") {
                //categories can't be
                if ($category->type !== 'Staff') {
                    return response()->json([
                        "msg"=>"Category Must be one of Staff Type"
                    ], 422);
                }
            }

            if ($currentData->type === "Main") {
                //categories can't be
                if ($category->type !== 'Main') {
                    return response()->json([
                        "msg"=>"Category Must be one of Main Type"
                    ], 422);
                }
            }
        }

        //validate discount price
        if ($request->price <= $request->discount_price) {
            return response()->json([
                "msg"=>"Price can't be equal or less of discount price."
            ], 422);
        }

        //create slug
        $slug = $this->createSlug($request->title.'-'.$request->size);

        //upload images
        $images = NULL;
        $location = \Config::get("constants.PUBLIC.ASSETS_START_PATH").\Config::get("constants.FILE_PATH.PRODUCT");

        if ($request->file('images')) {
            //delete old images
            foreach (json_decode($currentData->images, true) as $key => $img) {
                FileHandler::deleteFile($img, $location);
            }
            foreach ($request->file('images') as $key => $image) {
                $fileName ='product-'.uniqid().microtime('now').mt_rand(10, 9999);
                $images[] = FileHandler::uploadFile($image, $fileName, $location);
            }
        }
        
        Product::where('id', $currentData->id)->update([
            //"type"=>$request->type,
            "item_type"=>$request->item_type,
            "category_id"=>$category->id,
            "title"=>$request->title,
            "slug"=>$slug,
            "description"=>$request->description,
            "price"=>$request->price,
            "discount_price"=>$request->discount_price,
            "field_names"=>($request->field_names == '' ? NULL : json_encode($request->field_names)),
            "field_values"=>($request->field_values == '' ? NULL : json_encode($request->field_values)),
            "images"=>($images === NULL ? $currentData->images : json_encode($images)),
            "size"=>$request->size,
            "note"=>$request->note,
            "status"=>$request->status,
            "updated_at"=>Carbon::now()
        ]);
        return response()->json([
            'success'=>true, 
            'msg'=>"Product Updated Successfully",
            'data'=>['html_content'=>false]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    //actions of product
    public function actions($productID, $actionType){
        $product = Product::where('id', decrypt($productID))->first();
        if (!$product) {
            return abort(404);
        }

        if (decrypt($actionType) === "SoftDelete") {
            if (Auth::user()->type !== "Admin") {
                return abort(403);
            }
            $product->delete();
            return redirect()->route("admin.products.index")->with('success', "Product Deleted Succeffully.");
        }

        if (decrypt($actionType) === "Sold Out" || decrypt($actionType) === "Available") {
            $product->update([
                "stock_status"=>decrypt($actionType)
            ]);

            $view = "admin.products.index";
            if (Auth::user()->type === "Kitchen Staff") {
                $view = "ks.products.index";
            }
            return redirect()->route($view)->with('success', "Product ".decrypt($actionType));
        }

        return abort(403);
    }
}
