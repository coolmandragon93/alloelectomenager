@extends('layouts.admin')

@section('title', 'Suggestliste - ASWO API')

@section('styles')
@parent
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

    #suggestdiv {
    overflow: auto;
    width: 100%;
    -webkit-box-shadow: 11px 8px 43px #000000;
    -moz-box-shadow: 11px 8px 43px #000000;
    box-shadow: 11px 8px 43px #000000;
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    background-color: #00AE2C;
    margin-top: 3px;
    opacity: 1;
    position: relative;
    color: #0D0A00;
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
                   Does not work - Suggestliste <small></small>
                </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li><a class="link-effect" href="{{ route('admin.index') }}">Admin</a></li>
                    <li><a class="link-effect" href="{{ route('admin.aswo.index') }}">Aswo</a></li>
                    <li>Suggestliste</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- END Page Header -->

    <!-- Page Content -->
    <div class="content">
        <div class="block">
            <div class="block-header bg-gray-lighter">
                <h3 class="block-title">Description</h3>
            </div>
            <div class="block-content">
                <p>
                    not supported in all EED accounts, please contact your ASWO partner. <br />
                    This command eables an AJAX suggestlist. You sent the keyword (maybe while the user still types) and get up to 20 hits from the tables article, appliances, manufacturer, appliance types, article family. <br />

                    You can then bring the customer to enter a good keyword. E.g. if he has entered "washing machine" you can show him a hint to enter the appliance number or name instead directly. <br />
                    The output here is a bit encoded, to show the results correctly you must place the HTML-style-tag from output field css. <br>
                    <strong>Command:</strong> <code>suggestliste</code>
                </p>
                <div class="table-responsive">
                    <table class="table table-hover table-vcenter">
                        <thead>
                            <tr>
                                <th style="width: 120px;">Input Parameter</th>
                                <th style="width: 120px;">Translation</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>suchbg</td>
                                <td></td>
                                <td>
                                    Keyword for search
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="block">
                    <div class="block-header bg-gray-lighter">
                        <h3 class="block-title">Test</h3>
                    </div>
                    <div class="block-content">
                        <form id="suggestliste" class="form-horizontal" action="{{ route('admin.aswo.suggestlist') }}" method="post" onsubmit="return check_form2()">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-xs-12" for="suchbg">suchbg</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="suchbg" name="suchbg" placeholder="suchbg" value="---">
                                    <input class="inputajax" name="suchbg" id="suchbg" autocomplete="off" onkeyup="timer_start(), pageScroll()" onkeydown="" "timer_reset()"="" type="text" size="20" placeholder="Modell- oder Bestellnummer eingeben">
                                    <div id="suggestdiv" style="z-index:99"></div>
                                    <div class="help-block">Add example of value here, or maybe even directly as an input</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                   <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-arrow-right push-5-r"></i> Submit</button> 
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="block">
                    <div class="block-header bg-gray-lighter">
                        <h3 class="block-title">Examples & Remarks</h3>
                    </div>
                    <div class="block-content">
                        <p>
                           
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="block block-themed" id="result" style="display: none;">
            <ul class="nav nav-tabs" data-toggle="tabs">
                <li class="active">
                    <a href="#results">Response</a>
                </li>
                <li class="">
                    <a href="#raw-results">Raw Results</a>
                </li>
            </ul>
            <div class="block-content tab-content">
                <div class="tab-pane active" id="results">
                    <strong class="text-danger">Error: Please check raw results</strong>
                    <div class="table-responsive" >
                        <table class="table table-striped table-hover table-vcenter">
                            <thead>
                                <tr>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="">
                                        geraetetreffer<br>
                                        <small class="text-muted">geraetetreffer</small>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-vcenter">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="unique ASWO ID of an appliance, alphanumeric, must be used as reference to fetch details for this appliance">
                                                        appliance id<br>
                                                        <small class="text-muted">geraeteid</small>
                                                    </th>
                                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="geraetebezeichnung">
                                                        geraetebezeichnung<br>
                                                        <small class="text-muted">geraetebezeichnung</small>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>sdf</td>
                                                    <td>sdfs</td>
                                                </tr>
                                                <tr>
                                                    <td>sdf</td>
                                                    <td>sdfs</td>
                                                </tr>
                                                <tr>
                                                    <td>sdf</td>
                                                    <td>sdfs</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> 
                                </tr> </td>
                            </tbody>
                            <thead>
                                <tr>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="">
                                        geraetetreffer<br>
                                        <small class="text-muted">geraetetreffer</small>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-vcenter">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="unique ASWO articile ID, alphanumeric">
                                                        article id<br>
                                                        <small class="text-muted">artikelnummer</small>
                                                    </th>
                                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="article description">
                                                        article description<br>
                                                        <small class="text-muted">artikelbezeichnung</small>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                    <td>sdf</td>
                                                    <td>sdfs</td>
                                                </tr>
                                                <tr>
                                                    <td>sdf</td>
                                                    <td>sdfs</td>
                                                </tr>
                                                <tr>
                                                    <td>sdf</td>
                                                    <td>sdfs</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </tr> </td>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
                <div class="tab-pane" id="raw-results">
                    <pre class="pre-sh"><code class="result-data json"></code></pre>
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.8.0/highlight.min.js"></script>
    <script type="text/javascript">
    $(function(){
        var form = $('#suggestliste');

        form.submit(function(){
            var formData = form.serialize();
            $.post(form.attr('action'), formData, function(data) {
                var cssClass = "";
                if(data.fehlernummer == 0) {
                    $('#results .text-danger').hide();
                    cssClass = "success";
                } else {
                    cssClass = "danger";
                    $('#results .text-danger').show();
                }
                // Set result div header class
                $("#result .block-header").addClass("bg-"+cssClass);
                // show result box
                $("#result").show();
                // Display raw data
                $(".result-data").text(JSON.stringify(data, null, 2));
                // Highlight result
                $('pre code').each(function(i, block) {
                    hljs.highlightBlock(block);
                });

                // Display usable results
                // foreach treffer
                console.log(JSON.stringify(data, null, 2));
                $.each(data.treffer, function(index, value){
                    $('#results table tbody').append('<tr><td>'+value.geraeteid+'</td><td>'+value.geraetennummer+'</td><td>'+value.geraeteidentnumber+'</td><td>'+value.geraetename+'</td><td>'+value.geraetehersteller+'</td><td>'+value.geraeteart+'</td><td>'+value.geraeteartenid+'</td></tr>')
                });
            });
            return false;
        });
    });
    </script>
    <script type="text/javascript">
//
$(document).ready(function() { $('#suchbg').focus(); });


var lim ="";
function pageScroll() {
    

if (lim !="hu") 
{   
// alert(lim);

        window.scrollBy(0,140); // horizontal and vertical scroll 
    

        lim="hu";
}

}
</script>
@endsection


