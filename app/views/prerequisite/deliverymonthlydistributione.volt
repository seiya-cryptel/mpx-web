{# views/prerequisite/deliverlymonthlydistributione.volt #}

<div class="row mt30">
    <div class="col-xs-2 col-sm-2 col-md-2">
        {% set Category9 = ' class="active" style="background:#E0E080;"' %}
        {{ partial('shared/prerequisiteCategorye') }}
    </div>

    <div class="col-xs-10 col-sm-10 col-md-10">

        <!-- 受渡月別価格推移 -->
        <div class="tab-pane fade in active">

            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    <h2 class="deliverymonthly_area">Forward Curve Distribution ({{ select_date_stre }})</h2>
                    
                    <form action="/prerequisite/deliverymonthlydistributione" method="POST">
                        Delivery Month：
                        <select name="select_date" onChange="this.form.submit()">
                            {# for date in select_date_list 2020/02/12 #}
                            {% for date, date_show in select_date_list %}
                                {% if selected_select_date == date %}
                                    <option value="{{ date }}" selected>{{ date_show }}</option>
                                {% else %}
                                    <option value="{{ date }}">{{ date_show }}</option>
                                {% endif %}
                            {% endfor %}
                        </select>
                    </form>
                    
                    <!-- グラフ -->
                    <div id="chartdiv_delivery_monthly_distribution" class="chart_historicaldemand"></div>
		<div class="row alert_area">
		<div class="col-xs-12 col-sm-10 col-sm-offset-1"> 
                            <div class="alert alert-info" role="alert">
                                <p class="p_indent size_att">* The distribution of monthly averaged MPX Forward Curve (System Price, 24 Hour) for each contract month over the past 1 year is shown.The verticall axis indicates frequency.</p>
                            </div>
                            {{ partial('shared/usageNoticee') }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // 受渡月別価格分布
    {% if delivery_monthly_data_list is defined %}
    var delivery_monthly_data_list = {{ delivery_monthly_data_list }};
    {% endif %}
</script>
