@extends('layouts.admin')

@section('title', 'Article Detail Infomation - ASWO API')

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
                    Article Detail Infomation <small></small>
                </h1>
            </div>
            <div class="col-sm-5 text-right hidden-xs">
                <ol class="breadcrumb push-10-t">
                    <li><a class="link-effect" href="{{ route('admin.index') }}">Admin</a></li>
                    <li><a class="link-effect" href="{{ route('admin.aswo.index') }}">Aswo</a></li>
                    <li>Appliance Search</li>
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
                    This command returns more detailed information about one single article. It is good idea to call this when the user has clicked on one article. For example the complete article family tree will be shown.  <br>
                    <strong>Command:</strong> <code>artikeldetails</code>
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
                                <td>artnr</td>
                                <td>item</td>
                                <td>
                                    ASWO article id e.g. artnr=1000100
                                </td>
                            </tr>
                            <tr>
                                <td>sperrgut</td>
                                <td>bulky goods</td>
                                <td>
                                    sperrgut=1 will return additionally the information if an article is a bulk good by DHL's (Germany) perspective
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
                        <form id="article_detail_information" class="form-horizontal" action="{{ route('admin.aswo.article_detail_information') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-xs-12" for="artnr">artnr (item)</label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="artnr" name="artnr" placeholder="item" value="1000100">
                                    <div class="help-block">ASWO article id e.g. artnr=1000100</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="sperrgut">sperrgut (bulky goods) <span class="text-muted">Optionnal</span></label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="sperrgut" name="sperrgut" placeholder="bulky goods" value="1">
                                    <div class="help-block">sperrgut=1 will return additionally the information if an article is a bulk good by DHL's (Germany) perspective</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12" for="attrib">attrib  <span class="text-muted">Optionnal</span></label>
                                <div class="col-xs-12">
                                    <input class="form-control" type="text" id="attrib" name="attrib" placeholder="bulky goods" value="1">
                                    <div class="help-block">attrib=1 returns additionally some technical data for the article, if available, in HTML-Format. The return may be slower than.</div>
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
                            <!--Put <code>- --</code> in <strong>suchbg</strong> to display all results for a specific manufacturer -->
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
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-vcenter">
                            <thead>
                                <tr>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="unique ID of an article family, always 10digit numeric but with leading 0">
                                        family id<br>
                                        <small class="text-muted">vgruppenid</small>
                                    </th>
                                    <th class="text-center" data-toggle="tooltip" data-placement="top" title="article family name, alphanumeric and special characters">
                                        family name<br>
                                        <small class="text-muted">vgruppenname</small>
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
        var form = $('#article_detail_information');
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
                $.each(data.vgruppenbaum, function(index, value){
                    $('#results table tbody').append('<tr><td>'+value.vgruppenid+'</td><td>'+value.vgruppenname+'</td></tr>');
                });
            });
            return false;
        });
    });
    </script>
@endsection