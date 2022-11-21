{# views/jepxfc/index.volt #}
<div class="row">
    <div class="col-xs-12 col-sm-4 col-sm-offset-4">
        {{ flash.output() }}
    </div>

    {# if role==4 or role==6 or role==8 or role>8 #}
    {% if enable_5area %}
    <div class="col-xs-12 mt30">
        <ul class="nav nav-tabs" role="tablist">
            <li><a href="/jepxfc/">システムプライス</a></li>
            <li class="active"><a href="#" data-toggle="tab" role="tab">東エリアプライス</a></li>
            <li><a href="/jepxfc/westprice/">西エリアプライス</a></li>
            <li><a href="/jepxfc/hprice/">北海道エリアプライス</a></li>
            <li><a href="/jepxfc/kprice/">九州エリアプライス</a></li>
            <li><a href="/jepxfc/fiveprice/">5エリアプライス</a></li>
            {# <li><a href="/jepxfc/threeprice/">3エリアプライス</a></li> #}
        </ul>
        
        <div id="tabContent2" class="tab-content">
            <div class="tab-pane fade in active" id="short">  
                <h2>JEPXスポット価格予測（東エリアプライス） {{ jepx_upload_date }} 配信</h2>
                <div id="chartdiv_shortjepx" class="forwardcurve_chart"></div><br>
                <div class="row clearboth mt30">
                    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                        <div class="alert alert-info" role="alert">
                            <p class="p_indent size_att">※「東エリア」は、北海道を除く東日本（東北・東京）エリアを示してしています。</p>
                        </div>
                        {{ partial('shared/usageNotice') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {% endif %}

</div>
<script type="text/javascript">
    var export_date = {{export_date}};
    var filename_area = '{{filename_area}}';    
    var series_name = '{{series_name}}';
    {% set short_data_list = short_data_list | json_encode %}
    var short_data_list = {{ short_data_list }};
    
    var dict = {{ dict }};
</script>
