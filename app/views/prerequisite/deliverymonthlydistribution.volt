<div class="row mt30">
    <div class="col-xs-2 col-sm-2 col-md-2">
        {% set Category9 = ' class="active" style="background:#E0E080;"' %}
        {{ partial('shared/prerequisiteCategory') }}
    </div>

    <div class="col-xs-10 col-sm-10 col-md-10">

        <!-- 受渡月別価格推移 -->
        <div class="tab-pane fade in active">

            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    <h2>受渡月別価格分布（{{ select_date_str }}受渡）</h2>
                    
                    <form action="/prerequisite/deliverymonthlydistribution" method="POST">
                        受渡月：
                        <select name="select_date" onChange="this.form.submit()">
                            {% for date in select_date_list %}
                                {% if selected_select_date == date %}
                                    <option value="{{ date }}" selected>{{ date }}</option>
                                {% else %}
                                    <option value="{{ date }}">{{ date }}</option>
                                {% endif %}
                            {% endfor %}
                        </select>
                    </form>
                    
                    <!-- グラフ -->
                    <div id="chartdiv_delivery_monthly_distribution" class="chart_historicaldemand"></div><br><br>
                    <div class="row clearboth mt30">
                        <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                            <div class="alert alert-info" role="alert">
                                <p class="p_indent size_att">※システムプライス（ベースロード）の受渡月別フォワード価格について、過去１年間の分布（縦軸は頻度）を表示しています。</p>
                            </div>
                            {{ partial('shared/usageNotice') }}
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
