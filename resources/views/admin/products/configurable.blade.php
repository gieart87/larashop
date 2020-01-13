<p class="text-primary mt-4">Product Variants</p>
<hr/>
 @foreach ($product->variants as $variant)
 {!! Form::hidden('variants['. $variant->id .'][id]', $variant->id) !!}
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('sku', 'SKU') !!}
                {!! Form::text('variants['. $variant->id .'][sku]', $variant->sku, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('name', 'Name') !!}
                {!! Form::text('variants['. $variant->id .'][name]', $variant->name, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('price', 'Price') !!}
                {!! Form::text('variants['. $variant->id .'][price]', $variant->price, ['class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('qty', 'Stock') !!}
                {!! Form::text('variants['. $variant->id .'][qty]', ($variant->productInventory) ? $variant->productInventory->qty : null, ['class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('weight', 'Weight') !!}
                {!! Form::text('variants['. $variant->id .'][weight]', $variant->weight, ['class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>
    </div>
@endforeach
<hr/>