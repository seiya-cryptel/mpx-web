<div class="container" style="width:350px;margin:0 auto;">
  {{ flash.output() }}
</div>
<div style="width:350px;margin:0 auto;" id="left_content">
    <div class="loginmodal-container">
        <h3 class="panel-title">Overlapped Login</h3><br>
        <p>{{ user_id }} was not previously logged out or is currently logged in on another terminal. </p>
        <p>Do you want to continue logging in?</p>

        {{ form('session/conflict') }}
        {{ submit_button('login', 'class':'btn btn-success btn-lg btn-block', 'value': 'login') }}
        {{ link_to('/index/e', 'cancel', 'class': 'btn btn-warning btn-lg btn-block') }}
        </form>
    </div>
</div>
<div style="clear:both;"></div>

