<div class="row mt30">
    <div class="col-xs-2 col-sm-2 col-md-2">
        {% set Category7 = ' class="active" style="background:#E0E080;"' %}
        {{ partial('shared/prerequisiteCategorye') }}
    </div>

    <div class="col-xs-10 col-sm-10 col-md-10">
        <!-- 連系線容量 -->
        <ul id="pointTab" class="nav nav-tabs" role="tablist">
            <li><a href="/prerequisite/interconnecte">Frequency Conversion Facility</a></li>
            <li><a href="/prerequisite/interconnectkitahone">Hokkaido-Tohoku Interconnecter</a></li>
            <li class="active"><a href="#kanmon" data-toggle="tab" role="tab">Chugoku-Kyushu Interconnector</a></li>
        </ul>

        <div id="tabContent" class="tab-content">
            <div class="tab-pane fade in active" id="kanmon">
                <h2>Assumed Avilable Capacity of Interconnector (Chugoku-Kyushu Interconnector)</h2>
                <div id="chartdiv_interconnect" class="chart_interconnect"></div><br>
                <div class="row"><br>
                    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                        <div class="alert alert-info" role="alert">
                            <p class="p_indent size_att">
                                * "Avilable Capacity" is "Operating capacity" minus "Emergency margin".
                            </p>
                        </div>
                        {{ partial('shared/usageNoticee') }}

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
