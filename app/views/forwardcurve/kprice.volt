{# views/forwardcurve/hprice.volt #}
<div class="row">
    <div class="col-xs-12 col-sm-4 col-sm-offset-4">
        {{ flash.output() }}
    </div>

    <div class="col-xs-12 mt30">
        {# if role==2 or role==4 or role==6 or role==8 or role==9 #} {# PlanA2, B2, C2, D2, Admin 2017/04/03 #}
        {% if enable_5area %}
            <ul class="nav nav-tabs" role="tablist">
                <li><a href="/forwardcurve/">システムプライス</a></li>
                <li><a href="/forwardcurve/eastprice/">東エリアプライス</a></li>
                <li><a href="/forwardcurve/westprice/">西エリアプライス</a></li>
                <!-- <li><a href="/forwardcurve/threeprice/">3エリアプライス</a></li> -->
                <li><a href="/forwardcurve/hprice/">北海道エリアプライス</a></li>
                <li class="active"><a href="#system_price">九州エリアプライス</a></li>
                <li><a href="/forwardcurve/fiveprice/">5エリアプライス</a></li>
            </ul>
        {% endif %}
        <div id="tabContent3" class="tab-content">
            <!-- システムプライス タブ -->
            <div class="tab-pane fade in active" id="system_price">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#monthly" data-toggle="tab" role="tab">Monthly</a></li>
                    {# if role > 4 #} {# PlanC 以上 #}
                    {% if enable_daily %}
                        <li><a href="#daily" data-toggle="tab" role="tab">Daily</a></li>
                    {% endif %}
                    {# if role > 6 #} {# PlanD 以上 #}
                    {% if enable_halfhourly %}
                        <li><a href="#half_hourly" data-toggle="tab" role="tab">Half hourly</a></li>
                    {% endif %}
                    {# if role > 8 
                       or fc_hourly
                    #} {# Admin #}
                    {% if enable_hourly %}
                        <li><a href="#hourly" data-toggle="tab" role="tab">Hourly(Fundamental)</a></li>
                    {% endif %}
                </ul>

                <div id="tabContent2" class="tab-content">

                    {{ form("forwardcurve/kprice", 'id': 'calender') }}
                    <ul style="padding: 20px 5px 0px">
                        <label for="date" accesskey="n">配信日:</label>
                        <input name="day" id="date" maxlength="10" type="text" readonly="readonly">
                        {{ submit_button("表示") }}
                    </ul>
                    </form>

                    <!-- tab1 Monthly -->
                    <div class="tab-pane fade in active" id="monthly">
                        <h2>電力フォワードカーブ（九州エリアプライス） {{ monthly_upload_date }} 配信</h2>
                        <div id="monthly_chart" class="forwardcurve_chart"></div>

                        <div class="row clearboth mt30">
                            <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                                <div class="alert alert-info" role="alert"><p class="p_indent size_att">※ベースロードは24時間平均、日中ロード(daytime)は平日8:00-18:00の平均、ピークロードは平日13:00-16:00の平均です。また、当限はJEPXの実績値と残りの期間のフォワード価格の平均値です。</p>
                                </div>
                                {{ partial('shared/usageNotice') }}

                            </div>
                        </div>
                    </div>

                    {# if role > 4 #} {# PlanC 以上 #}
                    {% if enable_daily %}
                    <!-- tab2 Daily -->
                    <div class="tab-pane fade" id="daily">
                        <h2>電力フォワードカーブ（九州エリアプライス） {{ daily_upload_date }} 配信</h2>
                        <div id="chartdiv" class="forwardcurve_chart"></div><br>

                        <div class="row clearboth mt30">
                            <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                                {{ partial('shared/usageNotice') }}
                            </div>
                        </div>
                    </div>
                    {% endif %}

                    {# if role > 6 #} {# PlanD 以上 #}
                    {% if enable_halfhourly %}
                    <!-- tab3 Half hourly -->
                    <div class="tab-pane fade" id="half_hourly">  
                        <h2>電力フォワードカーブ（九州エリアプライス） {{ half_hourly_upload_date }} 配信</h2>
                        <div id="chartdiv2" class="forwardcurve_chart"></div><br>

                        <div class="row clearboth mt30">
                            <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                                {{ partial('shared/usageNotice') }}
                            </div>
                        </div>
                    </div>
                    {% endif %}

                    {# if role > 8 
                       or ( fc_hourly and (role==2 or role==4 or role==6 or role==8) )
                    #}
                    {% if enable_hourly %}
                    <!-- tab4 Hourly -->
                    <div class="tab-pane fade" id="hourly">  
                        <h2>電力フォワードカーブ（九州エリアプライス） {{ hourly_upload_date }} 配信</h2>
                        <div id="hourly_chart" class="forwardcurve_chart"></div><br>

                        <div class="row clearboth mt30">
                            <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                                {{ partial('shared/usageNotice') }}
                            </div>
                        </div>
                    </div>
                    {% endif %}

                    <!-- tab5 Short -->
                    <!--
                    <div class="tab-pane fade" id="short">  
                        <h2>JEPXスポット短期予測 {# jepx_upload_date #} 配信</h2>
                        <div id="chartdiv_shortjepx" class="forwardcurve_chart"></div><br>
                        <div class="row clearboth mt30">
                            <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                                {# partial('shared/usageNotice') #}
                            </div>
                        </div>
                    </div>
                    -->

                </div>
            </div>
        </div>

    </div>

</div>
<script type="text/javascript">
    var export_date = {{export_date}};
    var monthly_data_list = {{ monthly_data_list }};
    var filename_area = '{{ filename_area }}';
    {% if enable_daily %}
        var daily_data_list = {{ daily_data_list }};
    {% endif %}
    {% if enable_halfhourly %}
        var half_hourly_data_list = {{ half_hourly_data_list }};
    {% endif %}
    {% if enable_hourly %}
        var hourly_data_list = {{ hourly_data_list }};
    {% endif %}

    var dict = {{ dict }};
</script>
