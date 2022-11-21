{# management/updatedmail.volt #}

<div class="container" style="width:350px;margin:0 auto;">
    {{ flash.output() }}
</div>
<div style="width:90%;max-width:1000px;padding:20px;margin:0 auto;min-height: 0;margin-bottom:0;" id="left_content">
    <h2 style="padding:8px 8px 20px 20px;border-left: solid 8px #196c9e;border-bottom: solid 5px #196c9e;font-size: 20px;">更新メール送信</h2>
</div>
<div style="clear:both;"></div>

    {{ partial('shared/manageMenu') }}

    {{ form("management/updatedmail", 'enctype': 'multipart/form-data', 'style': 'text-align: center; width: 100%; border-radius: 5px; border-color: #558cba;') }}
    <input type="hidden" name="mode" id="mode" value="{{ mode }}" />
    <table border="1" style="width: 100%; padding: 15px; border-color: black;">

        <tr>　　　　　　　
            <td style="background-color: #558cba; color: white; padding:  7px; text-align: center; width: 40%;" >サブジェクト</td>　 
            <td style="padding: 10px;border: 1px solid #black;">
                {{ form.render('updatedsubj', ['style': "width: 100%; border-radius: 5px; border-color: #558cba;"]) }}
            </td>　    
        </tr>

        <tr>　　　　　　　
            <td style="background-color: #558cba; color: white; padding:  7px; text-align: center; width: 40%;" >本文</td>　 
            <td style="padding: 10px;border: 1px solid #black;">
                {{ form.render('updatedlist', ['style': "width: 100%; border-radius: 5px; border-color: #558cba;"]) }}
            </td>　    
        </tr>
        
        <tr>
            <td style="background-color: #558cba; color: white; padding:  7px; text-align: center; width: 40%;" ></td>
            <td style="padding: 10px;border: 1px solid #black;">
                {% if mode=='entry' %}
                    {{ form.render('submit', ['class': 'btn btn-lg btn-success btn-block']) }}
                {% else %}
                    {{ form.render('submit', ['class': 'btn btn-lg btn-warning btn-block']) }}
                {% endif %}
            </td>
        </tr>
    </form>
    </table>
</div>

