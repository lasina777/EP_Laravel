@extends('welcome')

@section('content')
    <dic class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col-8">
                @include('breadcrumb', $breadcrumbs)
                <div class="card mt-2">
                    <div class="card-header">
                        {{$product->name}}
                    </div>
                    <div class="card-body text-center">
                        <img src="{{'/public/storage/' . $product->photo}}" class="card-img-top w-50" alt="{{$product->name}}">
                        <p class="card-text">{{$product->descriprion}}</p>
                        <p class="card-text">Стоимость товара: {{$product->price}}</p>
                        <p class="card-text">Страна производства: {{$product->made}}</p>
                        <a href="{{route('admin.product.edit', ['product' => $product->id])}}" class="btn btn-primary">Редактировать</a>
                        <a href="#" class="btn btn-danger">Удалить</a>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </dic>
@endsection
