{# views/users/setpwd.volt #}

<div class="row">
            <div class="col-md-4 col-md-offset-4 mt30">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">プロファイル</h3>
                    </div>
                    <div class="panel-body">
                        {{ form('users/profile') }}
                            <fieldset>
                                <div class="control-label">メールアドレス</div>
                                {{ form.render('id', ['class': "form-control input-sm"]) }}
                                <div class="control-label mt10">ユーザID</div>
                                {{ form.render('user_nickname', ['class': "form-control input-sm"]) }}
                                <div class="control-label mt10">ユーザ名</div>
                                {{ form.render('user_name', ['class': "form-control input-sm"]) }}
                                <!-- Change this to a button or input when using this as a form -->
                                {{ submit_button('設定', 'class': 'btn btn-lg btn-success btn-block mt20') }}
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>

<div class="col-xs-12 col-sm-4 col-sm-offset-4">
      {{ flash.output() }}
</div>
        </div>
