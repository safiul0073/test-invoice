<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Group;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Product/Index', [
            'products' => Product::with(['group:id,name', 'variants'])->paginate(),
        ]);
    }

    public function create()
    {
        return Inertia::render(
            'Product/Create',
            [
                'groups' => Group::select('id', 'name')->get(),
                'variants' => Variant::select('id', 'name')->get()
            ]
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $attributes = $request->validated();

        $images = isset($attributes['images']) ? $attributes['images'] : null;
        $variant_ids = isset($attributes['variant_ids']) ? $attributes['variant_ids'] : null;
        try {
            DB::beginTransaction();

            if (isset($attributes['images'])) {
                unset($attributes['images']);
            }
            if (isset($attributes['variant_ids'])) {
                unset($attributes['variant_ids']);
            }

            $product = Product::create($attributes);

            /** variant uploading */
            if ($variant_ids && count($variant_ids)) {
                $product->productVariants()->createMany(
                    array_map(fn ($id) => (['variant_id' => $id]), $variant_ids)
                );
            }
            /** image uploading */
            if ($images && count($images)) {
                foreach($images as $image) {
                    $this->fileStore($product, $image);
                }
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('product.index')->with('message', $ex->getMessage());
        }


        return redirect()->route('product.index')->with('message', 'Product Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Product $product)
    {
        return Inertia::render(
            'Product/Show'
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return Inertia::render(
            'Product/Edit',
            [
                'groups' => Group::select('id', 'name')->get(),
                'variants' => Variant::select('id', 'name')->get()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()->route('product.index')->with('message', 'Product Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        return redirect()->route('product.index')->with('message', 'Product Delete Successfully');
    }

    private function fileStore (Product $product, $file) {
        $file_name = 'upload/'.rand(10000000, 9999999999).'_'.time().'_'.rand(50000, 9999).'.'.$file->getClientOriginalExtension();
        Storage::disk('public')->put($file_name, file_get_contents($file));
        $product->medias()->create([
            'url' => $file_name,
        ]);
    }
}
