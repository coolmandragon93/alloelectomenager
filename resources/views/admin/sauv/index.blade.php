@extends('layouts.admin')

@section('title', 'Products')

@section('content')

    <?php

    Date::setLocale('fr');

    ?>

    <!-- Main Container -->
    <main id="main-container">
        <!-- Page Header -->
        <div class="content bg-gray-lighter">
            <div class="row items-push">
                <div class="col-sm-7">
                    <h1 class="page-heading">
                        Products <small></small>
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li><a class="link-effect" href="{{ route('admin.index') }}">Admin</a></li>
                        <li><a class="link-effect" href="{{ route('admin.products.index') }}">Products</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- END Page Header -->

        @include("includes.flash")

        <!-- Page Content -->
        <div class="content content-boxed">

            <!-- All Orders -->
            <div class="block">
                <div class="block-header bg-gray-lighter">
                    <div class="block-options-simple">
                        <a class="btn btn-primary btn-xs" href="{{ route('admin.products.create') }}" type="button" data-toggle="tooltip" ><i class="fa fa-plus"></i> Add a product</a>
                        <a class="btn btn-default btn-xs" href="{{ route('feed.google') }}" type="button" data-toggle="tooltip" >View Google Shopping feed</a>
                        <a class="btn btn-default btn-xs" href="{{ route('admin.products.check_all') }}" type="button" data-toggle="tooltip" >Check all prices</a>
                    </div>
                    <h3 class="block-title">Products</h3>
                </div>
                <div class="block-content">
                    <table class="table table-borderless table-striped table-vcenter">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Brand</th>
                                <th>Purchase Price</th>
                                <th>Price</th>
                                <th>Last Update</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->aswo_id }}</td>
                                <td><a href="https://alloelectromenager.com/admin/sauv/{{$product->id}}">{{ $product->name }}</a></td>
                                <td>{{ $product->brand_name }}</td>
                                <td>{{ $product->purchase_price }} €</td>
                                <td>{{ $product->price }} €</td>
                                <td>{{ $product->updated_at->format("Y-m-d H:i") }}</td>
                                <td>   
                                    <a href="{{ route('admin.products.edit', $product->id) }}" title="Modify">Modify</a> - 
                                    <a href="{{ route("admin.products.destroy", $product->id) }}" title="Delete" class="text-danger" onclick="event.preventDefault(); deleteProduct({{ $product->id }})">Delete</a>
                                    <form id="delete-product-{{ $product->id }}" action="{{ route("admin.products.destroy", $product->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        <input name="_method" value="DELETE" type="hidden">
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
            <!-- END All Orders -->

        </div>
        <!-- END Page Content -->
    </main>

    <script type="text/javascript">
        function deleteProduct(id) {
            if(window.confirm('Etes-vous sur de vouloir supprimer cette commande ?')){
                event.preventDefault();
                document.getElementById('delete-product-'+id).submit();
            }
        }
    </script>

    <!-- END Main Container -->
@endsection