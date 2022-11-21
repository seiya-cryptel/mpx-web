{# views/prerequisite/demandandrenewableenergyh.volt #}
<div class="row mt30">
    <div class="col-xs-2 col-sm-2 col-md-2">
        {% set Category3 = ' class="active" style="background:#E0E080;"' %}
        {{ partial('shared/prerequisiteCategorye') }}
    </div>

    <div class="col-xs-10 col-sm-10 col-md-10">   

        {# if role==2 or role==4 or role==6 or role==8 or role==9 #} {# PlanA2, B2, C2, D2, Admin #}
        {% if enable_demand_all_menu %}
            <ul class="nav nav-tabs" role="tablist">
                <li><a href="/prerequisite/demandandrenewableenergye/">Nationwide(System)</a></li>
                <li><a href="/prerequisite/demandandrenewableenergyeaste/">East Area</a></li>
                <li><a href="/prerequisite/demandandrenewableenergyweste/">West Area</a></li>
                <li class="active"><a href="#system_price" data-toggle="tab" role="tab">Hokkaido Area</a></li>
                <li><a href="/prerequisite/demandandrenewableenergyke/">Kyushu Area</a></li>
            </ul>
        {% endif %}

        <!-- 需要・再エネ想定 -->
        <div class="tab-pane fade in active" id="jepx3">

            <ul class="nav nav-tabs">
                <li class="active"><a href="#demand" data-toggle="tab">Load</a></li>
                <li><a href="#residual_load" data-toggle="tab">Residual Load</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="demand">
                    <h2>Assumed Load (Hokkaido Area)</h2>
                    <div id="chartdiv_demand_forecast" class="chart_demandandrenewableenergy region_area"></div><br>

		<div class="row alert_area"><br>
		<div class="col-xs-12 col-sm-10 col-sm-offset-1">  
                    {{ partial('shared/usageNoticee') }}
                </div>
                </div>
                </div>


                <div class="tab-pane" id="residual_load">
                    <h2>Assumed Residual Load (Hokkaido Area)</h2>
                    <div id="chartdiv_residual_load" class="chart_demandandrenewableenergy region_residual_area"></div><br>

		<div class="row alert_area"><br>
		<div class="col-xs-12 col-sm-10 col-sm-offset-1"> 
                    <div class="alert alert-info" role="alert"><p class="p_indent size_att">* "Residual demand" is demand minus renewable generation.</p></div>
                    {{ partial('shared/usageNoticee') }}
                </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var export_date = {{export_date}};
    var filename_area = '{{filename_area}}';
    // 前提(需要,風力,太陽光)
    {% if demand_forecast_data_list is defined %}
        {% set demand_forecast_data_list = demand_forecast_data_list | json_encode %}
    {% endif %}
    {% if demand_forecast_data_list is defined %}
        var demand_forecast_data_list = {{ demand_forecast_data_list }};
    {% endif %} 
</script>