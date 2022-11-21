{# views/prerequisite/fuelandexchange.volt #}
<div class="row mt30">
    <div class="col-xs-2 col-sm-2 col-md-2">
        {% set Category2 = ' class="active" style="background:#E0E080;"' %}
        {{ partial('shared/prerequisiteCategory') }}
     </div>

    <div class="col-xs-10 col-sm-10 col-md-10">   
        <!-- 燃料・為替先物 -->

        <div class="tab-pane fade in active" id="jepx2">
            <ul class="nav nav-tabs">
                {# 2022/03/17 202203-02
                <li class="active"><a href="#oil" data-toggle="tab">原油先物</a></li>
                <li><a href="#exchange" data-toggle="tab">為替先物</a></li>
                #}
                <li class="active"><a href="#exchange" data-toggle="tab">為替先物</a></li>
            </ul>

            <div class="tab-content">
                {{ form("prerequisite/fuelandexchange", 'id': 'calender') }}
                <ul style="padding: 20px 5px 0px">
                    <label for="subs_date" accesskey="n">セトルメント日:</label>
                    <input name="selected_date_subs" id="subs_date" maxlength="10" type="text" readonly="readonly">
                    {{ submit_button("表示") }}
                </ul>
                </form>

                {# <div class="tab-pane active" id="oil"> #}
                <div class="tab-pane" id="oil">
                    <h2>ドバイ原油先物 {{ subs_upload_date }} セトルメント</h2> 
                    <div id="chartdiv_oil" class="chart_fuelandexchange"></div><br><br>    
                    <p class="clear size_att">出所）<a class="source" href="http://www.cmegroup.com/trading/energy/crude-oil/dubai-crude-oil-calendar-swap-futures.html" target="_blank">CME Group</a></p>
                    <div class="alert alert-info" role="alert"><p class="p_indent size_att">※直近３年以内の各限月のセトルメント価格を表示しています。</p>
                    </div>
                    {{ partial('shared/usageNotice') }}
                </div>
                <div class="tab-pane" id="coal">
                    <h2>ニューカッスル石炭先物 {{ subs_upload_date }} セトルメント</h2>
                    <div id="chartdiv_coal" class="chart_fuelandexchange"></div><br><br>    
                    <p class="clear size_att">出所）<a class="source" href="http://www.cmegroup.com/trading/energy/coal/coal-api-5-fob-newcastle-argus-mccloskey.html" target="_blank">CME Group</a></p>
                    <div class="alert alert-info" role="alert"><p class="p_indent size_att">※直近年と翌年の各限月のセトルメント価格を表示しています。</p>
                    </div>
                    {{ partial('shared/usageNotice') }}
                </div>
                {# <div class="tab-pane" id="exchange"> #}
                <div class="tab-pane active" id="exchange">
                    <h2>為替先物 {{ subs_upload_date }} セトルメント</h2>
                    <div id="chartdiv_exchange" class="chart_fuelandexchange"></div><br><br>    
                    <p class="clear size_att">出所）<a class="source" href="http://www.cmegroup.com/trading/fx/g10/japanese-yen.html" target="_blank">CME Group</a></p>
                    <div class="alert alert-info" role="alert"><p class="p_indent size_att">※直近３年以内の各限月（四半期）のセトルメント価格を表示しています。</p>
                    </div>
                    {{ partial('shared/usageNotice') }}
                </div>
            </div>
        </div>

    </div>

</div>

<script type="text/javascript">
    var export_date = {{export_date}};

    // 燃料・為替先物
    {% if oil_data_list is defined %}
        {% set oil_data_list = oil_data_list | json_encode %}
    {% endif %}
    {% if coal_data_list is defined %}
        {% set coal_data_list = coal_data_list | json_encode %}
    {% endif %}
    {% if exchange_data_list is defined %}
        {% set exchange_data_list = exchange_data_list | json_encode %}
    {% endif %}
    {% if oil_data_list is defined %}
        var oil_data_list = {{ oil_data_list }};
    {% endif %}
    {% if coal_data_list is defined %}
        var coal_data_list = {{ coal_data_list }};
    {% endif %}
    {% if exchange_data_list is defined %}
        var exchange_data_list = {{ exchange_data_list }};
    {% endif %}

    var dict = {{ dict }};
</script>

