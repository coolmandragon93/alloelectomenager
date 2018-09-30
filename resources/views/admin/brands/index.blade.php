@extends('layouts.admin')

@section('title', 'Marques')

@section('content')
    <style type="text/css">
        .display-none {
            display: none;
        }
    </style>
    <!-- Main Container -->
    <main id="main-container">
        <!-- Page Header -->
        <div class="content bg-gray-lighter">
            <div class="row items-push">
                <div class="col-sm-7">
                    <h1 class="page-heading">
                        Admin <small></small>
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li><a class="link-effect" href="{{ route('admin.index') }}">Admin</a></li>
                        <li><a class="link-effect" href="{{ route('admin.index') }}">Accueil</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- END Page Header -->

        <!-- Page Content -->
        <div class="content content-boxed">
            <h2 class="content-heading">Accueil</h2>

            <!-- All Orders -->
            <div class="block">
                <div class="block-header bg-gray-lighter">

                    <h3 class="block-title">Commandes</h3>
                </div>
                <div class="block-content">
                    <table class="table table-borderless table-striped table-vcenter">
                        <h3 class="box-title">Regle des prix</h3>
                    </table>
                </div>
                <div class="box-body">
                    <select class="change-brand">
                        @foreach($data as $item)
                            <option value="{{ $item['brand']->id }}">{{$item['brand']->name}}</option>
                        @endforeach
                    </select>
                    <?php
                    $first_brand_id = isset($data[0]) ? $data[0]['brand']->id : null;
                    ?>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#add_brand">Ajouter une marque</button>
                    <a id="edit_brand_btn" href="/admin/brands/edit-brand/?brand-id={{$first_brand_id}}">
                        <button type="button" class="btn btn-info btn-sm" > Modifier </button>
                    </a>
                    <a id="delete_brand_btn" href="{{ action('Admin\BrandsController@deleteBrand', ['brand-id' => $first_brand_id]) }}">
                        <button type="button" class="btn btn-danger btn-sm" > Supprimer une marque </button>
                    </a>

                    <button type="button" class="btn btn-info btn-sm" id="check_valid_product_btn">Verifier si les produits sont valide</button>

                    <table class="table table-bordered" id="myTable">
                        <tr>
                            <th>Marques</th>
                            <th>Produits</th>
                            <th>Action</th>
                        </tr>
                        @foreach($data as $item)
                            @foreach($item['products'] as $product)
                                <tr data-product-code="{{$product->name}}" class="product-{{ $item['brand']->id }}-{{ $product->id }} list-product-{{ $item['brand']->id }} {{ $product->brand_id != $first_brand_id ? 'display-none' : '' }}">
                                <td>{{ $item['brand']->name }}</td>
                                <td>
                                    {{ $product->aswo_id }}
                                    <span class="error" style="color: red;">

                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-xs">
                                        <a href="{{ action('Admin\BrandsController@editProduct', [$item['brand']->id, $product->id]) }}" data-toggle="tooltip" title="Edit" class="btn btn-default"><i class="fa fa-edit"></i></a>
                                        <a href="#" data-brand="{{ $item['brand']->id }}" data-product="{{ $product->id }}" class="btn btn-default delete delete-brand"><i class="fa fa-times text-danger"></i></a>
                                    </div>
                                </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="add_brand" role="dialog">
            <form action="{{ action('Admin\BrandsController@createBrand') }}" method="post" enctype="multipart/form-data" >
                {{ csrf_field() }}
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Ajouter marque</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-xs-12" for="product">Nom</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="brand_name" name="brand_name" value="">
                                </div>

                                <label class="col-xs-12" for="product">Texte pour l'image</label>
                                <div class="col-xs-11 descriptions">

                                </div>
                                <div class="col-xs-12">
                                    <button class="add_description_btn"> Ajouter </button>
                                </div>

                                <label class="col-xs-12" for="product">Logo</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="file" id="brand_logo" name="brand_logo" value="">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-default" >Confirmer</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </form>
            <div style="display: none;">
                <div class="description_template">
                    <div class="description row">
                        <div class="col-xs-10">
                            <textarea class="form-control" rows="4" name="description[]" value=""> </textarea>
                        </div>
                        <button class="col-xs-2 remove_description_btn"> Supprimer </button>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection
@section("scripts")
    @parent
    <script src="{{ asset("assets/back/js/brand.js") }}"></script>
@endsection
