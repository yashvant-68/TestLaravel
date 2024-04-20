@extends('layout')

@section('content')
    <section class="container">
        
        <div class="d-flex mb-4">
            <a href="{{route('get_products')}}" class="btn btn-sm btn-primary">
                <div class="d-flex justify-content-center align-items-center">
                    <span class="material-symbols-outlined" style="font-size: 16px;margin-right: 3.5px !important;">arrow_back</span>
                    Back
                </div>
            </a>
        </div>
        <h1 class="text-center text-dark mb-4">Product Details</h1>
        

        <div class="row row-cols-md-4 row-cols-sm-3 row-cols-2 mb-4">
            <div class="col px-3 py-2">
                <span class="text-muted">Name : </span> <span class="text-dark">{{$product->name}}</span>
            </div>
            <div class="col px-3 py-2">
                <span class="text-muted">Brand : </span> <span class="text-dark">{{$product->brand_name}}</span>
            </div>
            <div class="col px-3 py-2">
                <span class="text-muted">Category : </span> <span class="text-dark">{{$product->catagory_name}}</span>
            </div>
            <div class="col px-3 py-2">
                <span class="text-muted">Sub-catagory : </span> <span class="text-dark">{{$product->subcatagory_name}}</span>
            </div>
        </div>

        <h4>Variants</h4>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Selling Price</th>
                        <th>Discount</th>
                        <!-- <th>Action</th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($variants as $variant)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                                {{$variant->color_name}}
                            </td>
                            <td>
                                {{$variant->size_name}}
                            </td>
                            <td>
                                {{$variant->quantity}}
                            </td>
                            <td>
                                {{$variant->price}}
                            </td>
                            <td>
                                {{$variant->selling_price}}
                            </td>
                            <td>
                                {{$variant->discount_amount}}
                            </td>
                            <!-- <td>
                                <a href=""><span class="material-symbols-outlined">edit_square</span></a>
                                <a href=""><span class="material-symbols-outlined">delete</span></a>
                            </td> -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection