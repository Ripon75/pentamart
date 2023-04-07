@foreach ($products as $product)
<div class="">
    <x-frontend.product-thumb type="default" :product="$product" />
</div>
@endforeach
