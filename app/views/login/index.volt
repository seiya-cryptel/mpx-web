<div class="row">
<div class="col-md-4 col-md-offset-4 mt30">
	<div class="login-panel panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">ログイン</h3>
	</div>
	<div class="panel-body">
        {{ form('session/start') }} 
	<div class="control-label">メールアドレス</div>
        {{ text_field('id', 'placeholder': 'メールアドレス', 'class':'form-control') }}
	<div class="control-label mt10">パスワード</div>
        {{ password_field('pwd', 'placeholder': 'パスワード', 'class':'form-control') }}
        {{ submit_button('login', 'class':'btn btn-info btn-block mt30', 'value': 'ログイン') }}
        </form>
        </div>
	<div class="panel-footer">
        <div class="login-help">
            {{ link_to('login/lostpwd', 'パスワード再発行') }}
        </div>
	</div>
	</div>
</div>

<div class="col-xs-12 col-sm-4 col-sm-offset-4">
      {{ flash.output() }}
</div>
        </div>


