<div class="row">
<div class="col-xs-12 col-sm-10 col-sm-offset-1">
<ol class="breadcrumb">
	<li>{{ link_to('/', 'ホーム') }}</li>
	<li class="active">（サンプル）電力フォワードカーブ</li>
</ol>
</div>
</div>

<div class="col-xs-12">
    <ul id="termTab" class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#monthly" data-toggle="tab" role="tab">Monthly</a></li>
        <li><a href="#daily" data-toggle="tab" role="tab">Daily</a></li>
        <li><a href="#half_hourly" data-toggle="tab" role="tab">Half hourly</a></li>
    </ul>

    <div id="tabContent2" class="tab-content">

        <!-- tab1 Monthly -->
        <div class="tab-pane fade in active" id="monthly">
            <h2>（サンプル）電力フォワードカーブ  {{ monthly_upload_date }} 配信</h2>
            <div class="clearfix">
                <div id="monthly_chart" class="forwardcurve_chart"></div>
            </div>

            <div class="col-xs-12 col-sm-10 col-sm-offset-1 clearboth mt50">
                <div class="alert alert-warning" role="alert"><p class="p_indent size_att">注：Internet Explorerでは、環境等によって正しく表示されない場合があります（Google Chrome推奨）。</p>
                </div>
                <div class="alert alert-info" role="alert"><p class="p_indent size_att">※ベースロードは24時間平均、日中ロードは平日8:00-18:00の平均です。また、当限はJEPXの実績値と残りの期間のフォワード価格の平均値です。</p>
                </div>
            </div>
        </div>

        <!-- tab2 Daily -->
        <div class="tab-pane fade" id="daily">
            <h2>（サンプル）電力フォワードカーブ  {{ daily_upload_date }} 配信</h2>
            <div class="clearfix">
                <div id="chartdiv" class="forwardcurve_chart"></div>
            </div>
            <div class="col-xs-12 col-sm-10 col-sm-offset-1 clearboth mt50">
                <div class="alert alert-warning" role="alert"><p class="p_indent size_att">注：Internet Explorerでは、環境等によって正しく表示されない場合があります（Google Chrome推奨）。</p>
                </div>
            </div>
        </div>
        
        <!-- tab3 Half hourly -->
        <div class="tab-pane fade" id="half_hourly">
            <h2>（サンプル）電力フォワードカーブ  {{ half_hourly_upload_date }} 配信</h2>
            <div class="clearfix">
                <div id="chartdiv2" class="forwardcurve_chart"></div>
            </div>
            <div class="col-xs-12 col-sm-10 col-sm-offset-1 clearboth mt50">
                <div class="alert alert-warning" role="alert"><p class="p_indent size_att">注：Internet Explorerでは、環境等によって正しく表示されない場合があります（Google Chrome推奨）。</p>
                </div>
            </div>
       </div>
    </div>
</div>

<script type="text/javascript">
    $('#termTab').on('shown.bs.tab', function (e) {
        var activated_tab = e.target; // activated tab
        var previous_tab = e.relatedTarget; // previous tab
        sm_chart.invalidateSize();
        sd_chart.invalidateSize();
        shh_chart.invalidateSize();
    });
</script>

<script type="text/javascript">
    var half_hourly_sample_data = {{ half_hourly_sample_data }};
    var daily_sample_data = {{ daily_sample_data }};
    var monthly_sample_data = {{ monthly_sample_data }};
</script>
