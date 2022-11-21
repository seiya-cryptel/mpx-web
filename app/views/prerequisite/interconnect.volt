<div class="row mt30">
    <div class="col-xs-2 col-sm-2 col-md-2">
        {% set Category7 = ' class="active" style="background:#E0E080;"' %}
        {{ partial('shared/prerequisiteCategory') }}
    </div>

    <div class="col-xs-10 col-sm-10 col-md-10">
        <!-- 連系線容量 -->
        <ul id="pointTab" class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#conv" data-toggle="tab" role="tab">周波数変換設備</a></li>
            <li><a href="/prerequisite/interconnectkitahon">北本連系設備</a></li>
            <li><a href="/prerequisite/interconnectkanmon">関門連系線</a></li>
        </ul>

        <div id="tabContent" class="tab-content">
            <div class="tab-pane fade in active" id="conv">
                <h2>連系線容量想定（周波数変換設備）</h2>
                <div id="chartdiv_interconnect" class="chart_interconnect"></div><br><br>
                <div class="row clearboth mt30">
                    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                        <div class="alert alert-info" role="alert">
                            <p class="p_indent size_att">
                                ※運用容量からマージンを差し引いた値を表示しています。
                            </p>
                        </div>
                        {{ partial('shared/usageNotice') }}

                    </div>
                </div>
            </div>
        </div>
                        
    </div>
</div>

<script type="text/javascript">
    var export_file = '{{export_file}}';
    // 連系線潮流
    {% if interconnect_data_list is defined %}
        {% set interconnect_data_list = interconnect_data_list | json_encode %}
    {% endif %}
    {% if interconnect_data_list is defined %}
        var interconnect_data_list = {{ interconnect_data_list }};
    {% endif %}
</script>
