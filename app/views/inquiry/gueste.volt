<div class="row">
<div class="col-xs-12 col-sm-10 col-sm-offset-1">
<ol class="breadcrumb">
	<li>{{ link_to('/', 'Home') }}</li>
	<li class="active">Inquiries</li>
</ol>
</div>
</div>

<div class="row">
<div class="col-xs-12 col-sm-10 col-sm-offset-1">
<h2>Inquiries</h2>
        {% if mode == 'entry' %}
<p>Please fill out your inquiry and send it. We will reply by email later.</p>{# 2020/02/28 #}
        {% else %}
<p>Please confirm your information and submit.</p>
        {% endif %}
</div>
</div>

<div class="col-xs-12 col-sm-4 col-sm-offset-4">
      {{ flash.output() }}
</div>

<div class="row" id="inquiry_area">
<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3">
        {{ form('inquiry/gueste') }}
            <fieldset>
                {{ hidden_field('mode', 'value': mode) }}
		<span class="fontweight-bold">Your Name</span><span class="text_att">* Required</span>
                {{ form.render('guest_name', ['class': "form-control input-sm"]) }}
		<span class="fontweight-bold">Company Name</span><span class="text_att">* Required</span>
                {{ form.render('guest_corp', ['class': "form-control input-sm"]) }}
		<span class="fontweight-bold">Email Address</span><span class="text_att">* Required</span>{# 2020/02/28 #}
                {{ form.render('email1', ['class': "form-control input-sm"]) }}
		<span class="fontweight-bold">Email Address (re-enter)</span><span class="text_att">* Required</span>
                {{ form.render('email2', ['class': "form-control input-sm"]) }}
		<span class="fontweight-bold">Subject</span><span class="text_att">* Required</span>
                {{ form.render('subject', ['class': "form-control input-sm"]) }}
		<span class="fontweight-bold">Inquiries detail</span><span class="text_att">* Required</span>
                {{ form.render('body', ['class': "form-control input-sm", 'rows': '8']) }}

                {% if mode == 'entry' %}
                    {{ submit_button('Confirm', 'class': 'btn btn-lg btn-blue center-block') }}
                {% else %}
                    {{ submit_button('Submit', 'class': 'btn btn-lg btn-green center-block') }}
                {% endif %}
            </fieldset>
        </form>

</div>
</div>

</div>