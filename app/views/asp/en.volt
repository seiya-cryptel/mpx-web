{# views/folder/index.volt #}

<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <ol class="breadcrumb">
            <li>{{ link_to('/', 'Home') }}</li>
            <li class="active">CSV Data Download for ASP User</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <h2>CSV Data Download for ASP User&nbsp;{{ path }}</h2>

        <div class="row">
            <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                {{ flash.output() }}
            </div>
        </div>

        <div class="row">
            <div class="col-xs-3 col-sm-2">{{ link_to('/asp/tope', '<i class="fas fa-angle-double-up">&nbsp;Top</i>') }}</div>
            <div class="col-xs-3 col-sm-2">{{ link_to('/asp/upe', '<i class="fas fa-angle-up">&nbsp;Up</i>') }}</div>
        </div>

        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table id="id_filelist" class="table table-striped table-bordered table_news">
                <thead>
                <tr>
                    <th style="text-align: center">Catergory</th>
                    <th style="text-align: center">Folder / File name</th>
                    <th style="text-align: center">File size</th>
                    <th style="text-align: center">Calculation date</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                {% for fileinfo in filelist %}
                <tr>
                    {% if fileinfo['type'] == 'dir' %}
                    <td style="text-align: center"><i class="fas fa-folder"></i></td>
                    <td>{{ link_to('/asp/foldere/' ~ (fileinfo['name']|url_encode), fileinfo['name']) }}</td>
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
