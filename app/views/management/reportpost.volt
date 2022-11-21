<div class="container" style="width:350px;margin:0 auto;">
    {{ flash.output() }}
</div>

<div style="width:90%;max-width:1000px;padding:20px;margin:0 auto;"min-height: 0;margin-bottom:0;"id="left_content">
    <h2 style="padding:8px 8px 20px 20px;border-left: solid 8px #196c9e;border-bottom: solid 5px #196c9e;font-size: 20px;">レポート追加
    </h2>
</div>
<div style="clear:both;"></div>

<div style="width:65%;margin:0 auto;">

    {{ form("management/reportcreate", 'enctype': 'multipart/form-data', 'style': 'text-align: center; width: 100%; border-radius: 5px; border-color: #558cba;') }}
    {{ form.render('id') }}
    {{ form.render('url') }}

    <table border="1" style="width: 100%; padding: 15px; border-color: black;">
    <tr>　　　　　　　
        <td style="background-color: #558cba; color: white; padding:  7px; text-align: center; width: 40%;" >区分</td>　 
        <td style="padding: 10px;border: 1px solid #black;">
            {{ form.render('target_user', ['style': "text-align: center; width: 100%; border-radius: 5px; border-color: #558cba;"]) }}
        </td>　    
    </tr>
    
    <tr>　　　　　　　
        <td style="background-color: #558cba; color: white; padding:  7px; text-align: center; width: 40%;" >配信日</td>　 
        <td style="padding: 10px;border: 1px solid #black;">
            {{ form.render('date_notice', ['style': "text-align: center; width: 100%; border-radius: 5px; border-color: #558cba;"]) }}
        </td>　    
    </tr>

    <tr>　　　　　　　
        <td style="background-color: #558cba; color: white; padding:  7px; text-align: center; width: 40%;" >カテゴリ</td>　 
        <td style="padding: 10px;border: 1px solid #black;">
            {{ form.render('category', ['style': "text-align: center; width: 100%; border-radius: 5px; border-color: #558cba;"]) }}
        </td>　    
    </tr>　　　　　　 

    <tr>　　　　　　　
        <td style="background-color: #558cba; color: white; padding:  7px; text-align: center; width: 40%;" >タイトル</td>　 
        <td style="padding: 10px;border: 1px solid #black;">
            {{ form.render('title', ['style': "text-align: center; width: 100%; border-radius: 5px; border-color: #558cba;"]) }}
        </td>　    
    </tr>　　　　　　 

    {# 2020/01/30 #}
    <tr>
        <td style="background-color: #558cba; color: white; padding:  7px; text-align: center; width: 40%;" >タイトル 英語</td>　 
        <td style="padding: 10px;border: 1px solid #black;">
            {{ form.render('title_e', ['style': "text-align: center; width: 100%; border-radius: 5px; border-color: #558cba;"]) }}
        </td>　    
    </tr>　　　　　　 
    
    <tr>　　　　　　　
        <td style="background-color: #558cba; color: white; padding:  7px; text-align: center; width: 40%;" >レポートＰＤＦ</td>　 
        <td style="padding: 10px;border: 1px solid #black;">
            {{ form.render('uploadFile', ['style': "text-align: center; width: 100%; border-radius: 5px; border-color: #558cba;"]) }}
        </td>　    
    </tr>
    
    {# 2020/01/30 #}
    <tr>　　　　　　　
        <td style="background-color: #558cba; color: white; padding:  7px; text-align: center; width: 40%;" >レポートＰＤＦ 英文</td>　 
        <td style="padding: 10px;border: 1px solid #black;">
            {{ form.render('uploadFile_e', ['style': "text-align: center; width: 100%; border-radius: 5px; border-color: #558cba;"]) }}
        </td>　    
    </tr>

    <tr>
        <td style="background-color: #558cba; color: white; padding:  7px; text-align: center; width: 40%;" >公開</td>
        <td style="padding: 10px;border: 1px solid #black;">
            {{ form.render('publish', ['style': "text-align: center; width: 100%; border-radius: 5px; border-color: #558cba;"]) }}
        </td>　    
    </tr>


    <tr>
        <td style="background-color: #558cba; color: white; padding:  7px; text-align: center; width: 40%;" >有効</td>
        <td style="padding: 10px;border: 1px solid #black;">
            {{ form.render('isvalid', ['style': "text-align: center; width: 100%; border-radius: 5px; border-color: #558cba;"]) }}
        </td>　    
    </tr>
    </table>
</div>

<div style="margin: 0 auto; width:200px; margin-top: 20px;">
    {% if updateMode == 'new' %}
    {{ submit_button("追加", "style": "color: white; background-color: #558cba; padding: 6px 20px;border-radius: 7px; text-align: center;") }}
    {% else %}
    {{ submit_button("変更", "style": "color: white; background-color: #558cba; padding: 6px 20px;border-radius: 7px; text-align: center;") }}
    {% endif %}
    {{ link_to('management/', 'キャンセル', 'style': 'color: white; background-color: #558cba; padding: 6px 20px;border-radius: 7px; text-align: center;') }}
</div>
</form>
