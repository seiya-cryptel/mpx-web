<div class="row mt30">
    <div class="col-xs-2 col-sm-2 col-md-2">
        {% set Category6 = ' class="active" style="background:#E0E080;"' %}
        {{ partial('shared/prerequisiteCategorye') }}
    </div>

    <div class="col-xs-10 col-sm-10 col-md-10">

        <!-- 実績需要 -->
        <div class="tab-pane fade in active">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Actual Load</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    <h2>Actual Load</h2>

                    <!-- グラフ -->
                    <div id="chartdiv_hst_demands" class="chart_historicaldemand"></div><br>
		<div class="row alert_area"><br>
		<div class="col-xs-12 col-sm-10 col-sm-offset-1"> 
                    {{ partial('shared/usageNoticee') }}
                </div>
                </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // 需要実績
    {% if hst_demands_data_list is defined %}
        {% set hst_demands_data_list = hst_demands_data_list | json_encode %}
    {% endif %}
    {% if hst_demands_data_list is defined %}
        var hst_demands_data_list = {{ hst_demands_data_list }};
    {% endif %}
</script>
