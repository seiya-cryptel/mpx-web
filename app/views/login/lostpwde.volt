<div class="row">
<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4 mt30">
<h1>Password Reissue</h1>
<div>
      {{ flash.output() }}
</div>

      <div class="loginmodal-container" id="inquiry_area">
        {{ form('login/lostpwd') }}
            <fieldset>
		<span class="fontweight-bold">Email Address</span>{# 2020/02/28 #}
                {{ form.render('id', ['class': "form-control input-sm", 'placeholder': "Email address"]) }}
		<span class="fontweight-bold">User ID</span>
                {{ form.render('user_nickname', ['class': "form-control input-sm", 'placeholder': "User ID"]) }}
                {{ submit_button('Apply Password Reissue', 'class': 'btn btn-lg btn-success btn-block mt20') }}
            </fieldset>
        </form>

      </div>
      </div>
    </div>