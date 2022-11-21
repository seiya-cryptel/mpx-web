<div class="container" style="width:350px;margin:0 auto;">
    {{ flash.output() }}
</div>
<div style="width:90%;max-width:1000px;padding:20px;margin:0 auto;min-height: 0;margin-bottom:0;" id="left_content">
    <h2 style="padding:8px 8px 20px 20px;border-left: solid 8px #196c9e;border-bottom: solid 5px #196c9e;font-size: 20px;">ユーザー一覧</h2>

    
    
</div>
<div style="clear:both;"></div>

<div style="width:70%;margin:0 auto;">
    
    {{ partial('shared/manageMenu') }}
    
    {{ link_to('management/useradd', '新規追加', 'style': 'color: white; background-color: #558cba; padding: 6px 20px; width: 100px; border-radius: 7px; text-align: center; margin-left: auto;') }}
    <table id="example" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" style="margin: 0 auto;">
        <thead>
            <tr style="background-color: #558cba; color: white;">
                <th>会社名</th>
                <th>メールアドレス</th>
                <th>ユーザーネーム</th>
                <th>ユーザー種別</th>
                <th>有効期限開始</th>
                <th>有効期限終了</th>
                <th>有効</th>
                <th>編集</th>
            </tr>
        </thead>
        <tbody>
            {% for user in users %}
            <tr>
                <td>{{ user.user_name }}</td>
                <td>{{ user.id }}</td>
                <td>{{ user.user_nickname }}</td>
                <td>{{ user.user_type_disp }}</td>
                <td>{{ user.valid_from_disp }}</td>
                <td>{{ user.valid_from_disp }}</td>
                <td>{{ user.isvalid_disp }}</td>
                <td>{{ link_to('management/useredit/' ~ user.id, '編集', "class": "edit_user") }}</td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>
        