@extends('layouts.admin')

@section('title', 'Articles For An Appliance - ASWO API')

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
                    Articles For An Appliance <small></small>
                </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li><a class="link-effect" href="{{ route('admin.index') }}">Admin</a></li>
                    <li><a class="link-effect" href="{{ route('admin.aswo.index') }}">Aswo</a></li>
                    <li>Articles For An Appliance</li>
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
                    Either the user has identified the appliance and the article family you list the articles (finally..) or the top articles for this appliance are shown, independend from article family (to call with vgruppe=top) or alternativly the user entered a keyword to search within this appliance. Output limit is 100 articles. If an article is not orderable but has orderable replacement articles then the replacements are shown additional with a hint (see field list: artikelbezeichnung2, ersetzt). <br>
                    <strong>Command:</strong> <code>geraeteartikel</code>
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
                                <td>geraeteid</td>
                                <td>appliance id</td>
                                <td>
                                    value from field geraeteid of the command geraetesuche representing the selected appliance
                                </td>
                            </tr>
                            <tr>
                                <td>suchbg</td>
                                <td></td>
                                <td>
                                    keyword for searching articles in the selected appliance. (Remove parameter "vgruppe" when using this!)
                                </td>
                            </tr>
                            <tr>
                                <td>attrib</td>
                                <td></td>
                                <td>
                                    attrib=1 returns additionally some technische data for the article, if available, in HTML-Format. The return may be slower than.
                                </td>
                            </tr>
                            <tr>
                                <td>sperrgut</td>
                                <td>bulk goods</td>
                                <td>
                                    sperrgut=1 will return additionally the information if an article is a bulk good by DHL's (Germany) perspective
                                </td>
                            </tr>
                            <tr>
                                <td>vgruppe</td>
                                <td> </td>
                                <td>
                                    article family id choosen by the user or keyword "top" for just top articles
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
                        <form id="articles_for_an_appliance" class="form-horizontal" action="{{ route('admin.aswo.articles_for_an_appliance') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-xs-12" for="geraeteid">geraeteid (appliance id)</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="geraeteid" name="geraeteid" placeholder="appliance id" value="1099212898712">
                                    <div class="help-block">Add example of value here, or maybe even directly as an input</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="suchbg">suchbg (suchbg) <span class="text-muted">Optionnal</span></label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="suchbg" name="suchbg" placeholder="" value="---">
                                    <div class="help-block">Add example of value here, or maybe even directly as an input</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="attrib">attrib () <span class="text-muted">Optionnal</span></label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="attrib" name="attrib" placeholder="attrib" value="1" />
                                    <div class="help-block">Add example of value here, or maybe even directly as an input</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="sperrgut">sperrgut (bulk goods) <span class="text-muted">Optionnal</span></label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="sperrgut" name="sperrgut" placeholder="bulk goods" value="1" />
                                    <div class="help-block">Add example of value here, or maybe even directly as an input</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="vgruppe ">vgruppe (vgruppe) <span class="text-muted">Optionnal</span></label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="vgruppe" name="vgruppe" placeholder="vgruppe" value="" />
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
            <!-- this table missing artikeldaten feild-->
            <div class="block-content tab-content">
                <div class="tab-pane active" id="results">
                    <strong class="text-danger">Error: Please check raw results</strong>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-vcenter">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center" data-toggle="tooltip" data-placement="top" title="article description">
                                        article description<br>
                                        <small class="text-muted">artikelbezeichnung</small>
                                    </th>
                                    <th rowspan="2"  class="text-center" data-toggle="tooltip" data-placement="top" title="article description">
                                        article description<br>
                                        <small class="text-muted">artikelbezeichnung2</small>
                                    </th>
                                    <th rowspan="2"  class="text-center" data-toggle="tooltip" data-placement="top" title="artikelhersteller">
                                        artikelhersteller<br>
                                        <small class="text-muted">artikelhersteller</small>
                                    </th>
                                    <th rowspan="2"  class="text-center" data-toggle="tooltip" data-placement="top" title="unique ASWO articile ID, alphanumeric">
                                        article id<br>
                                        <small class="text-muted">artikelnummer</small>
                                    </th>
                                    <th rowspan="2"  class="text-center" data-toggle="tooltip" data-placement="top" title="decision if this articel can be ordered {'J', 'N'}">
                                        orderable<br>
                                        <small class="text-muted">bestellbar</small>
                                    </th>
                                    <th rowspan="2"  class="text-center" data-toggle="tooltip" data-placement="top" title="decision if the article has a picture {'J', 'N'}">
                                        picture<br>
                                        <small class="text-muted">bild</small>
                                    </th>
                                    <th rowspan="2"  class="text-center" data-toggle="tooltip" data-placement="top" title="  your price at ASWO, without taxes, format 0,00">
                                        purchase price<br>
                                        <small class="text-muted">ekpreis</small>
                                    </th>
                                    <th rowspan="2" class="text-center" data-toggle="tooltip" data-placement="top" title="decision if it at least one orderable replacement article is known {'J', 'N'}, if yes they can be fetches by article search using parameter "vergleich"">
                                        replacement article<br>
                                        <small class="text-muted">ersatzartikel</small>
                                    </th>
                                    <th colspan="2" class="text-center" data-toggle="tooltip" data-placement="top" title="">
                                        ersetzt<br>
                                        <small class="text-muted">ersetzt</small>
                                    </th>
                                    <th rowspan="2"  class="text-center" data-toggle="tooltip" data-placement="top" title="estimated delivery time of the article">
                                        delivery time<br>
                                        <small class="text-muted">lieferzeit</small>
                                    </th>
                                    <th rowspan="2"  class="text-center" data-toggle="tooltip" data-placement="top" title="numeric value, estimated number of days for delivery (with dropshipping)">
                                        number of days for delivery<br>
                                        <small class="text-muted">lieferzeit_in_tagen</small>
                                    </th>
                                    <th rowspan="2"  class="text-center" data-toggle="tooltip" data-placement="top" title="shows the status if an article is returnable / can be canceld J/N">
                                        storno_moeglich<br>
                                        <small class="text-muted">storno_moeglich</small>
                                    </th>
                                    <th rowspan="2"  class="text-center" data-toggle="tooltip" data-placement="top" title="unique ID of an article family, always 10digit numeric but with leading 0">
                                        family id<br>
                                        <small class="text-muted">vgruppenid</small>
                                    </th>
                                    <th rowspan="2"  class="text-center" data-toggle="tooltip" data-placement="top" title="article family name, alphanumeric and special characters">
                                        family name<br>
                                        <small class="text-muted">vgruppenname</small>
                                    </th>
                                </tr>
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
        var form = $('#articles_for_an_appliance');

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
                $.each(data.treffer, function(index, value){
                    $('#results table tbody').append('<tr><td>'+value.artikelbezeichnung+'</td><td>'+value.artikelbezeichnung2+'</td><td>'+value.artikelhersteller+'</td><td>'+value.artikelnummer+'</td><td>'+value.bestellbar+'</td><td>'+value.bild+'</td><td>'+value.ekpreis+'</td><td>'+value.ersatzartikel+'</td><td>'+value.ersetzt.artikelnummer+'</td><td>'+value.ersetzt.artikelbezeichnung+'</td><td>'+value.lieferzeit+'</td><td>'+value.lieferzeit_in_tagen+'</td><td>'+value.storno_moeglich+'</td><td>'+value.vgruppenid+'</td><td>'+value.vgruppenname+'</td></tr>')
                });
            });
            return false;
        });
    });
    </script>
@endsection