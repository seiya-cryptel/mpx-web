<div class="container" style="width:350px;margin:0 auto;">
  {{ flash.output() }}
</div>
<div style="width:350px;margin:0 auto;" id="left_content">
    <div class="loginmodal-container">
        <h3 class="panel-title">重複ログイン確認</h3><br>
        <p>{{ user_id }} は、前回ログアウトされなかったか、または他の端末でログイン中です。</p>
        <p>ログイン処理を続行しますか？</p>

        {{ form('session/conflict') }}
        {# submit_button('login', 'class':'login loginmodal-submit', 'value': 'ログイン') #}
        {{ submit_button('login', 'class':'btn btn-success btn-lg btn-block', 'value': 'ログイン') }}
        {{ link_to('/', 'キャンセル', 'class': 'btn btn-warning btn-lg btn-block') }}
        </form>
    </div>
</div>
<div style="clear:both;"></div>

