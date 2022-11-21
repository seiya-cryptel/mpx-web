{# views/forwardcurve/eastpricee.volt #}

<div class="row">
    <div class="col-xs-12 col-sm-4 col-sm-offset-4">
        {{ flash.output() }}
    </div>

    <div class="col-xs-12 mt30">
        {# if role==2 or role==4 or role==6 or role==8 or role==9 #} {# PlanA2, B2, C2, D2, Admin 2017/04/03 #}
        {% if enable_5area %}
            <ul class="nav nav-tabs" role="tablist">
                <li><a href="/forwardcurve/e">System Price</a></li>
                <li class="active"><a href="#system_price" data-toggle="tab" role="tab">East Area Price</a></li>
                <li><a href="/forwardcurve/westpricee/">West Area Price</a></li>
                <li><a href="/forwardcurve/hpricee/">Hokkaido Area Price</a></li>
                <li><a href="/forwardcurve/kpricee/">Kyushu Area Price</a></li>
                <li><a href="/forwardcurve/fivepricee/">5 Area Price</a></li>
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

                    {# form("forwardcurve/eastprice", 'id': 'calender') #}
                    {{ form("forwardcurve/eastpricee", 'id': 'calender') }}
                    <ul style="padding: 20px 5px 0px">
                        <label for="date" accesskey="n">Delivery date:</label>
                        <input name="day" id="date" maxlength="10" type="text" readonly="readonly">
                        {{ submit_button("display") }}
                    </ul>
                    </form>

                    <!-- tab1 Monthly -->
                    <div class="tab-pane fade in active" id="monthly">
                        <h2>Power Forward Curve (East Area Price) {{ monthly_upload_date }}</h2>
                        <div id="monthly_chart" class="forwardcurve_chart"></div>

                        <div class="row clearboth mt30">
                            <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                                <div class="alert alert-info" role="alert">
                                    <p class="p_indent size_att">
                                        {# * Base load is 24 hours average, daytime is average from 8:00 to 18:00 on weekdays, and peak load is average from 13:00 to 16:00 on weekdays. The limit is the average of JEPX actual value and forward Price fot the remaining period. #}
                                        * The Base Load is an average of 24 hours, the Daytime Load is an average of 8: 00 -18: 00 weekdays, and the Peak Load is an average of 13: 00 -16: 00 weekdays. The Price for the current month is the weighted average of the actual value of JEPX and the forward Price for the remaining periods.
                                    </p>
                                    <p class="p_indent size_att">* “East Area” refers to Tohoku and Tokyo areas (excluding Hokkaido area).</p>{# 2020/03/01 #}
                                </div>
                                {{ partial('shared/usageNoticee2') }}

                            </div>
                        </div>
                    </div>

                    {# if role > 4 #} {# PlanC 以上 #}
                    {% if enable_daily %}
                    <!-- tab2 Daily -->
                    <div class="tab-pane fade" id="daily">
                        <h2>Power Forward Curve (East Area Price) {{ daily_upload_date }}</h2>
                        <div id="chartdiv" class="forwardcurve_chart"></div><br>

                        <div class="row clearboth mt30">
                            <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                                <div class="alert alert-info" role="alert">
                                    <p class="p_indent size_att">* “East Area” refers to Tohoku and Tokyo areas (excluding Hokkaido area).</p>{# 2020/03/01 #}
                                </div>
                                {{ partial('shared/usageNoticee2') }}
                            </div>
                        </div>
                    </div>
                    {% endif %}

                    {# if role > 6 #} {# PlanD 以上 #}
                    {% if enable_halfhourly %}
                    <!-- tab3 Half hourly -->
                    <div class="tab-pane fade" id="half_hourly">  
                        <h2>Power Forward Curve (East Area Price) {{ half_hourly_upload_date }}</h2>
                        <div id="chartdiv2" class="forwardcurve_chart"></div><br>

                        <div class="row clearboth mt30">
                            <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                                <div class="alert alert-info" role="alert">
                                    <p class="p_indent size_att">* “East Area” refers to Tohoku and Tokyo areas (excluding Hokkaido area).</p>
                                </div>
                                {{ partial('shared/usageNoticee2') }}
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
                        <h2>Power Forward Curve (East Area Price) {{ hourly_upload_date }}</h2>
                        <div id="hourly_chart" class="forwardcurve_chart"></div><br>

                        <div class="row clearboth mt30">
                            <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                                <div class="alert alert-info" role="alert">
                                    <p class="p_indent size_att">* “East Area” refers to Tohoku and Tokyo areas (excluding Hokkaido area).</p>
                                </div>
                                {{ partial('shared/usageNoticee2') }}
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
