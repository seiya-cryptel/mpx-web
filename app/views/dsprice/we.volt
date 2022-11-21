{# views/dsprice/w.volt #}
<div class="row">
    <div class="col-xs-12 col-sm-4 col-sm-offset-4">
        {{ flash.output() }}
    </div>


    <div class="col-xs-12 mt30">
        <ul class="nav nav-tabs" role="tablist">
            <li><a href="/dsprice/en">System Price</a></li>
            <li><a href="/dsprice/ee">East Area Price</a></li>
            <li class="active"><a href="#" data-toggle="tab" role="tab">West Area Price</a></li>
            <li><a href="/dsprice/he">Hokkaido Area Price</a></li>
            <li><a href="/dsprice/ke">Kyushu Area Price</a></li>
        </ul>
        
        <div id="tabContent2" class="tab-content">
            <div class="tab-pane fade in active" id="short">  
                <h2>JEPX Spot Price Forecast (1month) (West Area){{ ds_upload_date }} </h2>
                <div id="chartdiv_price" class="chart_dsprice"></div>

		<div id="onemonthprice_area">
                {{ partial('shared/onemonthpricee') }}
		</div>
                <br>
		<div class="row">
		<div class="col-xs-12 col-sm-10 col-sm-offset-1">
                <div class="alert alert-info" role="alert"><p class="p_indent size_att">
                    *The probability distribution of the price forecast value based on the 1 month weather forecast at the time of calculation is displayed in increments of 0.01 JPY.<br>
                    For example, the probability of entering 8 ~ 9 JPY can be calculated as the area enclosed by the curve between 8 ~ 9 JPY.
                </p></div>
		</div>
		</div>
                <br>

<!-- Generation Stack (Hourly)（システム） -->
                <h2 class="generationstack_area clearfix">Generation Stack (Hourly)(West Area){{ ds_upload_date }} </h2>
                <div id="chartdiv_ds" class="chart_dsbalance"></div><br>
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
    var export_date = '{{ export_date }}';
    var filename_area = '{{ filename_area }}';    
    var series_name = '{{ series_name }}';
    {% set ds_data_list = ds_data_list | json_encode %}
    var ds_data_list = {{ ds_data_list }};
    var ds_max = {{ ds_max }};
    {% set price_data_list = price_data_list | json_encode %}
    var price_data_list = {{ price_data_list }};
    var price_low = {{ price_low }};
    var price_high = {{ price_high }};
    {% set week_dates = week_dates | json_encode %}
    var week_dates = {{ week_dates }};
    
    var dict = {{ dict }};
</script>
