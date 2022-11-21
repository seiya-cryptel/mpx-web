{# views/news/rp.volt #}
<div class="row">
<div class="col-xs-12 col-sm-10 col-sm-offset-1">
<ol class="breadcrumb">
	<li>{{ link_to('/', 'ホーム') }}</li>
	<li class="active">MPXマーケットリスクプレミアム</li>
</ol>
</div>
</div>

<div class="row">
<div class="col-xs-12 col-sm-10 col-sm-offset-1">
<h2>MPXマーケットリスクプレミアム</h2>

<div class="row">
<div class="col-xs-12 col-sm-4 col-sm-offset-4">
      {{ flash.output() }}
</div>
</div>

    <table id="example" class="table table-striped table-bordered table_news">
        <thead>
            <tr class="table_news_head">
                <th class="nowrap">配信日時</th>
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
                    {{ link_to('/report/rp/' ~ new.url, new.title, 'target': '_blank') }}
                </td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>

</div>