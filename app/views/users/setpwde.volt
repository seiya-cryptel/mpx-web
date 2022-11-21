{# views/users/setpwd.volt #}

<div class="row">
            <div class="col-md-4 col-md-offset-4 mt30">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Change Password</h3>{# 2020/02/15 #}
                    </div>
                    <div class="panel-body">
                        {{ form('users/setpwde') }}
                            <fieldset>
                                <div class="control-label">New Password</div>
                                {{ form.render('user_pwd1', ['class': "form-control input-sm", 'placeholder': "New password"]) }}
                                <div class="control-label mt10">Re-enter password</div>
                                {{ form.render('user_pwd2', ['class': "form-control input-sm", 'placeholder': "Re-enter password"]) }}
                                <!-- Change this to a button or input when using this as a form -->
                                {{ submit_button('Submit', 'class': 'btn btn-lg btn-success btn-block mt20') }}
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
<div class="col-xs-12 col-sm-4 col-sm-offset-4">
      {{ flash.output() }}
</div>
        </div>

