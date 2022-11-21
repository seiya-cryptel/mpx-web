{# views/dsprice/h.volt #}
<div class="row">
    <div class="col-xs-12 col-sm-4 col-sm-offset-4">
        {{ flash.output() }}
    </div>


    <div class="col-xs-12 mt30">
        <ul class="nav nav-tabs" role="tablist">
            <li><a href="/dsprice/">システム</a></li>
            <li><a href="/dsprice/e/">東エリア</a></li>
            <li><a href="/dsprice/w/">西エリア</a></li>
            <li class="active"><a href="#" data-toggle="tab" role="tab">北海道エリア</a></li>
            <li><a href="/dsprice/k/">九州エリア</a></li>
        </ul>
        
        <div id="tabContent2" class="tab-content">
            <div class="tab-pane fade in active" id="short">  
                <h2>JEPXスポット価格予測（1か月）（北海道エリア）{{ ds_upload_date }} 計算</h2>
                <div id="chartdiv_price" class="chart_dsprice"></div><br>
		<div id="onemonthprice_area">
                {{ partial('shared/onemonthprice') }}
                </div>
                <br>
                <div class="alert alert-info" role="alert"><p class="p_indent size_att">
                    ※計算時点での1か月気象予報をもとにした価格予測値の確率分布を、0.01円刻みで表示しています。<br>
                    例えば8~9円に入る確率は8~9円の間の曲線に囲まれた面積として計算できます。</p></div>
                <br>
                <h2>Generation Stack (Hourly)（北海道エリア）{{ ds_upload_date }} 計算</h2>
                <div id="chartdiv_ds" class="chart_dsbalance"></div><br>
                <div class="row clearboth mt30">
                    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                        {{ partial('shared/usageNotice') }}
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
