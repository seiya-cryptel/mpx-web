<div class="container" style="width:350px;margin:0 auto;">
    {{ flash.output() }}
</div>
<div style="width:60%;max-width:1000px;padding:20px;margin:0 auto;min-height: 0;margin-bottom:0;" id="left_content">
    <h2 style="padding:8px 8px 20px 20px;border-left: solid 8px #196c9e;border-bottom: solid 5px #196c9e;font-size: 20px;">アクセスログ一覧</h2>
</div>
<div style="clear:both;"></div>

<div style="width:70%;margin:0 auto;">
    {{ partial('shared/manageMenu') }}
    
{{ form("management/accesslog", 'style': 'text-align: center; width: 100%; border-radius: 5px; border-color: #558cba;') }}
    <div>
<label>日時:</label>
{{ form.render('dtfrom', ['style': "text-align: center; width:15%; border-radius: 5px; border-color: #558cba;", 'placeholder': "日時"]) }}
~ 
{{ form.render('dtto', ['style': "text-align: center; width:15%; border-radius: 5px; border-color: #558cba;", 'placeholder': "日時"]) }}
<label>メールアドレス:</label>
{{ form.render('email', ['style': "text-align: center; width:15%; border-radius: 5px; border-color: #558cba;", 'placeholder': "メールアドレス"]) }}
<label>ログ:</label>
{{ form.render('logtype', ['style': "text-align: center; width:15%; border-radius: 5px; border-color: #558cba;", 'placeholder': "ログ"]) }}
{{ submit_button("検索", "style": "color: white; background-color: #558cba; padding: 6px 20px; width: 80px; border-radius: 7px; text-align: center; margin: right; margin-left: 10px;") }}
    </div>
</form>
<table id="example" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" style="margin: 0 auto;">
        <thead>
            <tr style="background-color: #558cba; color: white;">
                <th>日時</th>
                <th>メールアドレス</th>
                <th>IP</th>
                <th>ログ</th>
                
            </tr>
        </thead>
        <tbody>
            {% for log in logs %}
            <tr>
                <td>{{ log.log_time }}</td>
                <td>{{ log.user_id }}</td>
                <td>{{ log.remote_addr }}</td>
                <td>{{ log.log_message }}</td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>
