{# views/tools/index.volt #}
<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <ol class="breadcrumb">
            <li>{{ link_to('/', 'ホーム') }}</li>
            <li class="active">分析ツール</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <h2>分析ツール</h2>

        <div class="row">
            <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                {{ flash.output() }}
            </div>
        </div>

        <table id="example" class="table table-striped table-bordered table_tools">
        <thead>
            <tr class="table_tools_head">
                <th class="tool_name text-center" >分析ツール</th>
                <th class="nowrap">バージョン</th>
                <th class="nowrap">更新日</th>
                <th class="nowrap">ファイルサイズ</th>
                <th class="nowrap">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            {% for tool in tools %}
            <tr>
                <td style="color: blue"><span data-toggle="tooltip" data-placement="right" title="{{ tool.description }}">{{ tool.tool_name }}</span></td>
                <td class="text-center">{{ tool.version }}</td>
                <td class="text-center">{{ tool.update_date }}&nbsp;<span class="label label_new">{{ tool.newMark }}</span></td>
                <td class="text-right">{{ tool.file_size }}</td>
                <td class="text-center">{{ link_to('/tool/dl/' ~ tool.no ~ '/' ~ tool.encoded_path, '<span class="btn btn-info">ダウンロード</span>', 'target': '_blank') }}</td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>

</div>
        
<script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });
</script>
