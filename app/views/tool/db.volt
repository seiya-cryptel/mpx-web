{# views/tools/index.volt #}
<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <ol class="breadcrumb">
            <li>{{ link_to('/', 'ホーム') }}</li>
            <li class="active">ダウンロード</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <h2>ダウンロード</h2>

        <div class="row">
            <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                {{ flash.output() }}
            </div>
        </div>

        {{ dfile.title }}（{{ dfile.filename }}）
        {{ link_to('/tool/df/' ~ dfile.id, 'ダウンロード', 'class': 'btn btn-info btn-block', 'target': '_blank') }}

    </div>

</div>
