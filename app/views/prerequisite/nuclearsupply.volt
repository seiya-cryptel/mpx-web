<div class="row mt30">
    <div class="col-xs-2 col-sm-2 col-md-2">
        {% set Category10 = ' class="active" style="background:#f0f0f0;"' %}
        {{ partial('shared/prerequisiteCategory') }}
    </div>

    <div class="col-xs-10 col-sm-10 col-md-10">

        <!-- 原子力供給 -->
        <div class="tab-pane fade in active">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">原子力供給</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    <h2>原子力供給</h2>
                    
                    <!-- グラフ -->
                    <div id="chartdiv_nuclearsupply" class="chart_historicaldemand"></div><br><br>

                    {{ partial('shared/usageNotice') }}
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // 原子力供給
//    {% if delivery_monthly_data_list is defined %}
//    var delivery_monthly_data_list = {{ delivery_monthly_data_list }};
//    {% endif %}
</script>
