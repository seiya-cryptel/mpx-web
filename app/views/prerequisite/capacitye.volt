{# views/prerequisite/capacity.volt #}
<div class="row mt30">
    <div class="col-xs-2 col-sm-2 col-md-2">
        {% set Category5 = ' class="active" style="background:#E0E080;"' %}
        {{ partial('shared/prerequisiteCategorye') }}
     </div>

<div class="col-xs-10 col-sm-10 col-md-10">

        {# if role==2 or role==4 or role==6 or role==8 or role==9 #} {# PlanA2, B2, C2, D2, Admin #}
        {% if enable_capacity_all_menu %}
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#system_price" data-toggle="tab" role="tab">Nationwide (System)</a></li>
            <li><a href="/prerequisite/capacityeaste/">East Area</a></li>
            <li><a href="/prerequisite/capacityweste/">West Area</a></li>
            <li><a href="/prerequisite/capacityhokkaidoe/">Hokkaido Area</a></li>
            <li><a href="/prerequisite/capacitykyushue/">Kyushu Area</a></li>
        </ul>
        {% endif %}
 
        <!-- capacity -->
        <div class="tab-pane fade in active" id="jepx4">

            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Thermal</a></li>
                <li><a href="#tab2" data-toggle="tab">Nuclear</a></li>
                <li><a href="#sunlight" data-toggle="tab">Solar</a></li>
                <li><a href="#wind_power" data-toggle="tab">Wind</a></li>

                <li><a href="#geothermal_power" data-toggle="tab">Geothermal</a></li>
                <li><a href="#biomass" data-toggle="tab">Biomass</a></li>

                {# if role > 2 #} {# admin #}
                {% if enable_capacity_hydro_menu %}
                    <li><a href="#hydro" data-toggle="tab">Hydro</a></li>
                    <li><a href="#hydro_pump" data-toggle="tab">Pumped Hydro</a></li>
                {% endif %}
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    <h2>Assumed Availability Capacity of Thermal Generation (Nationwide) {{ supply_capacity_assumed_datee }}</h2>
                    <div id="chartdiv_capacity_thermals" class="chart_capacity"></div><br>
		<div class="row alert_area"><br>
		<div class="col-xs-12 col-sm-10 col-sm-offset-1">  
                    {{ partial('shared/usageNoticee') }}
                </div>
                </div>
                </div>

                <div class="tab-pane" id="tab2">
                    <h2>Assumed Availability Capacity of Nuclear Generation (Nationwide) {{ supply_capacity_assumed_datee }}</h2>
                    <div id="chartdiv_capacity_nuclears" class="chart_capacity"></div><br>
		<div class="row alert_area"><br>
		<div class="col-xs-12 col-sm-10 col-sm-offset-1">  
                    {{ partial('shared/usageNoticee') }}
                </div>
                </div>
                </div>

                <div class="tab-pane" id="sunlight">
                    <h2>Assumed Solar Generation (Nationwide)</h2>
                    <div id="chartdiv_solar" class="chart_demandandrenewableenergy"></div><br>
		<div class="row alert_area"><br>
		<div class="col-xs-12 col-sm-10 col-sm-offset-1">  
                    {{ partial('shared/usageNoticee') }}
                </div>
                </div>
                </div>

                <div class="tab-pane" id="wind_power">
                    <h2>Assumed Wind Generation (Nationwide)</h2>
                    <div id="chartdiv_wind" class="chart_demandandrenewableenergy"></div><br>
		<div class="row alert_area"><br>
		<div class="col-xs-12 col-sm-10 col-sm-offset-1">  
                    {{ partial('shared/usageNoticee') }}
                </div>
                </div>
                </div>

                <div class="tab-pane" id="geothermal_power">
                    <h2>Assumed Geothermal Generation (Nationwide)</h2>
                    <div id="chartdiv_geothermal_power" class="chart_demandandrenewableenergy"></div><br>
		<div class="row alert_area"><br>
		<div class="col-xs-12 col-sm-10 col-sm-offset-1">  
                    {{ partial('shared/usageNoticee') }}
                </div>
                </div>
                </div>

                <div class="tab-pane" id="biomass">
                    <h2>Assumed Biomass Generation (Nationwide)</h2>
                    <div id="chartdiv_biomass" class="chart_demandandrenewableenergy"></div><br>
		<div class="row alert_area"><br>
		<div class="col-xs-12 col-sm-10 col-sm-offset-1">  
                    {{ partial('shared/usageNoticee') }}
                </div>
                </div>
                </div>

                {# if role > 2 #} {# admin #}
                {% if enable_capacity_hydro_menu %}
                <div class="tab-pane" id="hydro">
                    <h2>Assumed Hydro Generation (Nationwide)</h2>
                    <div id="chartdiv_hydro" class="chart_demandandrenewableenergy"></div><br>
		<div class="row alert_area"><br>
		<div class="col-xs-12 col-sm-10 col-sm-offset-1">  
                    {{ partial('shared/usageNoticee') }}
                </div>
                </div>
                </div>

                <div class="tab-pane" id="hydro_pump">
                    <h2>Assumed Pumped Hydro Generation (Nationwide)</h2>
                    <div id="chartdiv_hydro_pump" class="chart_demandandrenewableenergy"></div><br>
		<div class="row alert_area"><br>
		<div class="col-xs-12 col-sm-10 col-sm-offset-1">  
                    {{ partial('shared/usageNoticee') }}
                </div>
                </div>
                </div>
                {% endif %}

            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    var export_date = {{export_date}};
    var filename_area = '{{filename_area}}';

    // 供給力想定 (Thermal, Nuclear, Solar, Wind, Geothermal, Biomass, Hydro, Pumped Hydro)
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
