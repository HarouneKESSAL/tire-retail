<?php

namespace App\Http\Controllers;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\PostTag;
use App\Models\PostCategory;
use App\Models\Post;
use App\Models\Cart;
use App\Models\Brand;
use App\Models\ProductOption;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Spatie\Newsletter\Facades\Newsletter;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
class FrontendController extends Controller
{

    public function index(Request $request){
        return redirect()->route($request->user()->role);
    }
    public function home(Request $request)
    {
        // Log the entire incoming request
        Log::info('Home Request Data:', $request->all());

        // Fetch basic data
        $featured = Product::active()->featured()->orderBy('price', 'DESC')->limit(2)->get();
        $posts = Post::active()->orderBy('id', 'DESC')->limit(3)->get();
        $banners = Banner::active()->orderBy('id', 'DESC')->limit(3)->get();
        $categories = Category::active()->parent()->orderBy('title', 'ASC')->get();
        $product_lists = Product::active()->orderBy('id', 'DESC')->paginate(8);

        // Get categories by slug
        $pneuJantes = Category::where('slug', 'pneujantes')->first();
        $pneu = Category::where('slug', 'pneu')->first();
        $rouesJantes = Category::where('slug', 'rouesjantes')->first();

        // Fetch car details and product dimensions based on the category ID
        $years = $this->fetchYears($pneuJantes->id);
        $car_brands = $this->fetchBrands($pneuJantes->id);
        $models = $this->fetchModels($pneuJantes->id);
        $options = $this->fetchOptions($pneuJantes->id);
        $pneuDimensions = $this->fetchPneuDimensions($pneu->id);
        $rouesJantesDimensions = $this->fetchRouesJantesDimensions($rouesJantes->id);

        Log::info('Fetched Data:', [
            'years' => $years->toArray(),
            'car_brands' => $car_brands->toArray(),
            'models' => $models->toArray(),
            'options' => $options->toArray(),
            'pneuDimensions' => $pneuDimensions,
            'rouesJantesDimensions' => $rouesJantesDimensions,
        ]);

        return view('frontend.index', compact(
            'featured', 'posts', 'product_lists', 'banners', 'categories',
            'years', 'car_brands', 'models', 'options', 'rouesJantesDimensions', 'pneuDimensions'
        ));
    }

    private function fetchPneuDimensions($categoryId)
    {
        return [
            'widths' => Product::where('cat_id', $categoryId)->whereNotNull('width')->select('width')->groupBy('width')->get(),
            'aspect_ratios' => Product::where('cat_id', $categoryId)->whereNotNull('aspect_ratio')->select('aspect_ratio')->groupBy('aspect_ratio')->get(),
            'diameters' => Product::where('cat_id', $categoryId)->whereNotNull('diameter')->select('diameter')->groupBy('diameter')->get(),
        ];
    }

    private function fetchRouesJantesDimensions($categoryId)
    {
        return [
            'widths' => Product::where('cat_id', $categoryId)->whereNotNull('width')->select('width')->groupBy('width')->get(),
            'aspect_ratios' => Product::where('cat_id', $categoryId)->whereNotNull('aspect_ratio')->select('aspect_ratio')->groupBy('aspect_ratio')->get(),
            'diameters' => Product::where('cat_id', $categoryId)->whereNotNull('diameter')->select('diameter')->groupBy('diameter')->get(),
        ];
    }

    private function fetchYears($categoryId)
    {
        return Brand::join('products', 'brands.id', '=', 'products.brand_id')
            ->where('products.cat_id', $categoryId)
            ->select('brands.car_year')
            ->distinct()
            ->get();
    }

    private function fetchBrands($categoryId)
    {
        return Brand::join('products', 'brands.id', '=', 'products.brand_id')
            ->where('products.cat_id', $categoryId)
            ->select('brands.car_brand')
            ->distinct()
            ->get();
    }

    private function fetchModels($categoryId)
    {
        return Brand::join('products', 'brands.id', '=', 'products.brand_id')
            ->where('products.cat_id', $categoryId)
            ->select('brands.car_model')
            ->distinct()
            ->get();
    }

    private function fetchOptions($categoryId)
    {
        return ProductOption::join('product_option_product', 'product_options.id', '=', 'product_option_product.product_option_id')
            ->join('products', 'product_option_product.product_id', '=', 'products.id')
            ->where('products.cat_id', $categoryId)
            ->select('product_options.name', 'product_options.value')
            ->distinct()
            ->get();
    }



    public function productSearch(Request $request)
    {
        Log::info('Received request for product search:', $request->all());

        try {
            $query = Product::query();

            // Apply category filter
            if ($request->filled('category_slug')) {
                $category = Category::where('slug', $request->category_slug)->first();
                if ($category) {
                    $query->where('cat_id', $category->id);
                }
            }

            // Apply width filter
            if ($request->filled('width')) {
                $query->where('width', $request->width);
            }

            // Apply aspect_ratio filter
            if ($request->filled('aspect_ratio')) {
                $query->where('aspect_ratio', $request->aspect_ratio);
            }

            // Apply diameter filter
            if ($request->filled('diameter')) {
                $query->where('diameter', $request->diameter);
            }

            // Apply season filter
            if ($request->filled('season')) {
                $seasons = (array)$request->season;  // Convert to array to handle single or multiple seasons
                $query->whereIn('season', $seasons);
                Log::info('Season filter applied', ['season' => $seasons]);
            }

            // Apply car information filters
            if ($request->filled('year') || $request->filled('car_brand') || $request->filled('model')) {
                $query->whereHas('brand', function ($q) use ($request) {
                    if ($request->filled('year')) {
                        $q->where('car_year', $request->year);
                    }
                    if ($request->filled('car_brand')) {
                        $q->where('car_brand', $request->car_brand);
                    }
                    if ($request->filled('model')) {
                        $q->where('car_model', $request->model);
                    }
                });
            }

            // Apply option filter
            if ($request->filled('option')) {
                $query->where('option', $request->option);
            }

            $carName = "{$request->year} {$request->car_brand} {$request->model}";

            // Fetch distinct values for options from the product_options table
            $categories = Category::select('slug', 'title')
                ->whereIn('id', $query->pluck('cat_id'))
                ->get();

            $vitesses = ProductOption::select('value')
                ->distinct()
                ->where('name', 'vitesse')
                ->get();

            $lettrages = ProductOption::select('value')
                ->distinct()
                ->where('name', 'lettrage')
                ->get();

            $charges = ProductOption::select('value')
                ->distinct()
                ->where('name', 'charge')
                ->get();

            // Get paginated results
            $products = $query->where('status', 'active')->orderBy('id', 'DESC')->paginate(10);

            Log::info('Executed query', ['query' => $query->toSql(), 'bindings' => $query->getBindings()]);

            $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

            return view('frontend.pages.product-grids', compact('products', 'recent_products', 'vitesses', 'categories', 'lettrages', 'charges', 'carName'));
        } catch (\Exception $e) {
            Log::error('Error in product search', ['exception' => $e]);
            return response()->json([
                'error' => 'An error occurred while processing your request.',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], 500);
        }
    }

    public function filterResults(Request $request)
    {
        // Fetch the car brand, model, and year from the request
        $carBrand = $request->input('car_brand');
        $carModel = $request->input('model');
        $carYear = $request->input('year');
        $option = $request->input('option');


        // Fetch the car details from the brands table
        $brand = Brand::where('car_brand', $carBrand)
            ->where('car_model', $carModel)
            ->where('car_year', $carYear)
            ->first();

        // Construct the car name dynamically
        $carName = "{$carYear} {$carBrand} {$carModel}";

        // Fetch categories and products
        $categories = Category::all();
       //fetch products ith brand ,with options coming from request
        // Fetch products that match the brand and filter by the selected option
        $products = Product::join('product_option_product', 'products.id', '=', 'product_option_product.product_id')
            ->join('product_options', 'product_option_product.product_option_id', '=', 'product_options.id')
            ->where('products.brand_id', $brand->id)
            ->when($option, function($query) use ($option) {
                return $query->where('product_options.name', $option);
            })
            ->select('products.*')
            ->distinct()
            ->get();
        return view('frontend.partials.filter-results', compact('carName', 'categories', 'products','option'));
    }

    public function aboutUs(){
        return view('frontend.pages.about-us');
    }

    public function contact(){
        return view('frontend.pages.contact');
    }

    public function productDetail($slug){
        $product_detail= Product::getProductBySlug($slug);
        // dd($product_detail);
        return view('frontend.pages.product_detail')->with('product_detail',$product_detail);
    }
//    public function productGrids(){
//        $products=Product::query();
//
//        if(!empty($_GET['category'])){
//            $slug=explode(',',$_GET['category']);
//            // dd($slug);
//            $cat_ids=Category::select('id')->whereIn('slug',$slug)->pluck('id')->toArray();
//            // dd($cat_ids);
//            $products->whereIn('cat_id',$cat_ids);
//            // return $products;
//        }
//        if(!empty($_GET['brand'])){
//            $slugs=explode(',',$_GET['brand']);
//            $brand_ids=Brand::select('id')->whereIn('slug',$slugs)->pluck('id')->toArray();
//            return $brand_ids;
//            $products->whereIn('brand_id',$brand_ids);
//        }
//        if(!empty($_GET['sortBy'])){
//            if($_GET['sortBy']=='title'){
//                $products=$products->where('status','active')->orderBy('title','ASC');
//            }
//            if($_GET['sortBy']=='price'){
//                $products=$products->orderBy('price','ASC');
//            }
//        }
//
//        if(!empty($_GET['price'])){
//            $price=explode('-',$_GET['price']);
//            // return $price;
//            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
//            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));
//
//            $products->whereBetween('price',$price);
//        }
//
//        $recent_products=Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();
//        // Sort by number
//        if(!empty($_GET['show'])){
//            $products=$products->where('status','active')->paginate($_GET['show']);
//        }
//        else{
//            $products=$products->where('status','active')->paginate(9);
//        }
//        // Sort by name , price, category
//        $categories = Category::select('slug', 'title')
//            ->whereIn('id', $products->pluck('cat_id'))
//            ->get();
//
//
//        // Get all distinct 'vitesse' options
//        $vitesses = ProductOption::select('value')
//            ->distinct()
//            ->where('name', 'vitesse')
//            ->get();
//
//        // Get all distinct 'lettrage' options
//        $lettrages = ProductOption::select('value')
//            ->distinct()
//            ->where('name', 'lettrage')
//            ->get();
//
//        // Get all distinct 'charge' options
//        $charges = ProductOption::select('value')
//            ->distinct()
//            ->where('name', 'charge')
//            ->get();
//
//        return view('frontend.pages.product-grids')->with('products',$products)->with('recent_products',$recent_products)->with('vitesses', $vitesses)->with('categories', $categories)->with('lettrages', $lettrages)->with('charges', $charges);
//    }
//    public function productLists(){
//        $products=Product::query();
//
//        if(!empty($_GET['category'])){
//            $slug=explode(',',$_GET['category']);
//            // dd($slug);
//            $cat_ids=Category::select('id')->whereIn('slug',$slug)->pluck('id')->toArray();
//            // dd($cat_ids);
//            $products->whereIn('cat_id',$cat_ids)->paginate;
//            // return $products;
//        }
//        if(!empty($_GET['brand'])){
//            $slugs=explode(',',$_GET['brand']);
//            $brand_ids=Brand::select('id')->whereIn('slug',$slugs)->pluck('id')->toArray();
//            return $brand_ids;
//            $products->whereIn('brand_id',$brand_ids);
//        }
//        if(!empty($_GET['sortBy'])){
//            if($_GET['sortBy']=='title'){
//                $products=$products->where('status','active')->orderBy('title','ASC');
//            }
//            if($_GET['sortBy']=='price'){
//                $products=$products->orderBy('price','ASC');
//            }
//        }
//
//        if(!empty($_GET['price'])){
//            $price=explode('-',$_GET['price']);
//            // return $price;
//            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
//            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));
//
//            $products->whereBetween('price',$price);
//        }
//
//        $recent_products=Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();
//        // Sort by number
//        if(!empty($_GET['show'])){
//            $products=$products->where('status','active')->paginate($_GET['show']);
//        }
//        else{
//            $products=$products->where('status','active')->paginate(6);
//        }
//        // Sort by name , price, category
//
//
//        return view('frontend.pages.product-lists')->with('products',$products)->with('recent_products',$recent_products);
//    }

    public function productView(Request $request, $viewType = 'list')
    {
        // Start logging
        Log::info('Product view initiated', $request->all());

        // Start building the query
        $products = Product::query();

        // Handle dimensions (from pneu filters)
        if ($request->filled('width')) {
            $products->where('width', $request->width);
            Log::info('Width filter applied', ['width' => $request->width]);
        }
        if ($request->filled('aspect_ratio')) {
            $products->where('aspect_ratio', $request->aspect_ratio);
            Log::info('Aspect Ratio filter applied', ['aspect_ratio' => $request->aspect_ratio]);
        }
        if ($request->filled('diameter')) {
            $products->where('diameter', $request->diameter);
            Log::info('Diameter filter applied', ['diameter' => $request->diameter]);
        }

        // Handle car info (from pneu/jantes filters)
        if ($request->filled('year') || $request->filled('car_brand') || $request->filled('model')) {
            $products->whereHas('brand', function ($q) use ($request) {
                if ($request->filled('year')) {
                    $q->where('car_year', $request->year);
                }
                if ($request->filled('car_brand')) {
                    $q->where('car_brand', $request->car_brand);
                }
                if ($request->filled('model')) {
                    $q->where('car_model', $request->model);
                }
            });
            Log::info('Car info filter applied', [
                'year' => $request->year,
                'car_brand' => $request->car_brand,
                'model' => $request->model
            ]);
        }
        $carName = "{$request->year} {$request->car_brand} {$request->model}";
        // Apply category filter
        if ($request->filled('category')) {
            $slug = explode(',', $request->get('category'));
            $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            $products->whereIn('cat_id', $cat_ids);
            Log::info('Category filter applied', ['categories' => $slug]);
        }

        // Apply brand filter
        if ($request->filled('brand')) {
            $slugs = explode(',', $request->get('brand'));
            $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
            $products->whereIn('brand_id', $brand_ids);
            Log::info('Brand filter applied', ['brands' => $slugs]);
        }

        if(!empty($_GET['sortBy'])){
            if($_GET['sortBy']=='title'){
                $products=$products->where('status','active')->orderBy('title','ASC');
            }
            if($_GET['sortBy']=='price'){
                $products=$products->orderBy('price','ASC');
            }
        }

        if(!empty($_GET['price'])){
            $price=explode('-',$_GET['price']);
            // return $price;
            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));

            $products->whereBetween('price',$price);
            Log::info('Price filter applied', ['price' => $price]);
        }

        // Apply non-boolean product option filters
        $nonBooleanOptions = ['vitesse', 'lettrage', 'charge'];
        foreach ($nonBooleanOptions as $optionName) {
            if ($request->filled("options.$optionName")) {
                $products->whereHas('options', function ($q) use ($optionName, $request) {
                    $q->where('name', $optionName)->where('value', $request->input("options.$optionName"));
                });
                Log::info('Applying filter', ['option_name' => $optionName, 'value' => $request->input("options.$optionName")]);
            }
        }

        // Apply boolean product option filters
        $booleanOptions = ['runflat', 'xl_renforces', 'cloutable'];
        foreach ($booleanOptions as $optionName) {
            if ($request->has("options.$optionName")) {
                $products->whereHas('options', function ($q) use ($optionName) {
                    $q->where('name', $optionName)->where('is_boolean', 1);
                });
                Log::info('Applying filter', ['option_name' => $optionName, 'is_boolean' => true]);
            }
        }

        // Apply discount filter
        if ($request->has('options.en_solde')) {
            $products->where('discount', '>', 0);
            Log::info('Discount filter applied');
        }

        // Check for Choix de l'équipe
        if ($request->has('options.choix_equipe')) {
            $products->where('is_featured', 1);
            Log::info('Choix de l\'équipe filter applied');
        }

        // Execute the query and log it
        Log::info('Executing product query', ['query' => $products->toSql(), 'bindings' => $products->getBindings()]);

        // Fetch recent products
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        // Fetch distinct options for filters
        $categories = Category::select('slug', 'title')->whereIn('id', $products->pluck('cat_id'))->get();
        $vitesses = ProductOption::select('value')->distinct()->where('name', 'vitesse')->get();
        $lettrages = ProductOption::select('value')->distinct()->where('name', 'lettrage')->get();
        $charges = ProductOption::select('value')->distinct()->where('name', 'charge')->get();

        // Determine pagination and view type
        $itemsPerPage = $request->get('show', $viewType === 'grid' ? 9 : 6);
        $products = $products->where('status', 'active')->paginate($itemsPerPage);

        // Determine the view to render
        $view = $viewType === 'grid' ? 'frontend.pages.product-grids' : 'frontend.pages.product-lists';

        // Return the view with the data
        return view($view)->with([
            'products' => $products,
            'recent_products' => $recent_products,
            'vitesses' => $vitesses,
            'categories' => $categories,
            'lettrages' => $lettrages,
            'charges' => $charges,
            'carName' => $carName ?? '',
            'width' => $request->width,
            'aspect_ratio' => $request->aspect_ratio,
            'diameter' => $request->diameter,
            'year' => $request->year,
            'car_brand' => $request->car_brand,
            'model' => $request->model,
        ]);
    }


//    public function productFilter(Request $request) {
//        $data = $request->all();
//        $urlParameters = [];
//
//        // Show filter
//        if (!empty($data['show'])) {
//            $urlParameters['show'] = $data['show'];
//        }
//
//        // Sort By filter
//        if (!empty($data['sortBy'])) {
//            $urlParameters['sortBy'] = $data['sortBy'];
//        }
//
//        // Category filter
//        if (!empty($data['category'])) {
//            $urlParameters['category'] = implode(',', $data['category']);
//        }
//
//        // Brand filter
//        if (!empty($data['brand'])) {
//            $urlParameters['brand'] = implode(',', $data['brand']);
//        }
//
//        // Price Range filter
//        if (!empty($data['price_range'])) {
//            $urlParameters['price'] = $data['price_range'];
//        }
//
//        // Boolean Option filters (e.g., runflat, xl_renforces, cloutable)
//        $booleanOptions = ['runflat', 'xl_renforces', 'cloutable'];
//        foreach ($booleanOptions as $optionName) {
//            if ($request->has("options.$optionName")) {
//                $urlParameters["options[$optionName]"] = 1;
//            }
//        }
//
//        // Non-Boolean Option filters (e.g., vitesse, lettrage, charge)
//        $nonBooleanOptions = ['vitesse', 'lettrage', 'charge'];
//        foreach ($nonBooleanOptions as $optionName) {
//            if ($request->filled("options.$optionName")) {
//                $urlParameters["options[$optionName]"] = $request->input("options.$optionName");
//                Log::info("$optionName filter applied", [$optionName => $request->input("options.$optionName")]);
//            }
//        }
//
//        // Build the URL query string
//        $queryString = http_build_query($urlParameters);
//
//        // Check if the request is for product grids or lists
//        if ($request->is('product-grids')) {
//            return redirect()->route('product-grids', '?' . $queryString);
//        } else {
//            return redirect()->route('product-lists', '?' . $queryString);
//        }
//    }



//    public function productSearch(Request $request){
//        $recent_products=Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();
//        $products=Product::orwhere('title','like','%'.$request->search.'%')
//                    ->orwhere('slug','like','%'.$request->search.'%')
//                    ->orwhere('description','like','%'.$request->search.'%')
//                    ->orwhere('summary','like','%'.$request->search.'%')
//                    ->orwhere('price','like','%'.$request->search.'%')
//                   ->orwhere('width','like','%'.$request->search.'%')
//                     ->orwhere('aspect_ratio','like','%'.$request->search.'%')
//                        ->orwhere('diameter','like','%'.$request->search.'%')
//                        ->orwhere('year','like','%'.$request->search.'%')
//                        ->orwhere('car_brand','like','%'.$request->search.'%')
//                        ->orwhere('model','like','%'.$request->search.'%')
//                        ->orwhere('option','like','%'.$request->search.'%')
//                        ->orwhere('season','like','%'.$request->search.'%')
//                    ->orderBy('id','DESC')
//                    ->paginate(8);
//
//        return view('frontend.pages.product-grids')->with('products',$products)->with('recent_products',$recent_products);
//    }

    public function productBrand(Request $request){
        $products=Brand::getProductByBrand($request->slug);
        $recent_products=Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        if(request()->is('e-shop.loc/product-grids')){
            return view('frontend.pages.product-grids')->with('products',$products->products)->with('recent_products',$recent_products);
        }
        else{
            return view('frontend.pages.product-lists')->with('products',$products->products)->with('recent_products',$recent_products);
        }

    }
    public function productCat(Request $request){
        $products=Category::getProductByCat($request->slug);
        // return $request->slug;
        $recent_products=Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();

        if(request()->is('e-shop.loc/product-grids')){
            return view('frontend.pages.product-grids')->with('products',$products->products)->with('recent_products',$recent_products);
        }
        else{
            return view('frontend.pages.product-lists')->with('products',$products->products)->with('recent_products',$recent_products);
        }

    }
    public function productSubCat(Request $request){
        $products=Category::getProductBySubCat($request->sub_slug);
        // return $products;
        $recent_products=Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();

        if(request()->is('e-shop.loc/product-grids')){
            return view('frontend.pages.product-grids')->with('products',$products->sub_products)->with('recent_products',$recent_products);
        }
        else{
            return view('frontend.pages.product-lists')->with('products',$products->sub_products)->with('recent_products',$recent_products);
        }

    }

    public function blog(){
        $post=Post::query();

        if(!empty($_GET['category'])){
            $slug=explode(',',$_GET['category']);
            // dd($slug);
            $cat_ids=PostCategory::select('id')->whereIn('slug',$slug)->pluck('id')->toArray();
            return $cat_ids;
            $post->whereIn('post_cat_id',$cat_ids);
            // return $post;
        }
        if(!empty($_GET['tag'])){
            $slug=explode(',',$_GET['tag']);
            // dd($slug);
            $tag_ids=PostTag::select('id')->whereIn('slug',$slug)->pluck('id')->toArray();
            // return $tag_ids;
            $post->where('post_tag_id',$tag_ids);
            // return $post;
        }

        if(!empty($_GET['show'])){
            $post=$post->where('status','active')->orderBy('id','DESC')->paginate($_GET['show']);
        }
        else{
            $post=$post->where('status','active')->orderBy('id','DESC')->paginate(9);
        }
        // $post=Post::where('status','active')->paginate(8);
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts',$post)->with('recent_posts',$rcnt_post);
    }

    public function blogDetail($slug){
        $post=Post::getPostBySlug($slug);
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        // return $post;
        return view('frontend.pages.blog-detail')->with('post',$post)->with('recent_posts',$rcnt_post);
    }

    public function blogSearch(Request $request){
        // return $request->all();
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        $posts=Post::orwhere('title','like','%'.$request->search.'%')
            ->orwhere('quote','like','%'.$request->search.'%')
            ->orwhere('summary','like','%'.$request->search.'%')
            ->orwhere('description','like','%'.$request->search.'%')
            ->orwhere('slug','like','%'.$request->search.'%')
            ->orderBy('id','DESC')
            ->paginate(8);
        return view('frontend.pages.blog')->with('posts',$posts)->with('recent_posts',$rcnt_post);
    }

    public function blogFilter(Request $request){
        $data=$request->all();
        // return $data;
        $catURL="";
        if(!empty($data['category'])){
            foreach($data['category'] as $category){
                if(empty($catURL)){
                    $catURL .='&category='.$category;
                }
                else{
                    $catURL .=','.$category;
                }
            }
        }

        $tagURL="";
        if(!empty($data['tag'])){
            foreach($data['tag'] as $tag){
                if(empty($tagURL)){
                    $tagURL .='&tag='.$tag;
                }
                else{
                    $tagURL .=','.$tag;
                }
            }
        }
        // return $tagURL;
            // return $catURL;
        return redirect()->route('blog',$catURL.$tagURL);
    }

    public function blogByCategory(Request $request){
        $post=PostCategory::getBlogByCategory($request->slug);
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts',$post->post)->with('recent_posts',$rcnt_post);
    }

    public function blogByTag(Request $request){
        // dd($request->slug);
        $post=Post::getBlogByTag($request->slug);
        // return $post;
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts',$post)->with('recent_posts',$rcnt_post);
    }

    // Login
    public function login(){
        return view('frontend.pages.login');
    }
    public function loginSubmit(Request $request){
        $data= $request->all();
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password'],'status'=>'active'])){
            Session::put('user',$data['email']);
            request()->session()->flash('success','Successfully login');
            return redirect()->route('home');
        }
        else{
            request()->session()->flash('error','Invalid email and password pleas try again!');
            return redirect()->back();
        }
    }

    public function logout(){
        Session::forget('user');
        Auth::logout();
        request()->session()->flash('success','Logout successfully');
        return back();
    }

    public function register(){
        return view('frontend.pages.register');
    }
    public function registerSubmit(Request $request){
        // return $request->all();
        $this->validate($request,[
            'name'=>'string|required|min:2',
            'email'=>'string|required|unique:users,email',
            'password'=>'required|min:6|confirmed',
        ]);
        $data=$request->all();
        // dd($data);
        $check=$this->create($data);
        Session::put('user',$data['email']);
        if($check){
            request()->session()->flash('success','Successfully registered');
            return redirect()->route('home');
        }
        else{
            request()->session()->flash('error','Please try again!');
            return back();
        }
    }
    public function create(array $data){
        return User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),
            'status'=>'active'
            ]);
    }
    // Reset password
    public function showResetForm(){
        return view('auth.passwords.old-reset');
    }

    public function subscribe(Request $request){
        if(! Newsletter::isSubscribed($request->email)){
                Newsletter::subscribePending($request->email);
                if(Newsletter::lastActionSucceeded()){
                    request()->session()->flash('success','Subscribed! Please check your email');
                    return redirect()->route('home');
                }
                else{
                    Newsletter::getLastError();
                    return back()->with('error','Something went wrong! please try again');
                }
            }
            else{
                request()->session()->flash('error','Already Subscribed');
                return back();
            }
    }

}
