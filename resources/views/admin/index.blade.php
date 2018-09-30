@extends('layouts.admin')

@section('title', 'Tableau de bord')

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
                <thead>
                    <tr>
                        <th class="text-center" style="width: 100px;">N° de commande</th>
                        <th class="hidden-xs text-center">Date</th>
                        <th>Status</th>
                        <th class="visible-lg">Clients</th>
                        <th class="visible-lg text-center">Produits</th>
                        <th class="hidden-xs text-right">Total</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forEach($orders as $order)
                    <tr>
                        <td class="text-center">
                            <a href="{{ route("admin.order", $order->id) }}"><strong># {{ $order -> id }}</strong></a>
                        </td>
                        <td class="hidden-xs text-center">{{ $order->created_at->format("d-m-Y H:i:s") }}</td>
                        <td>
                            {{ $order->state() }}
                        </td>
                        <td class="visible-lg">
                            {{ $order -> shipping_first_name }} {{ $order -> shipping_last_name }}
                        </td>
                        <td class="text-center visible-lg">
                            {{ $order->lines->count() }}
                        </td>
                        <td class="text-right hidden-xs">
                            <strong>{{ my_format(($order->total_products + $order->total_shipping)) }}€</strong>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                <a href="{{ route("admin.order", $order->id) }}" data-toggle="tooltip" title="View" class="btn btn-default"><i class="fa fa-eye"></i></a>
                                <a href="{{ action('Admin\AdminController@delete_order', $order->id) }}" data-toggle="tooltip" title="Delete" class="btn btn-default delete"><i class="fa fa-times text-danger"></i></a>
                            </div>
                        </td>
                    </tr>
                   @endforeach
                </tbody>
            </table>
            <div>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
    <!-- END All Orders -->

    </div>
    <!-- END Page Content -->
</main>

<script type="text/javascript">
var deleteBtn = document.querySelectorAll('a.delete');

if(deleteBtn.length > 0){
    var total = deleteBtn.length;
    var x;

    for(x=0;x<total;x++){
        deleteBtn[x].addEventListener('click',function(e){
            e.preventDefault();

            if(window.confirm('Etes-vous sur de vouloir supprimer cette commande ?')){
                document.location.href = this.getAttribute('href');
            }
        })
    }        
}
</script>

<!-- END Main Container -->
@endsection