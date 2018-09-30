@extends('layouts.odata')

@section('title', 'Orders')

@section('content')

    <?php

    Date::setLocale('fr');

    ?>

    <!-- Main Container -->
    <main id="main-container" style="background: #fff;">
     

        @include("includes.flash")

        <!-- Page Content -->
        <div class="content content-boxed">

            <!-- All Orders -->
            <div class="block">
                
                <div class="block-content">
                    <table class="table table-borderless table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th style="width: 100px;">#</th>
                             <th>Status</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Address</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                        @if ($order->state() == 'En cours')
                        <tr>
                            <td class="text-center">
                                {{ $order -> id }}
                            </td>
                            <td>
                                <span class="label label-{{ get_color_status($order->state()) }}">{{ $order->state() }}</span>
                            </td>
                            <td class="hidden-xs text-center">
                                
                                {{ date('d/m/Y', strtotime($order->created_at)) }}<br>
                                {{ date('H:i', strtotime($order->created_at)) }}
                            </td>
                            
                            <td>
                                

                                <strong>{{ ucfirst($order->shipping_first_name) }} {{ ucfirst($order->shipping_last_name) }}</strong><br>
                                <small><span class="glyphicon glyphicon-envelope"></span></small> <a href="mailto:{{ $order->email }}">{{ $order->email }}</a><br>
                                <small><span class="glyphicon glyphicon-phone"></span></small> {{ $order->billing_phone }}<br>
                            </td>
                            <td>

                            {{ $order->shipping_address }}<br>
                            {{ $order->shipping_zip }} {{ $order->shipping_city }}<br>
                            {{ $order->shipping_country }}

                            </td>
                            
                            <td>
                                <strong>{{ my_format(($order->total_products + $order->total_shipping)) }}€</strong>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-xs">
                                    
                                    <a class="btn btn-primary" style="font-size: 14px; padding: 8px; border-radius: 3px;" href="{{ route("admin.show_order", $order->id) }}">Process</a>
                                    <form id="delete-order-{{ $order->id }}" 
                                    action="{{ route("admin.orders.destroy", $order->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        <input name="_method" value="DELETE" type="hidden">
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endif
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

 

    <!-- END Main Container -->
@endsection