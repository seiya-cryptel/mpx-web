{# views/news/rp.volt #}
<div class="row">
<div class="col-xs-12 col-sm-10 col-sm-offset-1">
<ol class="breadcrumb">
	<li>{{ link_to('/index/e', 'Home') }}</li>
	<li class="active">MPX Market Risk Premium</li>
</ol>
</div>
</div>

<div class="row">
<div class="col-xs-12 col-sm-10 col-sm-offset-1">
<h2>MPX Market Risk Premium</h2>

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
                    {{ new.date_notice_dispe }}
                </td>
                <td>
                    {{ link_to('/report/rp/' ~ new.url_e, new.title_e, 'target': '_blank') }}
                </td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>

</div>