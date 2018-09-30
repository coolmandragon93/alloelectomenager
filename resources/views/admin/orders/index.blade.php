@extends('layouts.admin')

@section('title', 'Orders')

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
                        Commandes <small></small>
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li><a class="link-effect" href="{{ route('admin.index') }}">Admin</a></li>
                        <li><a class="link-effect" href="{{ route('admin.orders.index') }}">Commandes</a></li>
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
                        @foreach($orders as $order)
                        <tr>
                            <td class="text-center">
                                <a href="{{ route("admin.orders.show", $order->id) }}"><strong># {{ $order -> id }}</strong></a>
                            </td>
                            <td class="hidden-xs text-center">
                                <?php $tmp_date = new Date(strtotime($order->created_at->format('Y-m-d H:i:s'))); ?>
                                {{ ucwords($tmp_date->format('l j F, H:i:s')) }}
                            </td>
                            <td>
                                <span class="label label-{{ get_color_status($order->state()) }}">{{ $order->state() }}</span>
                            </td>
                            <td class="visible-lg">
                                {{ ucfirst($order->shipping_first_name) }} {{ ucfirst($order->shipping_last_name) }}
                            </td>
                            <td class="text-center visible-lg">
                                {{ $order->lines->count() }}
                            </td>
                            <td class="text-right hidden-xs">
                                <strong> @if (($order -> billing_country) === "France")
                                    {{ my_format(( $order -> total_products + $order -> total_shipping )) }}€
                                @else

                                    {{ my_format(( $order -> total_products + $order -> total_shipping + 2 )) }}€

                                @endif</strong>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-xs">
                                    <a href="{{ route("admin.orders.show", $order->id) }}" data-toggle="tooltip" title="View" class="btn btn-default"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route("admin.orders.destroy", $order->id) }}" data-toggle="tooltip" title="Delete" class="btn btn-default" onclick="event.preventDefault(); deleteOrder({{ $order->id }})"><i class="fa fa-times text-danger"></i></a>
                                    <a href="{{ route("admin.orders.editOrder", $order->id) }}" title="Modify" class="btn btn-default"><i class="fa fa-pencil-square-o"></i></a>
                                    <form id="delete-order-{{ $order->id }}" 
                                    action="{{ route("admin.orders.destroy", $order->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        <input name="_method" value="DELETE" type="hidden">
                                    </form>
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
        function deleteOrder(id) {
            if(window.confirm('Etes-vous sur de vouloir supprimer cette commande ?')){
                event.preventDefault();
                document.getElementById('delete-order-'+id).submit();
            }
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
    $('#example').DataTable( {
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    } );
} );
    </script>

 

    <!-- END Main Container -->
@endsection