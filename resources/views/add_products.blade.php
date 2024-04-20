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
        <h1 class="text-center text-dark mb-4">Add Product</h1>
        
        <form action="{{route('store_product')}}" method="post">
            @csrf
            <div class="row row-cols-md-4 row-cols-sm-3 row-cols-2 mb-4">
                <div class="col px-3 py-2">
                    <label for="name">Name</label>
                    <input value="{{old('name')}}" type="text" name="name" id="name" class="form-control form-control-sm @error('name') is-invalid @enderror form-field" placeholder="e.g. full slive t-shirt" requid>
                    @error('name') <small class="form-text text-danger">{{$message}}</small> @enderror
                </div>
                <div class="col px-3 py-2">
                    <label for="brand">Brand</label>
                    <select name="brand" id="brand" class="form-control form-control-sm @error('brand') is-invalid @enderror " requid>
                        <option selected disabled>Select Brand</option>
                        @foreach($brands as $brand)
                            <option value="{{$brand->id}}" {{old('brand')==$brand->id?'selected':''}} >{{$brand->name}}</option>
                        @endforeach
                    </select>
                    @error('brand') <small class="form-text text-danger">{{$message}}</small> @enderror
                </div>
                <div class="col px-3 py-2">
                    <label for="catagory">Catagory</label>
                    <select name="catagory" id="catagory" class="form-control form-control-sm @error('catagory') is-invalid @enderror " requid>
                        <option selected disabled>Select Catagory</option>
                        @foreach($catagories as $catagory)
                            <option value="{{$catagory->id}}" {{old('catagory')==$catagory->id?'selected':''}}>{{$catagory->name}}</option>
                        @endforeach
                    </select>
                    @error('catagory') <small class="form-text text-danger">{{$message}}</small> @enderror
                </div>
                <div class="col px-3 py-2">
                    <label for="sub_catagory">Sub-catagory</label>
                    <select name="sub_catagory" id="sub_catagory" class="form-control form-control-sm @error('sub_catagory') is-invalid @enderror " requid>
                        <option selected disabled>Select Sub-catagory</option>
                        @if(old('sub_catagory'))
                            <?php
                                $sub_catagories = \App\Models\Subcatagory::where('catagory',old('catagory'))->get()??[];
                            ?>
                            @foreach($sub_catagories as $sub_catagory)
                                <option value="{{$sub_catagory->id}}" {{old('sub_catagory')==$sub_catagory->id?'selected':''}}>{{$sub_catagory->name}}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('sub_catagory') <small class="form-text text-danger">{{$message}}</small> @enderror
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>Variants</h4>
                <button type="button" id="add_row" class="btn btn-sm btn-success" style="height: 30px;">
                    <div class="d-flex justify-content-center align-items-center">
                        <span class="material-symbols-outlined" style="font-size: 16px;margin-right: 3.5px !important;">add_box</span>
                        Add
                    </div>
                </button>
            </div>

            @error('field_count_must_be_same')
                <div class="mb-4 d-flex justify-content-center" class="alert-box">
                    <div class="alert alert-danger w-100" role="alert">
                        {{$message}}
                    </div>
                </div>
            @enderror

            <div class="table-responsive mb-4">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Selling Price</th>
                            <th>Discount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="form_tbody">
                        <tr  id="row_1">
                            <td>
                                <select name="color[]" id="" class="form-control form-control-sm color" requid>
                                    <option selected disabled>Select Color</option>
                                    @foreach($colors as $color)
                                        <option value="{{$color->id}}">{{$color->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="size[]" id="" class="form-control form-control-sm size" requid>
                                    <option selected disabled>Select Size</option>
                                    @foreach($sizes as $size)
                                        <option value="{{$size->id}}">{{$size->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" name="quantity[]" id="" class="form-control form-control-sm quantity integer-only positive-num-only" placeholder="e.g. 10" requid>
                            </td>
                            <td>
                                <input type="number" name="price[]" step="0.01" id="" class="form-control form-control-sm price positive-num-only" placeholder="e.g. 10.00" requid>
                            </td>
                            <td>
                                <input type="number" name="selling_price[]" step="0.01" id="" class="form-control form-control-sm selling_price positive-num-only" placeholder="e.g. 10.00" requid>
                            </td>
                            <td>
                                <input type="number" name="discount_amount[]" step="0.01" id="" class="form-control form-control-sm discount_amount positive-num-only" placeholder="e.g. 10.00" requid>
                            </td>
                            <td>
                                <!-- <button type="button" class="remove-row btn text-danger" data-row-id="row_1"><span class="material-symbols-outlined">disabled_by_default</span></button> -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-sm btn-success px-4">Save</button>
        </form>
    </section>
@endsection

@push('script stack')
<script>
    $(document).ready(()=>{
        $('#add_row').click(()=>{
            let rand = Math.ceil(Math.random()*10000);
            let html = `
                <tr  id="row_${rand}">
                    <td>
                        <select name="color[]" id="" class="form-control form-control-sm color" requid>
                            <option selected disabled>Select Color</option>
                            @foreach($colors as $color)
                                <option value="{{$color->id}}">{{$color->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="size[]" id="" class="form-control form-control-sm size" requid>
                            <option selected disabled>Select Size</option>
                            @foreach($sizes as $size)
                                <option value="{{$size->id}}">{{$size->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="quantity[]" id="" class="form-control form-control-sm quantity integer-only positive-num-only" placeholder="e.g. 10" requid>
                    </td>
                    <td>
                        <input type="number" name="price[]" step="0.01" id="" class="form-control form-control-sm price positive-num-only" placeholder="e.g. 10.00" requid>
                    </td>
                    <td>
                        <input type="number" name="selling_price[]" step="0.01" id="" class="form-control form-control-sm selling_price positive-num-only" placeholder="e.g. 10.00" requid>
                    </td>
                    <td>
                        <input type="number" name="discount_amount[]" step="0.01" id="" class="form-control form-control-sm discount_amount positive-num-only" placeholder="e.g. 10.00" requid>
                    </td>
                    <td>
                        <button type="button" class="remove-row btn text-danger" data-row-id="row_${rand}"><span class="material-symbols-outlined">disabled_by_default</span></button>
                    </td>
                </tr>
            `;

            $('#form_tbody').append(html);
            $('.remove-row').click((event)=>{
                let row_id = $(event.currentTarget).data('row-id');
                $(`#${row_id}`).remove();
            });
        });

        setTimeout(() => {
            $('.alert-box').hide(200);
        }, 30);

        $('#catagory').change(()=>{
            $.get({
                url: "{{ url('/get-sub-catagory') }}/" + $('#catagory').val(),
                success: function(res) {
                    let html = '<option selected disabled>Select Sub-catagory</option>';

                    // Loop through the response array and build HTML for sub-categories
                    res.forEach(function(subCategory) {
                        html += '<option value="' + subCategory.id + '">' + subCategory.name + '</option>';
                    });

                    // Assuming you want to update a <select> element with id="subCategorySelect"
                    $('#sub_catagory').html(html);
                },
                error: function(err) {
                    console.error('Error fetching sub-categories:', err);
                    // Handle error if needed
                }
            });

        });

        $('.positive-num-only').change((event)=>{
            let val = $(event.currentTarget).val();
            if(val<0){
                $(event.currentTarget).val('');
            }
        });
        $('.integer-only').change((event)=>{
            let val = $(event.currentTarget).val();
            $(event.currentTarget).val(Math.ceil(val));
        });
    });
</script>
@endpush