<div class="row mt30">
    <div class="col-xs-2 col-sm-2 col-md-2">
        {% set Category4 = ' class="active" style="background:#E0E080;"' %}
        {{ partial('shared/prerequisiteCategorye') }}
    </div>

    <div class="col-xs-10 col-sm-10 col-md-10">   
        <!-- 燃料価格想定 -->
        <div class="tab-pane fade in active" id="jepx4">
            <!-- 
                タブの切り替えボタン 
                data-toggle : tabを入れることでボタン機能を有効に
                href : リンク先にコンテンツのid名を入れる
            -->

            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Assumed Crude Oil Price at Generation Plant</a></li>
                {% if show202207 %}
                <li><a href="#tab5" data-toggle="tab">Assumed Crude Oil Price at Generation Plant（Additional Procurement）</a></li> {# 2022/07/11 #}
                {% endif %}
                <li><a href="#tab2" data-toggle="tab">Assumed LNG Price at Generation Plant</a></li>
                <li><a href="#tab4" data-toggle="tab">Assumed LNG Price at Generation Plant(Additional Procurement)</a></li> {# 2022/03/17 202203-03 #}
                <li><a href="#tab3" data-toggle="tab">Assumed Coal Price at Generation Plant</a></li>
                {% if show202207 %}
                <li><a href="#tab6" data-toggle="tab">Assumed Coal Price at Generation Plant（Additional Procurement）</a></li> {# 2022/07/11 #}
                {% endif %}
            </ul>

            <!-- 
              タブの切り替えボタン 
              class : tab-paneで非表示化
              id : ボタンと同じidを使用する
            -->

            <div class="tab-content">
                {{ form("prerequisite/fuele", 'id': 'calender') }}{# 2020/02/15 #}
                    <ul style="padding: 20px 5px 0px">
                        <label for="oil_lng_coal_date" accesskey="n">Calculation date : </label>
                        <input name="selected_date_oil_lng_coal" id="oil_lng_coal_date" maxlength="10" type="text" readonly="readonly">
                        {{ submit_button("display") }}
                    </ul>
                </form>
                <div class="tab-pane active" id="tab1">
                    <h2>Assumed Crude Oil Price at Generation Plant {{ oil_lng_coal_upload_datee }} </h2>
                    <div id="chartdiv_sub_oil" class="chart_fuel"></div><br>
                    <div class="row alert_area">
                        <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                            {{ partial('shared/usageNoticee') }}
                        </div>
                    </div>
                </div>
                {% if show202207 %}
                <div class="tab-pane active" id="tab5">
                    <h2>Assumed Crude Oil Price at Generation Plant(Additional Procurement) {{ oil_lng_coal_upload_datee }} </h2>
                    <div id="chartdiv_sub_oil_add" class="chart_fuel"></div><br>
                    <div class="row alert_area">
                        <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                            {{ partial('shared/usageNoticee') }}
                        </div>
                    </div>
                </div>
                {% endif %}

                <div class="tab-pane" id="tab2">
                    <h2>Assumed LNG Price at Generation Plant {{ oil_lng_coal_upload_datee }} </h2>
                    <div id="chartdiv_sub_lng" class="chart_fuel"></div><br><br>
                    <div class="clear row alert_area"><br>
                        <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                            {{ partial('shared/usageNoticee') }}
                        </div>
                    </div>
                </div>
                {# 2022/03/17 202203-03 #}
                <div class="tab-pane" id="tab4">
                    <h2>Assumed LNG Price at Generation Plant(Additional Procurement) {{ oil_lng_coal_upload_datee }} </h2>
                    <div id="chartdiv_sub_lng_add" class="chart_fuel"></div><br><br>
                    <div class="clear row alert_area"><br>
                        <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                            {{ partial('shared/usageNoticee') }}
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="tab3">
                    <h2>Assumed Coal Price at Generation Plant {{ oil_lng_coal_upload_datee }} </h2>
                    <div id="chartdiv_sub_coal" class="chart_fuel"></div><br><br>
                    <div class="row alert_area"><br>
                        <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                            {{ partial('shared/usageNoticee') }}
                        </div>
                    </div>
                </div>                        
                {% if show202207 %}
                <div class="tab-pane" id="tab6">
                    <h2>Assumed Coal Price at Generation Plant(Additional Procurement) {{ oil_lng_coal_upload_datee }} </h2>
                    <div id="chartdiv_sub_coal_add" class="chart_fuel"></div><br><br>
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

<script type="text/javascript">
    var export_date = {{export_date}};

    // 燃料価格想定(石油価格想定, LNG価格想定, 石炭価格想定)
    {% if sub_oil_data_list is defined %}
        {% set sub_oil_data_list = sub_oil_data_list | json_encode %}
    {% endif %}
    {% if sub_oil_add_data_list is defined %}{# 2022/07/11 #}
        {% set sub_oil_add_data_list = sub_oil_add_data_list | json_encode %}
    {% endif %}
    {% if sub_lng_data_list is defined %}
        {% set sub_lng_data_list = sub_lng_data_list | json_encode %}
    {% endif %}
    // 2022/03/17 202203-03
    {% if sub_lng_add_data_list is defined %}
        {% set sub_lng_add_data_list = sub_lng_add_data_list | json_encode %}
    {% endif %}
    {% if sub_coal_data_list is defined %}
        {% set sub_coal_data_list = sub_coal_data_list | json_encode %}
    {% endif %}
    {% if sub_coal_add_data_list is defined %}{# 2022/07/11 #}
        {% set sub_coal_add_data_list = sub_coal_add_data_list | json_encode %}
    {% endif %}
        
    {% if sub_oil_data_list is defined %}
        var sub_oil_data_list = {{ sub_oil_data_list }};
    {% endif %}
    {% if sub_oil_add_data_list is defined %}{# 2022/07/11 #}
        var sub_oil_add_data_list = {{ sub_oil_add_data_list }};
    {% endif %}
    {% if sub_lng_data_list is defined %}
        var sub_lng_data_list = {{ sub_lng_data_list }};
    {% endif %}
    // 2022/03/17 202203-03
    {% if sub_lng_add_data_list is defined %}
        var sub_lng_add_data_list = {{ sub_lng_add_data_list }};
    {% endif %}
    {% if sub_coal_data_list is defined %}
        var sub_coal_data_list = {{ sub_coal_data_list }};
    {% endif %}
    {% if sub_coal_add_data_list is defined %}{# 2022/07/11 #}
        var sub_coal_add_data_list = {{ sub_coal_add_data_list }};
    {% endif %}

    var dict = {{ dict }};
</script>