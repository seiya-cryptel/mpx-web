<div class="row">
<div class="col-xs-12 col-sm-10 col-sm-offset-1">
<ol class="breadcrumb">
	<li>{{ link_to('/', 'ホーム') }}</li>
	<li class="active">お問い合わせ</li>
</ol>
</div>
</div>

<div class="row">
<div class="col-xs-12 col-sm-10 col-sm-offset-1">
<h2>お問い合わせ</h2>
        {% if mode == 'entry' %}
            <p>ご質問や不具合報告などはMRIより直接回答させていただきます。以下のフォームから件名、お問い合わせ内容を記入して送信してください。MRIスタッフが調査し、メールにて回答させていただきます。</p>
            <p>また、電話によるお問い合わせも受け付けております。契約・サービス内容に関するお問い合わせは荒生宛に、システム・モデルに関するお問い合わせは土石川宛にご連絡ください。</p>
            <p>{#（電話番号：03-6386-8327）#}（電話番号：03-6386-8327）</p>
        {% else %}
<p>内容をご確認の上、送信をクリックしてください。</p>
        {% endif %}
</div>
</div>

<div class="col-xs-12 col-sm-4 col-sm-offset-4">
      {{ flash.output() }}
</div>

<div class="row" id="inquiry_area">
<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3">
        {{ form('inquiry/index') }}
            <fieldset>
                {{ hidden_field('mode', 'value': mode) }}
		<span class="fontweight-bold">件名</span><span class="text_att">※必須</span>
                {{ form.render('subject', ['class': "form-control input-sm"]) }}
		<span class="fontweight-bold">本文</span><span class="text_att">※必須</span>
                {{ form.render('body', ['class': "form-control input-sm", 'rows': '8']) }}

                {% if mode == 'entry' %}
                    {{ submit_button('確認', 'class': 'btn btn-lg btn-blue center-block') }}
                {% else %}
                    {{ submit_button('送信', 'class': 'btn btn-lg btn-green center-block') }}
                {% endif %}
            </fieldset>
        </form>

</div>
</div>

</div>
