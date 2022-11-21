{# views/news/index.volt #}
<div class="row">
<div class="col-xs-12 col-sm-10 col-sm-offset-1">
<ol class="breadcrumb">
	<li>{{ link_to('/index/e', 'Home') }}</li>
	<li class="active">Notice</li>
</ol>
</div>
</div>

<div class="row">
<div class="col-xs-12 col-sm-10 col-sm-offset-1">
<h2>Notice</h2>

<div class="row">
<div class="col-xs-12 col-sm-4 col-sm-offset-4">
      {{ flash.output() }}
</div>
</div>

    <table id="example" class="table table-striped table-bordered table_news">
        <thead>
            <tr class="table_news_head">
                <th class="nowrap">Delivery</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            {% for new in news %}
            <tr>
                <td>
                    {{ new.date_notice_disp }}
                </td>
                <td>
                    {% if new.category == 'NEWS' %}
                        <span class="label label-warning">News</span>
                    {% elseif new.category == 'REPORT_M' %}
                        <span class="label label-success">Report</span>
                    {% elseif new.category == 'REPORT_W' %}
                        <span class="label label-success">Report</span>
                    {# 2017/07/27 #}
                    {% elseif new.category == 'REPORT_LFC' %}
                        <span class="label label-success">Report</span>
                    {# 2017/11/16 #}
                    {% elseif new.category == 'REPORT_GS' %}
                        <span class="label label-success">Report</span>
                    {# 2018/05/04 #}
                    {% elseif new.category == 'REPORT_VA' %}
                        <span class="label label-success">Report</span>
                    {% elseif new.category == 'REPORT_RP' %}
                        <span class="label label-success">Report</span>
                    {% elseif new.category == 'REPORT_O' %}
                        <span class="label label-success">Report</span>
                    {% elseif new.category == 'MODEL' %}
                        <span class="label label-primary">Model</span>
                    {% endif %}
                    
                    {% if new.category == 'NEWS' %}
                        {% if new.url_e is not empty %}
                            {{ link_to(new.url_e, new.title_e, 'target': '_blank', new.relativeFlag) }}
                        {% else %}
                            {{ new.title_e }}
                        {% endif %}
                    {% elseif new.category == 'REPORT_M' %}
                        {# if role > 0 2018/10/07 #}
                        {# if enable_pay_user_menu #}
                        {% if enable_report_monthly %}
                            {{ link_to('/report/m/' ~ new.url_e, new.title_e, 'target': '_blank') }}
                        {% else %}
                            {{ new.title_e }}
                        {% endif %}
                    {% elseif new.category == 'REPORT_W' %}
                        {# if role > 0 2018/10/07 #}
                        {# if enable_pay_user_menu #}
                        {% if enable_report_weekly %}
                            {{ link_to('/report/w/' ~ new.url_e, new.title_e, 'target': '_blank') }}
                        {% else %}
                            {{ new.title_e }}
                        {% endif %}
                    {# 2017/07/27 #}
                    {% elseif new.category == 'REPORT_LFC' %}
                        {# if role > 0 2018/10/07 #}
                        {# if enable_pay_user_menu #}
                        {% if enable_report_fc %}
                            {{ link_to('/report/fc/' ~ new.url_e, new.title_e, 'target': '_blank') }}
                        {% else %}
                            {{ new.title_e }}
                        {% endif %}
                    {# 2017/11/16 #}
                    {% elseif new.category == 'REPORT_GS' %}
                        {# if role > 0 2018/10/07 #}
                        {# if enable_pay_user_menu #}
                        {% if enable_report_gs %}
                            {{ link_to('/report/gs/' ~ new.url_e, new.title_e, 'target': '_blank') }}
                        {% else %}
                            {{ new.title_e }}
                        {% endif %}
                    {# 2018/05/04 #}
                    {% elseif new.category == 'REPORT_VA' %}
                        {# if report_va #}{# 2018/05/16 #}
                        {# if enable_pay_user_menu #}
                        {% if enable_report_va %}
                            {{ link_to('/report/va/' ~ new.url_e, new.title_e, 'target': '_blank') }}
                        {% else %}
                            {{ new.title_e }}
                        {% endif %}
                    {% elseif new.category == 'REPORT_RP' %}
                        {# if report_rp #}{# 2018/06/04 #}
                        {# if enable_pay_user_menu #}
                        {% if enable_report_rp %}
                            {{ link_to('/report/rp/' ~ new.url_e, new.title_e, 'target': '_blank') }}
                        {% else %}
                            {{ new.title_e }}
                        {% endif %}
                    {% elseif new.category == 'REPORT_O' %}
                        {# 2019/06/20 #}
                        {% if enable_report_misc %}
                            {{ link_to('/report/o/' ~ new.url_e, new.title_e, 'target': '_blank') }}
                        {% else %}
                            {{ new.title_e }}
                        {% endif %}
                    {% elseif new.category == 'MODEL' %}
                        {% if new.url_e is not empty %}
                            {{ link_to(new.url_e, new.title_e, 'target': '_blank', new.relativeFlag) }}
                        {% else %}
                            {{ new.title_e }}
                        {% endif %}
                    {% endif %}
                </td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>

</div>
