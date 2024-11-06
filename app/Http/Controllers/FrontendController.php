<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\Product;
use App\Models\ProductOption;
use App\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Newsletter\Facades\Newsletter;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
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
        $products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(8)->get();
        $category = Category::where('status', 'active')->where('is_parent', 1)->orderBy('title', 'ASC')->get();

        // Get categories by slug
        $pneuJantes = Category::where('slug', 'pneujantes')->first();
        $pneu = Category::where('slug', 'pneu')->first();
        $rouesJantes = Category::where('slug', 'rouesjantes')->first();

        // Fetch car details and product dimensions based on the category ID
        $pneuYears = $this->fetchYears($pneu->id);
        $pneuCar_brands = $this->fetchBrands($pneu->id);
        $pneuModels = $this->fetchModels($pneu->id);
        $pneuOptions = $this->fetchCarOptions($pneu->id);

        $pneuJantesYears = $this->fetchYears($pneuJantes->id);
        $pneuJantesCar_brands = $this->fetchBrands($pneuJantes->id);
        $pneuJantesModels = $this->fetchModels($pneuJantes->id);
        $pneuJantesOptions = $this->fetchCarOptions($pneuJantes->id);
        $pneuDimensions = $this->fetchPneuDimensions($pneu->id);
        $rouesJantesDimensions = $this->fetchRouesJantesDimensions($rouesJantes->id);

        Log::info('Fetched Data:', [
            'pneuYears' => $pneuYears,
            'pneuCar_brands' => $pneuCar_brands,
            'pneuModels' => $pneuModels,
            'pneuOptions' => $pneuOptions,
            'pneuJantesYears' => $pneuJantesYears,
            'pneuJantesCar_brands' => $pneuJantesCar_brands,
            'pneuJantesModels' => $pneuJantesModels,
            'pneuJantesOptions' => $pneuJantesOptions,
            'pneuDimensions' => $pneuDimensions,
            'rouesJantesDimensions' => $rouesJantesDimensions,
        ]);

        return view('frontend.index')
            ->with('featured', $featured)
            ->with('posts', $posts)
            ->with('banners', $banners)
            ->with('product_lists', $products)
            ->with('category_lists', $category)
            ->with('pneuYears', $pneuYears)
            ->with('pneuCar_brands', $pneuCar_brands)
            ->with('pneuModels', $pneuModels)
            ->with('pneuOptions', $pneuOptions)
            ->with('pneuJantesYears', $pneuJantesYears)
            ->with('pneuJantesCar_brands', $pneuJantesCar_brands)
            ->with('pneuJantesModels', $pneuJantesModels)
            ->with('pneuJantesOptions', $pneuJantesOptions)
            ->with('pneuDimensions', $pneuDimensions)
            ->with('rouesJantesDimensions', $rouesJantesDimensions);
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

    private function fetchCarOptions($categoryId)
    {
        return Brand::join('products', 'brands.id', '=', 'products.brand_id')
            ->where('products.cat_id', $categoryId)
            ->select('brands.option')
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
                    Log::info('Category filter applied', ['category' => $category->slug]);
                }
            }

            // Apply width filter
            if ($request->filled('width')) {
                $query->where('width', $request->width);
                Log::info('Width filter applied', ['width' => $request->width]);
            }

            // Apply aspect_ratio filter
            if ($request->filled('aspect_ratio')) {
                $query->where('aspect_ratio', $request->aspect_ratio);
                Log::info('Aspect Ratio filter applied', ['aspect_ratio' => $request->aspect_ratio]);
            }

            // Apply diameter filter
            if ($request->filled('diameter')) {
                $query->where('diameter', $request->diameter);
                Log::info('Diameter filter applied', ['diameter' => $request->diameter]);
            }

            // Apply season filter
            if ($request->filled('season')) {
                $seasons = (array) $request->season;  // Convert to array to handle single or multiple seasons
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
                Log::info('Car filters applied', ['year' => $request->year, 'car_brand' => $request->car_brand, 'model' => $request->model]);
            }

            // Apply option filter
            if ($request->filled('option')) {
                $query->where('option', $request->option);
                Log::info('Option filter applied', ['option' => $request->option]);
            }

            // Apply service type filter
            if ($request->filled('service_type')) {
                $query->where('service_type', $request->service_type);
                Log::info('Service Type filter applied', ['service_type' => $request->service_type]);
            }

            // Apply shipping weight filter
            if ($request->filled('shipping_weight')) {
                $query->where('shipping_weight', '>=', $request->shipping_weight);
                Log::info('Shipping Weight filter applied', ['shipping_weight' => $request->shipping_weight]);
            }

            // Apply speed index filter
            if ($request->filled('speed_index')) {
                $query->where('speed_index', $request->speed_index);
                Log::info('Speed Index filter applied', ['speed_index' => $request->speed_index]);
            }

            // Apply load index filter
            if ($request->filled('load_index')) {
                $query->where('load_index', $request->load_index);
                Log::info('Load Index filter applied', ['load_index' => $request->load_index]);
            }

            // Apply boolean fields
            if ($request->has('runflat')) {
                $query->where('runflat', true);
                Log::info('Runflat filter applied');
            }
            if ($request->has('extra_load')) {
                $query->where('extra_load', true);
                Log::info('Extra Load filter applied');
            }
            if ($request->has('pneu_renforce')) {
                $query->where('pneu_renforce', true);
                Log::info('Pneu Renforcé filter applied');
            }

            // Apply discount filter
            if ($request->has('discount')) {
                $query->where('discount', '>', 0);
                Log::info('Discount filter applied');
            }

            // Fetch distinct values for filters
            $service_types = Product::distinct()->pluck('service_type');
            $shipping_weights = Product::distinct()->pluck('shipping_weight');
            $speed_indexes = Product::distinct()->pluck('speed_index');
            $load_indexes = Product::distinct()->pluck('load_index');

            $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

            // Pagination settings
            $itemsPerPage = $request->get('show', 6);
            $products = $query->where('status', 'active')->paginate($itemsPerPage);

            // Return the view with the filtered data
            return view('frontend.pages.product-grids', compact('products', 'recent_products', 'service_types', 'shipping_weights', 'speed_indexes', 'load_indexes'));
        } catch (\Exception $e) {
            Log::error('Error fetching products', ['error' => $e->getMessage()]);

            return redirect()->back()->with('error', 'Error fetching products');
        }
    }

    public function filterResults(Request $request)
    {
        // Fetch the car brand, model, and year from the request
        $carBrand = $request->input('car_brand');
        $carModel = $request->input('model');
        $carYear = $request->input('year');
        $option = $request->input('option');

        // Validate if car brand, model, and year are provided
        if (! $carBrand || ! $carModel || ! $carYear) {
            return redirect()->back()->with('error', 'Please provide car brand, model, and year.');
        }

        // Fetch the car details from the brands table
        $brandQuery = Brand::where('car_brand', $carBrand)
            ->where('car_model', $carModel)
            ->where('car_year', $carYear);

        // Apply option filter if provided, directly from the brand table
        if ($option) {
            $brandQuery->where('option', $option);
        }

        // Get the brand after filtering
        $brand = $brandQuery->first();

        // Check if brand exists
        if (! $brand) {
            return redirect()->back()->with('error', 'Car brand, model, year, or option not found.');
        }

        // Construct the car name dynamically
        $carName = "{$carYear} {$carBrand} {$carModel}";

        // Fetch categories (if needed)
        $categories = Category::all();

        // Fetch products based on the brand id from the brand table
        $products = Product::where('brand_id', $brand->id)
            ->select('products.*')
            ->distinct()
            ->get();

        // Return the view with the filtered data
        return view('frontend.partials.filter-results', compact('carName', 'categories', 'products', 'option'));
    }

    public function aboutUs()
    {
        return view('frontend.pages.about-us');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function productDetail($slug)
    {
        // Fetch product details by slug
        $product_detail = Product::with('options')->where('slug', $slug)->firstOrFail();

        // Fetch product options related to the product
        $product_options = ProductOption::join('product_option_product', 'product_options.id', '=', 'product_option_product.product_option_id')
            ->where('product_option_product.product_id', $product_detail->id)
            ->select('product_options.*') // Fetch all columns from ProductOption
            ->get();

        // Prepare the full specification array
        $specifications = [
            'Manufacturier' => $product_detail->brand, // Assuming a relation to the brand table
            'Cloutable' => optional($product_options->where('name', 'cloutable')->first())->value ?? 'non',
            'Saison' => $product_detail->season ?? 'N/A',
            'Code produit' => $product_detail->code ?? 'N/A',
            'Largeur du pneu' => $product_detail->width ?? 'N/A',
            'Ratio du pneu' => $product_detail->aspect_ratio ?? 'N/A',
            'Diamètre du pneu' => $product_detail->diameter ?? 'N/A',
            'Indice de charge' => optional($product_options->where('name', 'charge')->first())->value ?? 'N/A',
            'Indice de vitesse' => optional($product_options->where('name', 'vitesse')->first())->value ?? 'N/A',
            'Flancs porteurs (Runflat)' => optional($product_options->where('name', 'runflat')->first())->is_boolean == 1 ? 'oui' : 'non',
            'Pneu renforcé' => optional($product_options->where('name', 'xl_renforces')->first())->is_boolean == 1 ? 'oui' : 'non',
            'Extra Load' => optional($product_options->where('name', 'charge')->first())->value == 'XL' ? 'oui' : 'non',
        ];

        // Return the view with product details and specifications
        return view('frontend.pages.product_detail', compact('product_detail', 'specifications'));
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
    //car_brand
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

    public function productViewL(Request $request, $viewType = 'list')
    {
        Log::info('Product view initiated (List)', $request->all());

        $products = Product::query();

        // Apply filters for product dimensions
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

        // Car information filters
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
            Log::info('Car info filter applied', ['year' => $request->year, 'car_brand' => $request->car_brand, 'model' => $request->model]);
        }

        $carName = "{$request->year} {$request->car_brand} {$request->model}";

        // Category filter
        if ($request->filled('category')) {
            $slug = explode(',', $request->get('category'));
            $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            $products->whereIn('cat_id', $cat_ids);
            Log::info('Category filter applied', ['categories' => $slug]);
        }

        // Brand filter
        if ($request->filled('brand')) {
            $slugs = explode(',', $request->get('brand'));
            $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
            $products->whereIn('brand_id', $brand_ids);
            Log::info('Brand filter applied', ['brands' => $slugs]);
        }

        // Price range filter
        if ($request->filled('price')) {
            $price = explode('-', $request->price);
            if (count($price) === 2) {
                $products->whereBetween('price', [$price[0], $price[1]]);
                Log::info('Price filter applied', ['price' => $price]);
            }
        }

        // Filters for new fields
        if ($request->filled('service_type')) {
            $products->where('service_type', $request->service_type);
            Log::info('Service Type filter applied', ['service_type' => $request->service_type]);
        }
        if ($request->filled('shipping_weight')) {
            $products->where('shipping_weight', '>=', $request->shipping_weight);
            Log::info('Shipping Weight filter applied', ['shipping_weight' => $request->shipping_weight]);
        }
        if ($request->filled('speed_index')) {
            $products->where('speed_index', $request->speed_index);
            Log::info('Speed Index filter applied', ['speed_index' => $request->speed_index]);
        }
        if ($request->filled('load_index')) {
            $products->where('load_index', $request->load_index);
            Log::info('Load Index filter applied', ['load_index' => $request->load_index]);
        }
        if ($request->has('runflat')) {
            $products->where('runflat', true);
            Log::info('Runflat filter applied');
        }
        if ($request->has('extra_load')) {
            $products->where('extra_load', true);
            Log::info('Extra Load filter applied');
        }
        if ($request->has('pneu_renforce')) {
            $products->where('pneu_renforce', true);
            Log::info('Pneu Renforcé filter applied');
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

        // Remove the dd() to avoid stopping execution
        Log::info('Executing product query', ['query' => $products->toSql(), 'bindings' => $products->getBindings()]);

        // Fetch unique values for the filter options
        $service_types = Product::distinct()->pluck('service_type');
        $shipping_weights = Product::distinct()->pluck('shipping_weight');
        $speed_indexes = Product::distinct()->pluck('speed_index');
        $load_indexes = Product::distinct()->pluck('load_index');

        // Log filter data for debugging
        Log::info('Filter Data', [
            'service_types' => $service_types,
            'shipping_weights' => $shipping_weights,
            'speed_indexes' => $speed_indexes,
            'load_indexes' => $load_indexes,
        ]);

        // Pagination settings
        $itemsPerPage = $request->get('show', 6);
        $products = $products->where('status', 'active')->paginate($itemsPerPage);

        return view('frontend.pages.product-lists')->with([
            'products' => $products,
            'service_types' => $service_types,
            'shipping_weights' => $shipping_weights,
            'speed_indexes' => $speed_indexes,
            'load_indexes' => $load_indexes,
            'recent_products' => $recent_products ?? [],
            'carName' => $carName ?? null,
            'width' => $request->width,
            'aspect_ratio' => $request->aspect_ratio,
            'diameter' => $request->diameter,
            'year' => $request->year,
            'car_brand' => $request->car_brand,
            'model' => $request->model,
        ]);
    }

    public function productViewG(Request $request, $viewType = 'grid')
    {
        Log::info('Product view initiated (Grid)', $request->all());

        $products = Product::query();

        // Same filtering logic as productViewL for consistency
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

        // Car info filter
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
            Log::info('Car info filter applied', ['year' => $request->year, 'car_brand' => $request->car_brand, 'model' => $request->model]);
        }

        $carName = "{$request->year} {$request->car_brand} {$request->model}";

        // Filters applied as in productViewL
        // Add logic for category, brand, price, and other filters similar to productViewL

        // Fetch unique values for the filter options
        $service_types = Product::distinct()->pluck('service_type');
        $shipping_weights = Product::distinct()->pluck('shipping_weight');
        $speed_indexes = Product::distinct()->pluck('speed_index');
        $load_indexes = Product::distinct()->pluck('load_index');

        // Log filter data for debugging
        Log::info('Filter Data', [
            'service_types' => $service_types,
            'shipping_weights' => $shipping_weights,
            'speed_indexes' => $speed_indexes,
            'load_indexes' => $load_indexes,
        ]);

        $itemsPerPage = $request->get('show', 9);
        $products = $products->where('status', 'active')->paginate($itemsPerPage);

        return view('frontend.pages.product-grids')->with([
            'products' => $products,
            'recent_products' => Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get(),
            'carName' => $carName ?? null,
            'width' => $request->width,
            'aspect_ratio' => $request->aspect_ratio,
            'diameter' => $request->diameter,
            'year' => $request->year,
            'car_brand' => $request->car_brand,
            'model' => $request->model,
            'service_types' => $service_types,
            'shipping_weights' => $shipping_weights,
            'speed_indexes' => $speed_indexes,
            'load_indexes' => $load_indexes,
        ]);
    }

    public function productView(Request $request, $viewType = 'grid')
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
                'model' => $request->model,
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

        // Apply price range filter
        if ($request->filled('price')) {
            $price = explode('-', $request->price);
            if (count($price) === 2) {
                $products->whereBetween('price', [$price[0], $price[1]]);
                Log::info('Price filter applied', ['price' => $price]);
            }
        }

        // Apply filters for new fields in the products table
        // Adjusted to access from 'options' array
        if ($request->filled('options.service_type')) {
            $products->where('service_type', $request->input('options.service_type'));
            Log::info('Service Type filter applied', ['service_type' => $request->input('options.service_type')]);
        }

        if ($request->filled('options.shipping_weight')) {
            $products->where('shipping_weight', '>=', $request->input('options.shipping_weight'));
            Log::info('Shipping Weight filter applied', ['shipping_weight' => $request->input('options.shipping_weight')]);
        }

        if ($request->filled('options.speed_index')) {
            $products->where('speed_index', $request->input('options.speed_index'));
            Log::info('Speed Index filter applied', ['speed_index' => $request->input('options.speed_index')]);
        }

        if ($request->filled('options.load_index')) {
            $products->where('load_index', $request->input('options.load_index'));
            Log::info('Load Index filter applied', ['load_index' => $request->input('options.load_index')]);
        }

        // Apply boolean fields (runflat, extra_load, pneu_renforce)
        if ($request->has('options.runflat')) {
            $products->where('runflat', true);
            Log::info('Runflat filter applied');
        }

        if ($request->has('options.extra_load')) {
            $products->where('extra_load', true);
            Log::info('Extra Load filter applied');
        }

        if ($request->has('options.pneu_renforce')) {
            $products->where('pneu_renforce', true);
            Log::info('Pneu Renforcé filter applied');
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

        // Filter by name or description
        if ($request->filled('search')) {
            $products->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                    ->orWhere('slug', 'like', '%'.$request->search.'%')
                    ->orWhere('description', 'like', '%'.$request->search.'%')
                    ->orWhere('summary', 'like', '%'.$request->search.'%')
                    ->orWhere('price', 'like', '%'.$request->search.'%')
                    ->orWhere('width', 'like', '%'.$request->search.'%')
                    ->orWhere('aspect_ratio', 'like', '%'.$request->search.'%')
                    ->orWhere('diameter', 'like', '%'.$request->search.'%');
            });
            Log::info('Search filter applied', ['search' => $request->search]);
        }

        // Fetch distinct values for filters
        $service_types = Product::distinct()->pluck('service_type');
        $shipping_weights = Product::distinct()->pluck('shipping_weight');
        $speed_indexes = Product::distinct()->pluck('speed_index');
        $load_indexes = Product::distinct()->pluck('load_index');

        // Execute the query and log it
        Log::info('Executing product query', ['query' => $products->toSql(), 'bindings' => $products->getBindings()]);

        // Fetch recent products
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        // Determine pagination and view type
        $itemsPerPage = $request->get('show', $viewType === 'grid' ? 9 : 6);
        $products = $products->where('status', 'active')->paginate($itemsPerPage);

        // Determine the view to render
        $view = $viewType === 'grid' ? 'frontend.pages.product-grids' : 'frontend.pages.product-lists';

        // Return the view with the data
        return view($view)->with([
            'products' => $products,
            'recent_products' => $recent_products,
            'carName' => $carName ?? null,
            'width' => $request->width,
            'aspect_ratio' => $request->aspect_ratio,
            'diameter' => $request->diameter,
            'year' => $request->year,
            'car_brand' => $request->car_brand,
            'model' => $request->model,
            'service_types' => $service_types,
            'shipping_weights' => $shipping_weights,
            'speed_indexes' => $speed_indexes,
            'load_indexes' => $load_indexes,
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

    public function productBrand(Request $request)
    {
        $products = Brand::getProductByBrand($request->slug);
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        if (request()->is('e-shop.loc/product-grids')) {
            return view('frontend.pages.product-grids')->with('products', $products->products)->with('recent_products', $recent_products);
        } else {
            return view('frontend.pages.product-lists')->with('products', $products->products)->with('recent_products', $recent_products);
        }

    }

    public function productCat(Request $request)
    {
        $category = Category::where('slug', $request->slug)->first();

        // Fetch products under the category and paginate the results
        $products = Product::where('cat_id', $category->id)->paginate(10);

        // Fetch distinct values for filters
        $service_types = Product::distinct()->pluck('service_type');
        $shipping_weights = Product::distinct()->pluck('shipping_weight');
        $speed_indexes = Product::distinct()->pluck('speed_index');
        $load_indexes = Product::distinct()->pluck('load_index');

        // Fetch recent products
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        // Determine the view to render based on the request URL
        if (request()->is('e-shop.loc/product-grids')) {
            return view('frontend.pages.product-grids')->with([
                'products' => $products,
                'recent_products' => $recent_products,
                'service_types' => $service_types,
                'shipping_weights' => $shipping_weights,
                'speed_indexes' => $speed_indexes,
                'load_indexes' => $load_indexes,
            ]);
        } else {
            return view('frontend.pages.product-lists')->with([
                'products' => $products,
                'recent_products' => $recent_products,
                'service_types' => $service_types,
                'shipping_weights' => $shipping_weights,
                'speed_indexes' => $speed_indexes,
                'load_indexes' => $load_indexes,
            ]);
        }
    }

    public function productSubCat(Request $request)
    {
        $products = Category::getProductBySubCat($request->sub_slug);
        // return $products;
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        if (request()->is('e-shop.loc/product-grids')) {
            return view('frontend.pages.product-grids')->with('products', $products->sub_products)->with('recent_products', $recent_products);
        } else {
            return view('frontend.pages.product-lists')->with('products', $products->sub_products)->with('recent_products', $recent_products);
        }

    }

    public function blog()
    {
        $post = Post::query();

        if (! empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = PostCategory::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();

            return $cat_ids;
            $post->whereIn('post_cat_id', $cat_ids);
            // return $post;
        }
        if (! empty($_GET['tag'])) {
            $slug = explode(',', $_GET['tag']);
            // dd($slug);
            $tag_ids = PostTag::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // return $tag_ids;
            $post->where('post_tag_id', $tag_ids);
            // return $post;
        }

        if (! empty($_GET['show'])) {
            $post = $post->where('status', 'active')->orderBy('id', 'DESC')->paginate($_GET['show']);
        } else {
            $post = $post->where('status', 'active')->orderBy('id', 'DESC')->paginate(9);
        }
        // $post=Post::where('status','active')->paginate(8);
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        return view('frontend.pages.blog')->with('posts', $post)->with('recent_posts', $rcnt_post);
    }

    public function blogDetail($slug)
    {
        $post = Post::getPostBySlug($slug);
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        // return $post;
        return view('frontend.pages.blog-detail')->with('post', $post)->with('recent_posts', $rcnt_post);
    }

    public function blogSearch(Request $request)
    {
        // return $request->all();
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $posts = Post::orwhere('title', 'like', '%'.$request->search.'%')
            ->orwhere('quote', 'like', '%'.$request->search.'%')
            ->orwhere('summary', 'like', '%'.$request->search.'%')
            ->orwhere('description', 'like', '%'.$request->search.'%')
            ->orwhere('slug', 'like', '%'.$request->search.'%')
            ->orderBy('id', 'DESC')
            ->paginate(8);

        return view('frontend.pages.blog')->with('posts', $posts)->with('recent_posts', $rcnt_post);
    }

    public function blogFilter(Request $request)
    {
        $data = $request->all();
        // return $data;
        $catURL = '';
        if (! empty($data['category'])) {
            foreach ($data['category'] as $category) {
                if (empty($catURL)) {
                    $catURL .= '&category='.$category;
                } else {
                    $catURL .= ','.$category;
                }
            }
        }

        $tagURL = '';
        if (! empty($data['tag'])) {
            foreach ($data['tag'] as $tag) {
                if (empty($tagURL)) {
                    $tagURL .= '&tag='.$tag;
                } else {
                    $tagURL .= ','.$tag;
                }
            }
        }

        // return $tagURL;
        // return $catURL;
        return redirect()->route('blog', $catURL.$tagURL);
    }

    public function blogByCategory(Request $request)
    {
        $post = PostCategory::getBlogByCategory($request->slug);
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        return view('frontend.pages.blog')->with('posts', $post->post)->with('recent_posts', $rcnt_post);
    }

    public function blogByTag(Request $request)
    {
        // dd($request->slug);
        $post = Post::getBlogByTag($request->slug);
        // return $post;
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        return view('frontend.pages.blog')->with('posts', $post)->with('recent_posts', $rcnt_post);
    }

    // Login
    public function login()
    {
        return view('frontend.pages.login');
    }

    public function loginSubmit(Request $request)
    {
        $data = $request->all();
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 'active'])) {
            Session::put('user', $data['email']);
            request()->session()->flash('success', 'Successfully login');

            return redirect()->route('home');
        } else {
            request()->session()->flash('error', 'Invalid email and password pleas try again!');

            return redirect()->back();
        }
    }

    public function logout()
    {
        Session::forget('user');
        Auth::logout();
        request()->session()->flash('success', 'Logout successfully');

        return back();
    }

    public function register()
    {
        return view('frontend.pages.register');
    }

    public function registerSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|min:2',
            'email' => 'string|required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create the user instance
        $user = $this->create($request->all());

        // Debugging: Check if user was created
        if ($user) {
            Log::info('User created successfully.');
        } else {
            Log::error('User creation failed.');
        }

        // Check if the user instance implements the MustVerifyEmail interface
        if ($user instanceof MustVerifyEmail) {
            Log::info('User must verify email.');

            // Send the email verification notification
            $user->sendEmailVerificationNotification();

            // Log out the user to enforce email verification
            Auth::logout();

            // Redirect to the verification notice route with a success message
            return redirect()->route('verification.notice')->with('success', 'Successfully registered. Please check your email to verify your account.');
        }

        // Automatically log in the user if email verification is not required
        Auth::login($user);

        // Store the user's email in the session and redirect
        Session::put('user', $user->email);
        request()->session()->flash('success', 'Successfully registered');

        // Debugging: Check if the user is being logged in
        Log::info('User logged in.');

        // Redirect to the home page or any other page after successful registration
        return redirect()->route('verification.notice')->with('success', 'Successfully registered. Please check your email to verify your account.');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active',
        ]);
    }

    // Reset password
    public function showResetForm()
    {
        return view('auth.passwords.old-reset');
    }

    public function resetPassword(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required',
        ]);

        // Check if the token is valid
        $user = \App\User::where('email', $request->email)->first();
        if (! $user || ! \Illuminate\Support\Facades\Password::tokenExists($user, $request->token)) {
            return redirect()->back()->with('error', 'Invalid token or email.');
        }

        // Update the user's password
        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->save();

        // Optionally, you can delete the token after successful password reset
        \Illuminate\Support\Facades\Password::deleteToken($user);

        // Redirect to login page with success message
        return redirect()->route('login.form')->with('success', 'Your password has been reset successfully.');
    }

    public function subscribe(Request $request)
    {
        if (! Newsletter::isSubscribed($request->email)) {
            Newsletter::subscribePending($request->email);
            if (Newsletter::lastActionSucceeded()) {
                request()->session()->flash('success', 'Subscribed! Please check your email');

                return redirect()->route('home');
            } else {
                Newsletter::getLastError();

                return back()->with('error', 'Something went wrong! please try again');
            }
        } else {
            request()->session()->flash('error', 'Already Subscribed');

            return back();
        }
    }
}
