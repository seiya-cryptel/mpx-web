<div class="row">
<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4 mt30">
<h1>パスワード再発行</h1>
<div>
      {{ flash.output() }}
</div>

      <div class="loginmodal-container" id="inquiry_area">
        {{ form('login/lostpwd') }}
            <fieldset>
		<span class="fontweight-bold">メールアドレス</span>
                {{ form.render('id', ['class': "form-control input-sm", 'placeholder': "メールアドレス"]) }}
		<span class="fontweight-bold">ユーザID</span>
                {{ form.render('user_nickname', ['class': "form-control input-sm", 'placeholder': "ユーザID"]) }}
                {{ submit_button('再発行', 'class': 'btn btn-lg btn-success btn-block mt20') }}
            </fieldset>
        </form>

      </div>
      </div>
    </div>