{# views/jepxfc/e.volt #}

<div class="row">
    <div class="col-xs-12 col-sm-4 col-sm-offset-4">
        {{ flash.output() }}
    </div>

    <div class="col-xs-12 mt30">
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#system_price" data-toggle="tab" role="tab">System Price</a></li>
            {# if role==4 or role==6 or role==8 or role>8 #}
            {% if enable_5area %}
            <li><a href="/jepxfc/eastpricee/">East Area Price</a></li>
            <li><a href="/jepxfc/westpricee/">West Area Price</a></li>
            <li><a href="/jepxfc/hpricee/">Hokkaido Area Price</a></li>
            <li><a href="/jepxfc/kpricee/">Kyushu Area Price</a></li>
            <li><a href="/jepxfc/fivepricee/">5 Area Price</a></li>
            {# <li><a href="/jepxfc/threeprice/">3 Area Price</a></li> #}
            {% endif %}
        </ul>
        
        <div id="tabContent2" class="tab-content">
            <div class="tab-pane fade in active" id="short">  
                <h2>JEPX Spot Price Forecast (System Price) {{ jepx_upload_date }} Delivery</h2>
                <div id="chartdiv_shortjepx" class="forwardcurve_chart"></div><br>
                <div class="row clearboth mt30">
                    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                        {{ partial('shared/usageNoticee2') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    var export_date = {{export_date}};
    var filename_area = '{{filename_area}}';    
    var series_name = '{{series_name}}';
    {% set short_data_list = short_data_list | json_encode %}
    var short_data_list = {{ short_data_list }};
    
    var dict = {{ dict }};
</script>
