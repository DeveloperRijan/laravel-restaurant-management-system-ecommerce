<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Auth;
use App\Http\Controllers\FileHandler;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $requst)
    {
        $query = Category::query();
        if ($requst->sort_by != '') {
            $query->where('type', $requst->sort_by);
        }
        $data = $query->orderBy('created_at', 'DESC')->get();
        return view("backendViews.categories.index", compact('data'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backendViews.categories.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

            $this->validate($request, [
                'name'=>'required|string|max:50',
                'type'=>'required|string|in:Main,Staff'
                //'icon'=>'required|image|mimes:png,gif'
            ]);
            

            $slug = $this->createSlug($request->name);
            if (Category::where(['url'=>$slug, "type"=>$request->type])->exists()) {
                return redirect()->back()->with('error', "Category/menu already exists");
            }

            $featured_img = NULL;
            $location = \Config::get("constants.PUBLIC.ASSETS_START_PATH").\Config::get("constants.FILE_PATH.CATEGORY");

            if ($request->hasFile('icon')) {
                $fileName ='category-icon-'.uniqid().mt_rand(10, 9999);
                $featured_img = FileHandler::uploadFile($request->file('icon'), $fileName, $location);

            }


            $inserted = Category::insert([
                'type'=>$request->type,
                'name'=>$request->name,
                'url'=>$slug,
                //'featured_img'=>$featured_img,
                'created_by'=>'Admin',
                'creator_id'=>Auth::user()->id,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            if ($inserted == true) {
                return redirect()->back()->with('success', "Category Created");
            }
            return redirect()->back()->with('error', "Internal Server Error | Please try again later.");
        
    }



    private function createSlug($name){
        $slug = Str::slug($name, '-');

        $slug = str_replace(" ","",$slug);
        $slug = trim(strtolower($slug));
        return $slug;    
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
        $data = Category::where("id", decrypt($id))->first();
        if (!$data) {
            return abort(404);
        }
        return view("backendViews.categories.edit", compact('data'));
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
        $this->validate($request, [
            'name'=>'required|string|max:50',
            'type'=>'required|string|in:Main,Staff'
            //'slug'=>'nullable|string|max:60',
            //'icon'=>'nullable|image|mimes:png,gif',
        ]);

        $oldData = Category::where('id', decrypt($id))->first();
        if (!$oldData) {
            return redirect()->back()->with('error', "Category Not Found");
        }

        //slug
        $slug = $this->createSlug($request->name);
        $checkSlug = Category::where([
                        ['url', '=', $slug], 
                        ['id', '!=', decrypt($id)],
                        ["type", '=', $request->type]
                    ])
                    ->first();
        if ($checkSlug) {
            return redirect()->back()->with('error', "Category/menu already exists");
        }
        

        //featured image
        $featured_img = NULL;
        $location = \Config::get("constants.PUBLIC.ASSETS_START_PATH").\Config::get("constants.FILE_PATH.CATEGORY");

        if ($request->hasFile('icon')) {
            //delete
            if ($oldData->featured_img != NULL) {
                $file_name = $oldData->featured_img;
                FileHandler::deleteFile($file_name, $location);
            }

            $fileName ='category-icon-'.uniqid().mt_rand(10, 9999);
            $featured_img = FileHandler::uploadFile($request->file('icon'), $fileName, $location);

        }

        $updated = Category::where('id', decrypt($id))->update([
            'type'=>$request->type,
            'name'=>$request->name,
            'url'=>$slug,
            //'featured_img'=>($featured_img === NULL ? $oldData->featured_img : $featured_img),
            'updated_at'=>Carbon::now(),
        ]);
        return redirect()->back()->with('success', "Category Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id  
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function delete_cat($catID){
        $catID = decrypt($catID);
        $data = Category::where('id', $catID)->first();
        if (!$data) {
            return abort(404);
        }
        
    
        //data
        $subCategories = Category::where('parent_id', '=', $catID)->count();
        $have_products = Product::where('category_id', '=', $catID)->count();


        $categories = Category::where([
                    ['id', '!=', $catID],
                    ['is_sub_child', '=', NULL]
                ])
                ->orderBy('name', 'ASC')
                ->get();

        if ($subCategories === 0 && $have_products === 0) {
            return $this->deleteCategoryFinally($catID);
        }

        return view('backendViews.categories.category-manage', compact(
                    'data', 'subCategories', 'categories', 'have_products'));
        
    }


    //manage category and delete
    public function manage_and_delete_cat(Request $request){
        $this->validate($request, [
            "current_category"=>"required|string",
            "move_products_to"=>"required|string"
        ]);

        $current_category = decrypt($request->current_category);
        
        if (!Category::where('id', $current_category)->exists()) {
            return redirect()->back()->with("error", "Invalid delete able category");
        }

        //move products
        $have_products = Product::where('category_id', '=', $current_category)->count();
        if ($have_products > 0) {
            $result = $this->moveProductsTo($current_category, $request->move_products_to);
            if ($result === true) {
                return $this->deleteCategoryFinally($current_category);
            }
            return redirect()->back()->with("error", $result);

        }

        //if no products or subcategories then
        return $this->deleteCategoryFinally($current_category);
        
    }

    //move products to
    private function moveProductsTo($currentCat, $toCatID){
        $toCatID = decrypt($toCatID);
        if (!Category::where('id', $toCatID)->exists()) {
            return "Move Products To Category Not Found.";
        }

        $moved = Product::where([
            'category_id'=>$currentCat
        ])->update([
            'category_id'=>$toCatID,
        ]);
        if ($moved == true) {
            return true;
        }else{
            return "Somthing wrong to move products";
        }
    }

    //delete the category finally
    private function deleteCategoryFinally($catID){
        Category::where('id', $catID)->delete();
        return redirect()->route('admin.categories.index')->with('success', "Category Completely Deleted");
    }


}


