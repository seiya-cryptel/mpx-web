<?php use Phalcon\Tag; ?>
<?php
use Phalcon\Mvc\Url;
$url = new Url();
$url->setBaseUri('https://mpxstg.officeu.com/');
?>
<div class="row" style="margin:100px 10px 0;" id="left_content">
	<div class="container" style="width:350px;margin:0 auto;">
	  {{ flash.output() }}
	</div>
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{ description }}</h3>
            </div>
            <div class="panel-body">
                {{ form('upload/upload', 'method': 'post', 'enctype': 'multipart/form-data') }}
                    {{ hidden_field('targetDate', 'value': targetDate) }}
                    {{ hidden_field('dataType', 'value': datatype) }}
                    <fieldset>
                        <div class="form-group">
                            {{ file_field('uploadfile', 'class': "form-control", 'placeholder': "csv ファイル") }}
                        </div>
                        <!-- Change this to a button or input when using this as a form -->
                        {{ submit_button('アップロード', 'class': 'btn btn-lg btn-success btn-block') }}
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>