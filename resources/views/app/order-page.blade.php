@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Products</div>
                    <div class="card-body">
                        <form action="{{route('orders.store')}}" method="post">
                            @csrf
                            <table class="table table-hover" id="products-table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Sum, $</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $k => $product)
                                    @if(!$product->customerProductPrices()->where('user_id', auth()->user()->id)->exists() || $product->customerProductPrices()->where('user_id', auth()->user()->id)->first()->active)
                                    <tr>
                                        <th scope="row">{{$k + 1}}</th>
                                        <td>{{$product->name}}</td>
                                        <td class="product-price">{{$product->customerProductPrices()->where('user_id', auth()->user()->id)->exists() ? $product->customerProductPrices()->where('user_id', auth()->user()->id)->first()->price : $product->default_price}}</td>
                                        <td>
                                            <input class="form-control product-quantity" type="number"
                                                   placeholder="Quantity of {{$product->name}}" oninput="getTotalRow()" value="1" name="quantity-{{$product->id}}">
                                        </td>
                                        <td class="row-total">
                                            {{$product->customerProductPrices()->where('user_id', auth()->user()->id)->exists() ? $product->customerProductPrices()->where('user_id', auth()->user()->id)->first()->price : $product->default_price}}
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                                <tr>
                                    <th></th>
                                    <td></td>
                                    <td></td>
                                    <td>Total: </td>
                                    <td id="table-total"></td>
                                </tr>
                                </tbody>
                            </table>

                            <div class="form-group row mb-0 ml-1" style="float: right !important;">
                                <button type="submit" class="btn btn-primary">
                                    Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function getTotal() {
            var cls = document.getElementById("products-table").getElementsByTagName("td");
            var sum = 0;
            for (var i = 0; i < cls.length; i++) {
                if (cls[i].className == "row-total") {
                    sum += isNaN(cls[i].innerHTML) ? 0 : parseInt(cls[i].innerHTML);
                }
            }
            document.getElementById("table-total").innerHTML = sum + '$';
        }

        function getTotalRow() {
            var cls = document.getElementById("products-table").getElementsByTagName("tr");
            var sum = 0;
            for (var i = 1; i < cls.length - 1; i++) {
                sum = 0;
                let price = cls[i].getElementsByClassName('product-price')[0].innerHTML;
                let quantity = cls[i].getElementsByClassName('product-quantity')[0].value;
                let total = cls[i].getElementsByClassName('row-total')[0];
                sum += (isNaN(price) ? 0 : parseInt(price)) * (isNaN(quantity) || quantity == null || !quantity ? 0 : parseInt(quantity));
                total.innerHTML = sum;
                console.log(sum);
            }
            getTotal();
        }

        document.addEventListener("DOMContentLoaded", function(event) {
            getTotal();
        });

    </script>
@endsection
