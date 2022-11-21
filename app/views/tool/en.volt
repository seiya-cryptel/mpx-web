{# views/tools/index.volt #}
<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <ol class="breadcrumb">
            <li>{{ link_to('/', 'Home') }}</li>
            <li class="active">Analysis Tool</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <h2>Analysis Tool</h2>

        <div class="row">
            <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                {{ flash.output() }}
            </div>
        </div>

        <table id="example" class="table table-striped table-bordered table_tools">
        <thead>
            <tr class="table_tools_head">
                <th class="tool_name text-center" >Analysis Tool</th>
                <th class="nowrap">Version</th>
                <th class="nowrap">Update</th>
                <th class="nowrap">File size</th>
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
                <td class="text-center">{{ link_to('/tool/dl/' ~ tool.no ~ '/' ~ tool.encoded_path, '<span class="btn btn-info">Download</span>', 'target': '_blank') }}</td>
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
