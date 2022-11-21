<div class="row mt30">
    <div class="col-xs-2 col-sm-2 col-md-2">
        {% set Category8 = ' class="active" style="background:#E0E080;"' %}
        {{ partial('shared/prerequisiteCategory') }}
    </div>

    <div class="col-xs-10 col-sm-10 col-md-10">

        <!-- 受渡月別価格推移 -->
        <div class="tab-pane fade in active">

            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    <h2>受渡月別価格推移</h2>

                    <!-- グラフ -->
                    <div id="chartdiv_hst_demands" class="chart_historicaldemand" style="height:650px;"></div><br><br>
                    <div class="row clearboth mt30">
                        <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                            <div class="alert alert-info" role="alert">
                                <p class="p_indent size_att">※システムプライス（ベースロード）の受渡月別フォワード価格について、過去１年間の推移（横軸は配信日）を表示しています。</p>
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
    // 受渡月別価格推移
    {% if delivery_monthly_data_list is defined %}
    var delivery_monthly_data_list = {{ delivery_monthly_data_list }};
    {% endif %}
</script>
