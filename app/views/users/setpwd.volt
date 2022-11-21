{# views/users/setpwd.volt #}

<div class="row">
            <div class="col-md-4 col-md-offset-4 mt30">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">パスワード設定</h3>
                    </div>
                    <div class="panel-body">
                        {{ form('users/setpwd') }}
                            <fieldset>
                                <div class="control-label">新しいパスワード</div>
                                {{ form.render('user_pwd1', ['class': "form-control input-sm", 'placeholder': "新しいパスワード"]) }}
                                <div class="control-label mt10">確認用パスワード</div>
                                {{ form.render('user_pwd2', ['class': "form-control input-sm", 'placeholder': "確認用パスワード"]) }}
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

