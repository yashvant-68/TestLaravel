@extends('layout')

@section('content')
<section class="container">
        <h1 class="text-center text-dark mb-4">Product List</h1>
        <div class="d-flex justify-content-end mb-4">
            <a href="{{route('add_product')}}" class="btn btn-sm btn-success">
                <div class="d-flex justify-content-center align-items-center">
                    <span class="material-symbols-outlined" style="font-size: 16px;margin-right: 3.5px !important;">add_box</span>
                    Add
                </div>
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Sub-catagory</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->brand_name}}</td>
                            <td>{{$product->catagory_name}}</td>
                            <td>{{$product->subcatagory_name}}</td>
                            <td>
                                <a href="{{route('edit_product',$product->id)}}"><span class="material-symbols-outlined">edit_square</span></a>
                                <a href="{{route('get_product',$product->id)}}"><span class="material-symbols-outlined">visibility</span></a>
                                <a href="{{route('delete_product',$product->id)}}"><span class="material-symbols-outlined">delete</span></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection