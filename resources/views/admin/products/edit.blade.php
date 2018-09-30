@extends('layouts.admin')

@section('title', 'Edit product ' . $product->name)

@section('styles')
@parent
<!-- Icons -->
<!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
<link rel="shortcut icon" href="{{ asset('assets/back/img/favicons/favicon.png') }}">

<link rel="icon" type="image/png" href="{{ asset('assets/back/img/favicons/favicon-16x16.png') }}" sizes="16x16">
<link rel="icon" type="image/png" href="{{ asset('assets/back/img/favicons/favicon-32x32.png') }}" sizes="32x32">
<link rel="icon" type="image/png" href="{{ asset('assets/back/img/favicons/favicon-96x96.png') }}" sizes="96x96">
<link rel="icon" type="image/png" href="{{ asset('assets/back/img/favicons/favicon-160x160.png') }}" sizes="160x160">
<link rel="icon" type="image/png" href="{{ asset('assets/back/img/favicons/favicon-192x192.png') }}" sizes="192x192">

<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/back/img/favicons/apple-touch-icon-57x57.png') }}">
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/back/img/favicons/apple-touch-icon-60x60.png') }}">
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/back/img/favicons/apple-touch-icon-72x72.png') }}">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/back/img/favicons/apple-touch-icon-76x76.png') }}">
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/back/img/favicons/apple-touch-icon-114x114.png') }}">
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/back/img/favicons/apple-touch-icon-120x120.png') }}">
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/back/img/favicons/apple-touch-icon-144x144.png') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/back/img/favicons/apple-touch-icon-152x152.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/back/img/favicons/apple-touch-icon-180x180.png') }}">
<!-- END Icons -->

<!-- Stylesheets -->
<!-- Web fonts -->
<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">

<!-- Bootstrap and OneUI CSS framework -->
<link rel="stylesheet" href="{{ asset("assets/back/css/bootstrap.min.css") }}">
<link rel="stylesheet" id="css-main" href="{{ asset("assets/back/js/plugins/highlightjs/github-gist.min.css") }}">
<link rel="stylesheet" id="css-main" href="{{ asset("assets/back/js/plugins/select2/select2.min.css") }}">
<link rel="stylesheet" id="css-main" href="{{ asset("assets/back/js/plugins/select2/select2-bootstrap.min.css") }}">
<link rel="stylesheet" id="css-main" href="{{ asset("assets/back/css/oneui.css") }}">
<link rel="stylesheet" id="css-main" href="{{ asset("assets/back/css/custom.css") }}">
<!-- END Stylesheets -->

<style type="text/css">
    #result > .nav-tabs {
        background-color: #c9c9c9;
    }

    #results th {
        font-weight: normal;
        padding: 5px 10px;
        text-transform: uppercase;
        text-transform: none;
    }
</style>
@endsection

@section('content')
<!-- Main Container -->
<main id="main-container">
    <!-- Page Header -->
    <div class="content bg-gray-lighter">
        <div class="row items-push">
            <div class="col-sm-7">
                <h1 class="page-heading">
                    Edit Product <small>{{ $product->name }}</small>
                </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li><a class="link-effect" href="{{ route('admin.index') }}">Admin</a></li>
                    <li><a class="link-effect" href="{{ route('admin.products.index') }}">Products</a></li>
                    <li>Edit</li>
                    <li>{{ $product->name }}</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END Page Header -->

    @include("includes.flash")

    <!-- Page Content -->
    <div class="content">

        <div class="row">
            <div class="col-md-6">
                <div class="block">
                    <div class="block-header bg-gray-lighter">
                        <h3 class="block-title">Test</h3>
                    </div>
                    <div class="block-content">
                        <form class="form-horizontal" action="{{ route('admin.products.update', $product->id) }}" method="post">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="purchase_price" id="purchase_price" value="{{ $product->purchase_price }}">
                            {{ csrf_field() }}
                            <div class="form-group<?php if($errors->has('aswo_id')) {echo " has-error";} ?>">
                                <label class="col-xs-12" for="aswo_id">Aswo ID</label>
                                <div class="col-xs-12">
                                    <div class="form-control-static">{{ $product->aswo_id}} </div>
                                </div>
                                @if ($errors->has('aswo_id'))
                                    <div class="help-block text-right animated fadeInDown">
                                        {{ $errors->first('aswo_id') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group<?php if($errors->has('brand_name')) {echo " has-error";} ?>">
                                <label class="col-xs-12" for="brand_name">Brand</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="brand_name" name="brand_name" value="{{ old('brand_name', $product->brand_name) }}">
                                </div>
                                @if ($errors->has('brand_name'))
                                    <div class="help-block text-right animated fadeInDown">
                                        {{ $errors->first('brand_name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group<?php if($errors->has('name')) {echo " has-error";} ?>">
                                <label class="col-xs-12" for="name">Name</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $product->name) }}">
                                </div>
                                @if ($errors->has('name'))
                                    <div class="help-block text-right animated fadeInDown">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group<?php if($errors->has('description')) {echo " has-error";} ?>">
                                <label class="col-xs-12" for="description">Description</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="description" name="description" value="{{ old('description', $product->description) }}">
                                </div>
                                @if ($errors->has('description'))
                                    <div class="help-block text-right animated fadeInDown">
                                        {{ $errors->first('description') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group<?php if($errors->has('purchase_price')) {echo " has-error";} ?>">
                                <label class="col-xs-12" for="purchase_price">Purchase Price</label>
                                <div class="col-xs-12">
                                    <div class="form-control-static">{{ get_raw_price($product->purchase_price) }} €</div>
                                </div>
                                @if ($errors->has('purchase_price'))
                                    <div class="help-block text-right animated fadeInDown">
                                        {{ $errors->first('purchase_price') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group<?php if($errors->has('price')) {echo " has-error";} ?>">
                                <label class="col-xs-12" for="price">Price</label>
                                <div class="col-xs-12">
                                    <div class="input-group">
                                        <input class="form-control" type="text" id="price" name="price" placeholder="0,0" value="{{ old('price', $product->price) }}">
                                        <span class="input-group-addon"><i class="fa fa-eur"></i></span>
                                    </div>
                                </div>
                                @if ($errors->has('price'))
                                    <div class="help-block text-right animated fadeInDown">
                                        {{ $errors->first('price') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group<?php if($errors->has('google_product_category')) {echo " has-error";} ?>">
                                <label class="col-xs-12" for="google_product_category">Google Product Category</label>
                                <div class="col-xs-12">
                                    <select class="js-select2 form-control" id="google_product_category" name="google_product_category" style="width: 100%;" data-placeholder="Choose one..">
                                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                        @foreach(config('shopping.google_product_categories') as $key => $category)
                                        <option value="{{ $key }}">{{ $category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has('google_product_category'))
                                    <div class="help-block text-right animated fadeInDown">
                                        {{ $errors->first('google_product_category') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group<?php if($errors->has('gtin')) {echo " has-error";} ?>">
                                <label class="col-xs-12" for="gtin">GTIN</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="gtin" name="gtin" value="{{ old('gtin', $product->gtin) }}">
                                </div>
                                @if ($errors->has('gtin'))
                                    <div class="help-block text-right animated fadeInDown">
                                        {{ $errors->first('gtin') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group<?php if($errors->has('mpn')) {echo " has-error";} ?>">
                                <label class="col-xs-12" for="mpn">MPN</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="mpn" name="mpn" value="{{ old('mpn', $product->mpn) }}">
                                </div>
                                @if ($errors->has('mpn'))
                                    <div class="help-block text-right animated fadeInDown">
                                        {{ $errors->first('mpn') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group<?php if($errors->has('google_shopping')) {echo " has-error";} ?>">
                                <label class="col-xs-12" for="google_shopping">Google Shopping</label>
                                <div class="col-xs-12 checkbox">
                                    <label for="google_shopping">
                                        <input type="hidden" name="google_shopping" value="0">
                                        <input type="checkbox" id="google_shopping" name="google_shopping" value="1" <?php if(old('google_shopping', $product->google_shopping)) echo 'checked="checked"' ?>> Show
                                    </label>
                                </div>
                                @if ($errors->has('google_shopping'))
                                    <div class="help-block text-right animated fadeInDown">
                                        {{ $errors->first('google_shopping') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-arrow-right push-5-r"></i> Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="block">
                    <div class="block-header bg-gray-lighter">
                        <h3 class="block-title">Status</h3>
                    </div>
                    <div class="block-content">
                        <p>
                            <span id="price-up-to-date" class="text-success"><i class="fa fa-check"></i> Price up to date</span><br>
                            <a id="update-price" class="hidden btn btn-default btn-xs" href="{{ route('admin.products.update_purchase_price', $product->id) }}">Update purchase price</a>
                        </p>
                        <p>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-aswo-info" type="button">View latest product data from aswo</button>
                            <button class="hidden btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-aswo-info" type="button">Reset product from ASWO</button>
                        </p>
                    </div>
                </div>
                <div class="block">
                    <div class="block-header bg-gray-lighter">
                        <h3 class="block-title">Image</h3>
                    </div>
                    <div class="block-content">
                        <p class="text-center">
                            <img src="{{ $product->img_url() }}" alt="{{ $product->name }}" style="max-height: 300px; max-width: 300px;">
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->

<!-- Normal Modal -->
<div class="modal" id="modal-aswo-info" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">ASWO Product Information</h3>
                </div>
                <div class="block-content">
                    <pre></pre>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-sm btn-primary" type="button" data-dismiss="modal"><i class="fa fa-check"></i> Ok</button>
            </div>
        </div>
    </div>
</div>
<!-- END Normal Modal -->
@endsection

@section("scripts")
    @parent

    <script src="{{ asset("assets/back/js/plugins/select2/select2.full.min.js") }}"></script>
    <script type="text/javascript">
    $(function(){
        App.initHelpers('select2');

        var product_data;
        var purchase_price = $('#purchase_price').val();

        $.getJSON( "{{ route('admin.products.info', $product->aswo_id) }}", function( data, status, jqXHR ) {
            product_data = data;
            $('#modal-aswo-info .block-content pre').text(JSON.stringify(data, null, 2));

            if(purchase_price !== data.ekpreis) {
                $("#price-up-to-date").removeClass('text-success');
                $("#price-up-to-date").addClass('text-danger');
                $("#update-price").removeClass('hidden');
                $("#price-up-to-date").html('<i class="fa fa-check"></i> Purchase price has changed. Please advise.<br> ASWO: ' + data.ekpreis + '€ <br>ALLO: ' + purchase_price + '€');
            }

        });

    });
    </script>
@endsection