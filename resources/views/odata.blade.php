



<h1>Stats</h1>
@if(count($orders) > 0)
<div class="row">
@foreach($orders as $o )

<div class="col-lg-3">
    
   
    
 {{ $o->email }}<br>
    
   
</div>
@endforeach
</div>
@else
<em>No orders</em>
@endif