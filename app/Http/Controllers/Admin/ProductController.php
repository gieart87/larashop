<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductImageRequest;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\ProductAttributeValue;
use App\Models\ProductInventory;

use Str;
use Auth;
use DB;
use Session;
use App\Authorizable;

class ProductController extends Controller
{
	use Authorizable;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->data['currentAdminMenu'] = 'catalog';
		$this->data['currentAdminSubMenu'] = 'product';

		$this->data['statuses'] = Product::statuses();
		$this->data['types'] = Product::types();
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$this->data['products'] = Product::orderBy('name', 'ASC')->paginate(10);

		return view('admin.products.index', $this->data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$categories = Category::orderBy('name', 'ASC')->get();
		$configurableAttributes = $this->_getConfigurableAttributes();

		$this->data['categories'] = $categories->toArray();
		$this->data['product'] = null;
		$this->data['productID'] = 0;
		$this->data['categoryIDs'] = [];
		$this->data['configurableAttributes'] = $configurableAttributes;

		return view('admin.products.form', $this->data);
	}

	/**
	 * Get configurable attributes for products
	 *
	 * @return array
	 */
	private function _getConfigurableAttributes()
	{
		return Attribute::where('is_configurable', true)->get();
	}

	/**
	 * Generate attribute combination depend on the provided attributes
	 *
	 * @param array $arrays attributes
	 *
	 * @return array
	 */
	private function _generateAttributeCombinations($arrays)
	{
		$result = [[]];
		foreach ($arrays as $property => $property_values) {
			$tmp = [];
			foreach ($result as $result_item) {
				foreach ($property_values as $property_value) {
					$tmp[] = array_merge($result_item, array($property => $property_value));
				}
			}
			$result = $tmp;
		}
		return $result;
	}

	/**
	 * Convert variant attributes as variant name
	 *
	 * @param array $variant variant
	 *
	 * @return string
	 */
	private function _convertVariantAsName($variant)
	{
		$variantName = '';
		
		foreach (array_keys($variant) as $key => $code) {
			$attributeOptionID = $variant[$code];
			$attributeOption = AttributeOption::find($attributeOptionID);
			
			if ($attributeOption) {
				$variantName .= ' - ' . $attributeOption->name;
			}
		}

		return $variantName;
	}

	/**
	 * Generate product variants for the configurable product
	 *
	 * @param Product $product product object
	 * @param array   $params  params
	 *
	 * @return void
	 */
	private function _generateProductVariants($product, $params)
	{
		$configurableAttributes = $this->_getConfigurableAttributes();

		$variantAttributes = [];
		foreach ($configurableAttributes as $attribute) {
			$variantAttributes[$attribute->code] = $params[$attribute->code];
		}

		$variants = $this->_generateAttributeCombinations($variantAttributes);
		
		if ($variants) {
			foreach ($variants as $variant) {
				$variantParams = [
					'parent_id' => $product->id,
					'user_id' => Auth::user()->id,
					'sku' => $product->sku . '-' .implode('-', array_values($variant)),
					'type' => 'simple',
					'name' => $product->name . $this->_convertVariantAsName($variant),
				];

				$variantParams['slug'] = Str::slug($variantParams['name']);

				$newProductVariant = Product::create($variantParams);

				$categoryIds = !empty($params['category_ids']) ? $params['category_ids'] : [];
				$newProductVariant->categories()->sync($categoryIds);

				$this->_saveProductAttributeValues($newProductVariant, $variant, $product->id);
			}
		}
	}

	/**
	 * Save the product attribute values
	 *
	 * @param Product $product         product object
	 * @param array   $variant         variant
	 * @param int     $parentProductID parent product ID
	 *
	 * @return void
	 */
	private function _saveProductAttributeValues($product, $variant, $parentProductID)
	{
		foreach (array_values($variant) as $attributeOptionID) {
			$attributeOption = AttributeOption::find($attributeOptionID);
		   
			$attributeValueParams = [
				'parent_product_id' => $parentProductID,
				'product_id' => $product->id,
				'attribute_id' => $attributeOption->attribute_id,
				'text_value' => $attributeOption->name,
			];

			ProductAttributeValue::create($attributeValueParams);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param ProductRequest $request params
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(ProductRequest $request)
	{
		$params = $request->except('_token');
		$params['slug'] = Str::slug($params['name']);
		$params['user_id'] = Auth::user()->id;

		$product = DB::transaction(
			function () use ($params) {
				$categoryIds = !empty($params['category_ids']) ? $params['category_ids'] : [];
				$product = Product::create($params);
				$product->categories()->sync($categoryIds);

				if ($params['type'] == 'configurable') {
					$this->_generateProductVariants($product, $params);
				}

				return $product;
			}
		);

		if ($product) {
			Session::flash('success', 'Product has been saved');
		} else {
			Session::flash('error', 'Product could not be saved');
		}

		return redirect('admin/products/'. $product->id .'/edit/');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id product ID
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if (empty($id)) {
			return redirect('admin/products/create');
		}

		$product = Product::findOrFail($id);
		$product->qty = isset($product->productInventory) ? $product->productInventory->qty : null;

		$categories = Category::orderBy('name', 'ASC')->get();

		$this->data['categories'] = $categories->toArray();
		$this->data['product'] = $product;
		$this->data['productID'] = $product->id;
		$this->data['categoryIDs'] = $product->categories->pluck('id')->toArray();

		return view('admin.products.form', $this->data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param ProductRequest $request params
	 * @param int            $id      product ID
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(ProductRequest $request, $id)
	{
		$params = $request->except('_token');
		$params['slug'] = Str::slug($params['name']);

		$product = Product::findOrFail($id);

		$saved = false;
		$saved = DB::transaction(
			function () use ($product, $params) {
				$categoryIds = !empty($params['category_ids']) ? $params['category_ids'] : [];
				$product->update($params);
				$product->categories()->sync($categoryIds);

				if ($product->type == 'configurable') {
					$this->_updateProductVariants($params);
				} else {
					ProductInventory::updateOrCreate(['product_id' => $product->id], ['qty' => $params['qty']]);
				}

				return true;
			}
		);

		if ($saved) {
			Session::flash('success', 'Product has been saved');
		} else {
			Session::flash('error', 'Product could not be saved');
		}

		return redirect('admin/products');
	}

	/**
	 * Product variants
	 *
	 * @param array $params params
	 *
	 * @return void
	 */
	private function _updateProductVariants($params)
	{
		if ($params['variants']) {
			foreach ($params['variants'] as $productParams) {
				$product = Product::find($productParams['id']);
				$product->update($productParams);

				$product->status = $params['status'];
				$product->save();
				
				ProductInventory::updateOrCreate(['product_id' => $product->id], ['qty' => $productParams['qty']]);
			}
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id product id
	 *
	 * @return void
	 */
	public function destroy($id)
	{
		$product  = Product::findOrFail($id);

		if ($product->delete()) {
			Session::flash('success', 'Product has been deleted');
		}

		return redirect('admin/products');
	}

	/**
	 * Show product images
	 *
	 * @param int $id product id
	 *
	 * @return void
	 */
	public function images($id)
	{
		if (empty($id)) {
			return redirect('admin/products/create');
		}

		$product = Product::findOrFail($id);

		$this->data['productID'] = $product->id;
		$this->data['productImages'] = $product->productImages;

		return view('admin.products.images', $this->data);
	}

	/**
	 * Show add image form
	 *
	 * @param int $id product id
	 *
	 * @return Response
	 */
	public function addImage($id)
	{
		if (empty($id)) {
			return redirect('admin/products');
		}

		$product = Product::findOrFail($id);

		$this->data['productID'] = $product->id;
		$this->data['product'] = $product;

		return view('admin.products.image_form', $this->data);
	}

	/**
	 * Upload image
	 *
	 * @param ProductImageRequest $request params
	 * @param int                 $id      product id
	 *
	 * @return Response
	 */
	public function uploadImage(ProductImageRequest $request, $id)
	{
		$product = Product::findOrFail($id);

		if ($request->has('image')) {
			$image = $request->file('image');
			$name = $product->slug . '_' . time();
			$fileName = $name . '.' . $image->getClientOriginalExtension();

			$folder = ProductImage::UPLOAD_DIR. '/images';

			$filePath = $image->storeAs($folder . '/original', $fileName, 'public');

			$resizedImage = $this->_resizeImage($image, $fileName, $folder);

			$params = array_merge(
				[
					'product_id' => $product->id,
					'path' => $filePath,
				],
				$resizedImage
			);

			if (ProductImage::create($params)) {
				Session::flash('success', 'Image has been uploaded');
			} else {
				Session::flash('error', 'Image could not be uploaded');
			}

			return redirect('admin/products/' . $id . '/images');
		}
	}

	/**
	 * Resize image
	 *
	 * @param file   $image    raw file
	 * @param string $fileName image file name
	 * @param string $folder   folder name
	 *
	 * @return Response
	 */
	private function _resizeImage($image, $fileName, $folder)
	{
		$resizedImage = [];

		$smallImageFilePath = $folder . '/small/' . $fileName;
		$size = explode('x', ProductImage::SMALL);
		list($width, $height) = $size;

		$smallImageFile = \Image::make($image)->fit($width, $height)->stream();
		if (\Storage::put('public/' . $smallImageFilePath, $smallImageFile)) {
			$resizedImage['small'] = $smallImageFilePath;
		}
		
		$mediumImageFilePath = $folder . '/medium/' . $fileName;
		$size = explode('x', ProductImage::MEDIUM);
		list($width, $height) = $size;

		$mediumImageFile = \Image::make($image)->fit($width, $height)->stream();
		if (\Storage::put('public/' . $mediumImageFilePath, $mediumImageFile)) {
			$resizedImage['medium'] = $mediumImageFilePath;
		}

		$largeImageFilePath = $folder . '/large/' . $fileName;
		$size = explode('x', ProductImage::LARGE);
		list($width, $height) = $size;

		$largeImageFile = \Image::make($image)->fit($width, $height)->stream();
		if (\Storage::put('public/' . $largeImageFilePath, $largeImageFile)) {
			$resizedImage['large'] = $largeImageFilePath;
		}

		$extraLargeImageFilePath  = $folder . '/xlarge/' . $fileName;
		$size = explode('x', ProductImage::EXTRA_LARGE);
		list($width, $height) = $size;

		$extraLargeImageFile = \Image::make($image)->fit($width, $height)->stream();
		if (\Storage::put('public/' . $extraLargeImageFilePath, $extraLargeImageFile)) {
			$resizedImage['extra_large'] = $extraLargeImageFilePath;
		}

		return $resizedImage;
	}

	/**
	 * Remove image
	 *
	 * @param int $id image id
	 *
	 * @return Response
	 */
	public function removeImage($id)
	{
		$image = ProductImage::findOrFail($id);

		if ($image->delete()) {
			Session::flash('success', 'Image has been deleted');
		}

		return redirect('admin/products/' . $image->product->id . '/images');
	}
}
