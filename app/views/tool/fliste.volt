{# views/tools/index.volt #}
<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <ol class="breadcrumb">
            <li>{{ link_to('/', 'Home') }}</li>
            <li class="active">Analysis Data</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <h2>Analysis Data</h2>

        <div class="row">
            <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                {{ flash.output() }}
            </div>
        </div>

        <table id="example" class="table table-striped table-bordered table_tools">
        <thead>
            <tr class="table_tools_head">
                <th class="tool_name text-center" >Analysis Data</th>
                <th class="nowrap">File size</th>
                <th class="nowrap">Release Date</th>
                <th class="nowrap">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            {% for file in files %}
            <tr>
                <td style="color: blue"><span data-toggle="tooltip" data-placement="right" title="{{ file.description }}">{{ file.title }}</span></td>
                <td class="text-left">{{ file.filename }}</td>
                <td class="text-center">{{ file.upload_date }}&nbsp;<span class="label label_new">{{ file.newMark }}</span></td>
                <td class="text-center">{{ link_to('/tool/df/' ~ file.id, '<span class="btn btn-info">ダウンロード</span>', 'target': '_blank') }}</td>
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
