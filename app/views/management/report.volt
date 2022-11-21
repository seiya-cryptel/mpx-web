<div class="container" style="width:350px;margin:0 auto;">
    {{ flash.output() }}
</div>
<div style="width:90%;max-width:1000px;padding:20px;margin:0 auto;min-height: 0;margin-bottom:0;" id="left_content">
    <h2 style="padding:8px 8px 20px 20px;border-left: solid 8px #196c9e;border-bottom: solid 5px #196c9e;font-size: 20px;">お知らせ一覧</h2>

    
    
</div>
<div style="clear:both;"></div>

<div style="width:70%;margin:0 auto;">
    {{ partial('shared/manageMenu') }}
<div>
    
{{ form("management/report", 'style': 'text-align: center; width: 100%; border-radius: 5px; border-color: #558cba;') }}
<label>配信日:</label>
{{ form.render('dtfrom', ['style': "text-align: center; width:15%; border-radius: 5px; border-color: #558cba;", 'placeholder': "日付"]) }}
~ 
{{ form.render('dtto', ['style': "text-align: center; width:15%; border-radius: 5px; border-color: #558cba;", 'placeholder': "日付"]) }}

{{ submit_button("検索", "style": "color: white; background-color: #558cba; padding: 6px 20px; width: 80px; border-radius: 7px; text-align: center; margin: right; margin-left: 10px;") }}
</form>

{# link_to('management/reportpost', '新規追加', 'style': 'color: white; background-color: #558cba; padding: 6px 20px; width: 100px; border-radius: 7px; text-align: center; margin-left: auto;') #}
{{ link_to('management/reportpost', '追加 更新', 'style': 'color: white; background-color: #558cba; padding: 6px 20px; width: 100px; border-radius: 7px; text-align: center; margin-left: auto;') }}

<table id="example" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%" style="margin: 0 auto;">
        <thead>
            <tr style="background-color: #558cba; color: white;">
                <th>配信日</th>
                <th>カテゴリ</th>
                <th>タイトル</th>
                <th>公開</th>
                <th>投稿日</th>
                <th>編集</th>                
            </tr>
        </thead>
        <tbody>
            {% for new in news %}
            <tr>
                <td>{{ new.date_notice_disp }}</td>
                <td>{{ new.category }}</td>
                <td>{{ new.title }}</td>
                <td>{{ new.publish_disp }}</td>
                <td>{{ new.regdate_datetime }}</td>
                <td>{{ link_to('management/newsedit/' ~ new.id, '編集', "class": "edit_user") }}</td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>
