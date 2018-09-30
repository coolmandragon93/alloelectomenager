@extends('layouts.admin')

@section('title', 'Admin - Modifiée les marques')

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
                    <li>Modifié la marque</li>
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
                        <h3 class="block-title">Modifée</h3>
                    </div>
                    <div class="block-content">
                        <form id="appliance-search" class="form-horizontal" action="{{ action('Admin\BrandsController@editBrandSave') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="brand_id" value="{{ isset($_GET['brand-id']) ? $_GET['brand-id'] : '' }}" />
                            <div class="form-group">
                                <label class="col-xs-12" for="product">Nom</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="brand_name" name="brand_name" value="{{ $brand_detail->name }}">
                                </div>

                                <?php
                                    $descriptions = json_decode($brand_detail->description);
                                    if ($descriptions == null)
                                        $descriptions = array();
                                ?>
                                <label class="col-xs-12" for="product">Texte pour l'etiquette</label>
                                <div class="col-xs-12 descriptions">
                                    <div class="description row">
                                        <div class="col-xs-12">
                                            <textarea class="form-control" rows="4" name="description[]" > {{ $brand_detail->description }} </textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12">
                                </div>

                                <label class="col-xs-12" for="product">Logo</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="file" id="brand_logo" name="brand_logo" value="">
                                </div>
                                <div class="col-xs-12">
                                    <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-arrow-right push-5-r"></i> Confirmer</button>
                                </div>
                            </div>
                        </form>
                        <div style="display: none;">
                            <div class="description_template">
                                <div class="description row">
                                    <div class="col-xs-10">
                                        <textarea class="form-control" rows="4" name="description[]" > </textarea>
                                    </div>
                                    <button class="col-xs-2 remove_description_btn"> Supprimer </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
@endsection
@section("scripts")
    @parent
    <script src="{{ asset("assets/back/js/brand.js") }}"></script>
@endsection

