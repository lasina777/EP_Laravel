@extends('welcome')

{{--Секция для вывода всех продуктов--}}
@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-12 p-3">
                <h2>Все товары для покупки</h2>
                <div class="row mb-2">
                    @foreach($products as $product)
                        <div class="col-2 mt-2">
                            <div class="card" style="width: 100%;">
                                <img src="/public/storage/{{$product->photo}}" class="card-img-top" alt="{{$product->name}}">
                                <div class="card-body">
                                    <h5 class="card-title">{{$product->name}}</h5>
                                    <p class="card-text">{{$product->description}}</p>
                                    <p class="card-text">Стоимость: {{$product->price}}</p>
                                    <a href="{{route('product', ['product' => $product->id])}}" class="btn btn-primary">Посмотреть</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{$products->links()}}
            </div>
        </div>
    </div>
@endsection
