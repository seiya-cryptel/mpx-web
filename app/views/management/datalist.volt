<div class="container" style="width:350px;margin:0 auto;">
    {{ flash.output() }}
</div>
<div style="width:90%;max-width:1000px;padding:20px;margin:0 auto;min-height: 0;margin-bottom:0;" id="left_content">
    <h2 style="padding:8px 8px 20px 20px;border-left: solid 8px #196c9e;border-bottom: solid 5px #196c9e;font-size: 20px;">格納データ一覧</h2>
</div>
<div style="clear:both;"></div>

<div style="width:70%;margin:0 auto;">

    {{ partial('shared/manageMenu') }}

    {{ form("management/datalist", 'style': 'text-align: center; width: 100%; border-radius: 5px; border-color: #558cba;') }}

        <div>
            <label>アップロード:</label>
            {{ form.render('upfrom', ['style': "text-align: center; width:15%; border-radius: 5px; border-color: #558cba;", 'placeholder': "日時"]) }}
            ~ 
            {{ form.render('upto', ['style': "text-align: center; width:15%; border-radius: 5px; border-color: #558cba;", 'placeholder': "日時"]) }}
            <label>配信日/セトルメント日:</label>
            {{ form.render('targetfrom', ['style': "text-align: center; width:15%; border-radius: 5px; border-color: #558cba;", 'placeholder': "日付"]) }}
            ~ 
            {{ form.render('targetto', ['style': "text-align: center; width:15%; border-radius: 5px; border-color: #558cba;", 'placeholder': "日付"]) }}
            {{ submit_button("検索", "style": "color: white; background-color: #558cba; padding: 6px 20px; width: 80px; border-radius: 7px; text-align: center; margin: right;") }}
            <label>メールアドレス:</label> 
            {{ form.render('email', ['style': "text-align: center; width:15%; border-radius: 5px; border-color: #558cba;", 'placeholder': "メールアドレス"]) }}
        </div>
    </form>
    <table id="example" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" style="margin: 0 auto;">
        <thead>
            <tr style="background-color: #558cba; color: white;">
                <th>アップロード日時</th>
                <th>配信／セトルメント</th>
                <th>メールアドレス</th>
                <th>データ種別</th>
                <th>削除</th>
                <th>編集</th>                
            </tr>
        </thead>
        <tbody>
            {% for upload in uploads %}
            <tr>
                <td>{{ upload.regdate }}</td>
                <td>{{ upload.target_date_disp }}</td>
                <td>{{ upload.user_id }}</td>
                <td>{{ upload.upload_type }}</td>
                <td>{{ upload.deleted }}</td>
                <td>
                    {# link_to('management/download/' ~ upload.id, 'ダウンロード', 'class': 'edit_user', 'target': '_blank') #}
                    {# link_to('management/datalistedit/' ~ upload.id, '編集', 'class': 'edit_user') 2018/11/01 #}
                </td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>
