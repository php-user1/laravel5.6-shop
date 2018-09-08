@extends('layouts.master')
@section('title', "| Home")

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex mb-5">
                <div class="mr-auto">
                    <h4 class="mt-1">All Products</h4>
                </div>
                @include('layouts.cart')
            </div>
        </div>
    </div>

    @if($products->count() <= 0)
        <h5 class="empty-items-message">Products list is empty</h5>
    @else

        <?php
            /*
                The manipulations with the code here are needed in order to correctly use the Bootstrap class 'card-deck'. 
                The task is such that there must be 3 products in a row. 
                These 3 products must be enclosed in a div with the class 'card-deck'. 
                If the products in the row are less than 3, class 'card-deck' should be replaced by my class 'redundant-deck'. All div's must be opened and closed properly.
            */

            $i = 0;
            $k = 4;
            $rowCount = floor($products->count() / 3);
            $redundant = $products->count() - ($rowCount * 3);
            $redundantClass = '';
        ?>

        @foreach($products as $key => $product)
            <?php $i++ ?>

            @if($i == 1 || $i == $k)  
                @if($i > 1)  
                    <?php $k += 3 ?>
                @endif

                @if(($redundant == 2 || $redundant == 1) && $products->count() - $redundant == $i - 1)
                    <?php $redundantClass = 'redundant-deck' ?>
                    <div class="{{ $redundantClass }} mb-4">
                @else
                    <div class="card-deck mb-4">
                @endif

            @endif
            
                <div class="card">
                    <img class="card-img-top mt-3 img-fluid" src="{{ asset('storage/products/' . $product->image) }}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('product', ['product' => $product->id]) }}">{{ $product->name }}</a>
                        </h5>
                        <p class="card-text">{{ str_limit($product->description, 100) }}</p>
                    </div>
                    <div class="card-footer">
                        <div class="card-text text-center">
                            <div class="mb-2">Price: $<small class="tag-strong text-muted">{{ $product->price }}</small></div>
                            <form class="add_to_cart">
                                @csrf
                                <input type="hidden" name="product-id" value="{{ $product->id }}">
                                <button class="btn btn-sm btn-outline-info mt-3">Add To Cart Foo</button>
                            </form>
                        </div>
                    </div>
                </div>

            @if($i == $k - 1)
                </div>
            @endif

        @endforeach

        @if($redundantClass)
            </div>
        @endif

    @endif
    
    <ul class="app-pagination pagination justify-content-center">
        {{ $products->links() }}
    </ul>

    <br>   
    <br>  
@endsection
