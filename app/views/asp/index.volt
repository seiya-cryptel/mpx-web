{# views/folder/index.volt #}

<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <ol class="breadcrumb">
            <li>{{ link_to('/', 'ホーム') }}</li>
            <li class="active">ASP用ファイル一覧</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <h2>ASP用ファイル一覧&nbsp;{{ path }}</h2>

        <div class="row">
            <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                {{ flash.output() }}
            </div>
        </div>

        <div class="row">
            <div class="col-xs-3 col-sm-2">{{ link_to('/asp/top', '<i class="fas fa-angle-double-up">&nbsp;トップ</i>') }}</div>
            <div class="col-xs-3 col-sm-2">{{ link_to('/asp/up', '<i class="fas fa-angle-up">&nbsp;上へ</i>') }}</div>
        </div>

        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table id="id_filelist" class="table table-striped table-bordered table_news">
                <thead>
                <tr>
                    <th style="text-align: center">種別</th>
                    <th style="text-align: center">フォルダ／ファイル名</th>
                    <th style="text-align: center">サイズ</th>
                    <th style="text-align: center">作成日時</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                {% for fileinfo in filelist %}
                <tr>
                    {% if fileinfo['type'] == 'dir' %}
                    <td style="text-align: center"><i class="fas fa-folder"></i></td>
                    <td>{{ link_to('/asp/folder/' ~ (fileinfo['name']|url_encode), fileinfo['name']) }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td style="text-align: center">{{ link_to('/asp/file/' ~ (fileinfo['name']|url_encode), 'Download', 'target': '_blank') }}</td>
                    {% else %}
                    <td style="text-align: center"><i class="far fa-file-alt"></i></td>
                    <td>{{ fileinfo['name'] }}</td>
                    <td style="text-align: right">{{ fileinfo['size'] }}</td>
                    <td>{{ fileinfo['datetime'] }}</td>
                    <td style="text-align: center">{{ link_to('/asp/file/' ~ (fileinfo['name']|url_encode), 'Download', 'target': '_blank') }}</td>
                    {% endif %}
                </tr>
                {% endfor %}
                </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
