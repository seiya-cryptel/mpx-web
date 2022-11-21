<div class="row mt30">
    <div class="col-xs-2 col-sm-2 col-md-2">
        {% set Category11 = ' class="active" style="background:#f0f0f0;"' %}
        {{ partial('shared/prerequisiteCategory') }}
    </div>

    <div class="col-xs-10 col-sm-10 col-md-10">

        <!-- JEPXスポット短期予測 -->
        <div class="tab-pane fade in active">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">JEPXスポット短期予測</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    <h2>JEPXスポット短期予測</h2>

                    <!-- グラフ -->
                    <div id="chartdiv_shortjepx" class="chart_historicaldemand"></div><br><br>

                    {{ partial('shared/usageNotice') }}
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // JEPX短期予想
    {% set short_data_list = short_data_list | json_encode %}
    var short_data_list = {{ short_data_list }};
</script>
