{# views/prerequisite/capacityhokkaido.volt #}
<div class="row mt30">
    <div class="col-xs-2 col-sm-2 col-md-2">
        {% set Category5 = ' class="active" style="background:#E0E080;"' %}
        {{ partial('shared/prerequisiteCategory') }}
     </div>

    <div class="col-xs-10 col-sm-10 col-md-10">

        {% if role==4 or role==6 or role==8 or role==9 %} {# PlanB2, C2, D2, Admin #}
            <ul class="nav nav-tabs" role="tablist">
                <li><a href="/prerequisite/capacity/">全国エリア</a></li>
                <li><a href="/prerequisite/capacityeast/">東エリア</a></li>
                <li><a href="/prerequisite/capacitywest/">西エリア</a></li>
                <li class="active"><a href="#system_price" data-toggle="tab" role="tab">北海道エリア</a></li>
                <li><a href="/prerequisite/capacitykyushu/">九州エリア</a></li>
            </ul>
        {% endif %}
 
        <!-- capacity -->
        <div class="tab-pane fade in active" id="jepx4">

            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">火力</a></li>
                <li><a href="#tab2" data-toggle="tab">原子力</a></li>
                <li><a href="#sunlight" data-toggle="tab">太陽光</a></li>
                <li><a href="#wind_power" data-toggle="tab">風力</a></li>

                <li><a href="#geothermal_power" data-toggle="tab">地熱</a></li>
                <li><a href="#biomass" data-toggle="tab">バイオマス</a></li>

                {% if role > 2 %} {# admin #}
                    <li><a href="#hydro" data-toggle="tab">水力</a></li>
                    <li><a href="#hydro_pump" data-toggle="tab">揚水</a></li>
                {% endif %}
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    <h2>火力供給力（北海道エリア）{{ supply_capacity_assumed_date }} 想定</h2>
                    <div id="chartdiv_capacity_thermals" class="chart_capacity"></div><br><br>
                    {{ partial('shared/usageNotice') }}
                </div>
                <div class="tab-pane" id="tab2">
                    <h2>原子力供給力（北海道エリア）{{ supply_capacity_assumed_date }} 想定</h2>
                    <div id="chartdiv_capacity_nuclears" class="chart_capacity"></div><br><br>
                    {{ partial('shared/usageNotice') }}
                </div>
                <div class="tab-pane" id="sunlight">
                    <h2>太陽光発電量想定（北海道エリア）</h2>
                    <div id="chartdiv_solar" class="chart_demandandrenewableenergy"></div><br><br>    
                    {{ partial('shared/usageNotice') }}
                </div>
                <div class="tab-pane" id="wind_power">
                    <h2>風力発電量想定（北海道エリア）</h2>
                    <div id="chartdiv_wind" class="chart_demandandrenewableenergy"></div><br><br>    
                    {{ partial('shared/usageNotice') }}
                </div>

                <div class="tab-pane" id="geothermal_power">
                    <h2>地熱発電量想定（北海道エリア）</h2>
                    <div id="chartdiv_geothermal_power" class="chart_demandandrenewableenergy"></div><br><br>    
                    {{ partial('shared/usageNotice') }}
                </div>
                <div class="tab-pane" id="biomass">
                    <h2>バイオマス発電量想定（北海道エリア）</h2>
                    <div id="chartdiv_biomass" class="chart_demandandrenewableenergy"></div><br><br>    
                    {{ partial('shared/usageNotice') }}
                </div>

                {% if role > 2 %} {# admin #}
                <div class="tab-pane" id="hydro">
                    <h2>水力発電量想定（北海道エリア）</h2>
                    <div id="chartdiv_hydro" class="chart_demandandrenewableenergy"></div><br><br>    
                    {{ partial('shared/usageNotice') }}
                </div>
                <div class="tab-pane" id="hydro_pump">
                    <h2>揚水発電量想定（北海道エリア）</h2>
                    <div id="chartdiv_hydro_pump" class="chart_demandandrenewableenergy"></div><br><br>    
                    {{ partial('shared/usageNotice') }}
                </div>
                {% endif %}

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var export_date = {{export_date}};
    var filename_area = '{{filename_area}}';

    // 供給力想定 (火力, 原子力, 太陽光, 風力, 地熱, バイオマス, 水力, 揚水)
    {% if demand_forecast_data_list is defined %}
        {% set demand_forecast_data_list = demand_forecast_data_list | json_encode %}
        var demand_forecast_data_list = {{ demand_forecast_data_list }};
    {% endif %}


    {% if capacity_thermals_data_list is defined %}
        {% set capacity_thermals_data_list = capacity_thermals_data_list | json_encode %}
        var capacity_thermals_data_list = {{ capacity_thermals_data_list }};
        {% set event_data_list_for_thermal = event_data_list_for_thermal | json_encode %}
        var event_data_list_for_thermal = {{ event_data_list_for_thermal }};
    {% endif %}
    {% if capacity_nuclears_data_list is defined %}
        {% set capacity_nuclears_data_list = capacity_nuclears_data_list | json_encode %}
        var capacity_nuclears_data_list = {{ capacity_nuclears_data_list }};
        {% set event_data_list_for_nuclear = event_data_list_for_nuclear | json_encode %}
        var event_data_list_for_nuclear = {{ event_data_list_for_nuclear }};
    {% endif %}

</script>
