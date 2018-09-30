@extends('layouts.admin')

@section('title', 'Admin - Ajouter un produit a une marque')

@section('content')
<!-- Main Container -->
<main id="main-container">
    <!-- Page Header -->
    <div class="content bg-gray-lighter">
        <div class="row items-push">
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li><a class="link-effect" href="{{ route('admin.index') }}">Admin</a></li>
                    <li><a class="link-effect" href="{{ route('admin.brands.index') }}">Marques</a></li>
                    <li>Edité le produit</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END Page Header -->

    <!-- Page Content -->
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="block">
                    <div class="block-header bg-gray-lighter">
                        <h3 class="block-title">Modifé</h3>
                    </div>
                    <div class="block-content">
                        <form id="appliance-search" class="form-horizontal" action="{{ action('Admin\BrandsController@store') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-xs-12" for="lower">Marques</label>
                                <div class="col-xs-12">
                                    <select class="form-control" name="brand">
                                        @foreach($brands as $key => $brand)
                                            <option value="{{ $brand->id }}">{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="product">Produits</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="product" name="product" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-arrow-right push-5-r"></i> Confirmer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
@endsection
