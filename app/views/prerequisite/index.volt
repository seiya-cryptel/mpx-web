{# views/prerequisite/index.volt #}
<div class="row mt30">
    <div class="col-xs-2 col-sm-2 col-md-2">
        {% set Category1 = ' class="active" style="background:#E0E080;"' %}
        {{ partial('shared/prerequisiteCategory') }}
    </div>

    <div class="col-xs-10 col-sm-10 col-md-10">   
        <div class="tab-content">
            <!-- JEPXスポット取引情報 -->
            <div class="tab-pane active" id="jepx">

                <ul class="nav nav-tabs">
                    <li class="active"><a href="#spot_trading" data-toggle="tab">JEPXスポット取引情報</a></li>
                    <li><a href="#daily_index" data-toggle="tab">JEPXインデックス</a></li>
                </ul>

                <div class="tab-content">
                    <!-- スポット取引情報 -->
                    <div class="tab-pane active" id="spot_trading">
                        <h2>JEPXスポット取引情報</h2>
                        <div class="tab-pane" id="spot_all">
                            <div id="chartdiv_spot_all" class="chart_jepx"></div>
                            <p class="mt30 clear size_att">出所）<a class="source" href="http://www.jepx.org/market/index.html" target="_blank">日本卸電力取引所（JEPX）</a></p>
                            {{ partial('shared/usageNotice') }}
                        </div>
                    </div>
                    <!-- JEPXインデックス -->
                    <div class="tab-pane" id="daily_index">
                        <h2>JEPXインデックス</h2>
                        <div id="chartdiv_index" class="chart_jepx"></div>

                        <ul id="list_ex">
                            <li><div class="list_ex_dot dot_ex01"></div><span>TTV 1日に約定された電力の総量</span></li>
                            <li><div class="list_ex_dot dot_ex02"></div><span>DA-24 24時間のシステムプライスの平均値</span></li>
                            <li><div class="list_ex_dot dot_ex03"></div><span>DA-DT 8:00-22:00のシステムプライスの平均値</span></li>
                            <li><div class="list_ex_dot dot_ex04"></div><span>DA-PT 13:00-16:00のシステムプライスの平均値</span></li>
                        </ul>

                        <p class="mt30 clear size_att">出所）<a class="source" href="http://www.jepx.org/market/index.html" target="_blank">日本卸電力取引所（JEPX）</a></p>
                        {{ partial('shared/usageNotice') }}
                    </div>
                </div>
            </div>

        </div>      
    </div>

</div>

<script>
    // JEPX
    {% if spot_data_list is defined %}
        {% set spot_data_list = spot_data_list | json_encode %}
    {% endif %}
    {% if spot_all_data_list is defined %}
        {% set spot_all_data_list = spot_all_data_list | json_encode %}
    {% endif %}
    {% if index_data_list is defined %}
        {% set index_data_list = index_data_list | json_encode %}
    {% endif %}
    {% if spot_data_list is defined %}
        var spot_data_list = {{ spot_data_list }};
    {% endif %}
    {% if spot_all_data_list is defined %}
        var spot_all_data_list = {{ spot_all_data_list }};
    {% endif %}            
    {% if index_data_list is defined %}
        var index_data_list = {{ index_data_list }};
    {% endif %}
</script>