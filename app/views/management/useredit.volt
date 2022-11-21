{# views/management/useredit.volt #}
<div class="container" style="width:350px;margin:0 auto;">
    {{ flash.output() }}
</div>
<div style="width:90%;max-width:1000px;padding:20px;margin:0 auto;"min-height: 0;margin-bottom:0;"id="left_content">
    <h2 style="padding:8px 8px 20px 20px;border-left: solid 8px #196c9e;border-bottom: solid 5px #196c9e;font-size: 20px;">ユーザー編集</h2>

    
    
</div>
<div style="clear:both;"></div>

<div style="width:65%;margin:0 auto;">

{% if updateMode == 'new' %}
    {{ form("management/usercreate", 'style': 'text-align: center; width: 100%; border-radius: 5px; border-color: #558cba;') }}
{% else %}
    {{ form("management/usersave", 'style': 'text-align: center; width: 100%; border-radius: 5px; border-color: #558cba;') }}
{% endif %}
<table border="1" style="width: 100%; padding: 15px; border-color: black;">
<tr>　　　　　　　
<td style="background-color: #558cba; color: white; padding:  7px; text-align: center; width: 40%;" >会社名</td>　 
<td style="padding: 10px;border: 1px solid #black;">
    {{ form.render('user_name', ['style': "text-align: center; width: 100%; border-radius: 5px; border-color: #558cba;"]) }}
</td>　    
</tr>

<tr>　　　　　　　
<td style="background-color: #558cba; color: white; padding:  7px; text-align: center; width: 40%;" >メールアドレス</td>　 
<td style="padding: 10px;border: 1px solid #black;">
    {{ form.render('id', ['style': "text-align: center; width: 100%; border-radius: 5px; border-color: #558cba;"]) }}
</td>　    
</tr>　　　　　　 

<tr>
<td style="background-color: #558cba; color: white; padding:  7px; text-align: center; width: 40%;" >ユーザネーム</td>
<td style="padding: 10px;border: 1px solid #black;">
    {{ form.render('user_nickname', ['style': "text-align: center; width: 100%; border-radius: 5px; border-color: #558cba;"]) }}
</td>
</tr>


<tr>
<td style="background-color: #558cba; color: white; padding:  7px; text-align: center; width: 40%;" >ユーザ種別</td>
<td style="padding: 10px;border: 1px solid #black;">
    {{ form.render('user_type', ['style': "width: 50%;"]) }}
</td>
</tr>


<tr>
<td style="background-color: #558cba; color: white; padding:  7px; text-align: center; width: 40%;" >有効期限開始</td>
<td style="padding: 10px;border: 1px solid #black;">
    {{ form.render('valid_from', ['style': "text-align: center; width: 100%; border-radius: 5px; border-color: #558cba;"]) }}
</td>　    
</tr>


<tr>
<td style="background-color: #558cba; color: white; padding:  7px; text-align: center; width: 40%;" >有効期限終了</td>
<td style="padding: 10px;border: 1px solid #black;">
    {{ form.render('valid_to', ['style': "text-align: center; width: 100%; border-radius: 5px; border-color: #558cba;"]) }}
</td>　    
</tr>


<tr>
<td style="background-color: #558cba; color: white; padding:  7px; text-align: center; width: 40%;" >有効</td>
<td>
{{ form.render('isvalid') }}有効にする
</td>
</tr>
</table>
</div>

<div style="margin: 0 auto; width:200px; margin-top: 20px;">
            {{ submit_button("変更", "style": "color: white; background-color: #558cba; padding: 6px 20px;border-radius: 7px; text-align: center;") }}
            {{ link_to('management/', 'キャンセル', 'style': 'color: white; background-color: #558cba; padding: 6px 20px;border-radius: 7px; text-align: center;') }}
</div>
</form>
