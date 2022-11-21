{# views/index/e.volt #}

<!-- main_img -->
<div id="top_main_img">
    {{ image('img/top_slider_1e.jpg',  'srcset': '/img/top_slider_1e.jpg 1x,/img/top_slider_1e@2x.jpg 2x','class': 'topImg', 'alt': 'MPX – Online Information Service for Power Trading in Japan') }}
</div>
<!-- /main_img -->

<div class="row">
<div class="col-xs-12 col-sm-4 col-sm-offset-4">
      {{ flash.output() }}
</div>
</div>

<!-- contents_start -->
<div class="row">
<div class="col-xs-12 col-md-3">
<!-- twitte
<div class="explain_box" id="top_tweet_box">
<h1 class="top_news">Twitter</h1>
<a class="twitter-timeline"  href="https://twitter.com/MPXweb" data-widget-id="740140732653019138" width="100%" height="200" data-chrome="noheader nofooter noborders">@MPXwebさんのツイート</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>              
 /twitter -->

<!-- news -->
<div class="explain_box" id="top_news_box">
<h1 class="top_news">Notice</h1>

<!-- news_list -->
            <dl id="news_list">
            {% for new in news %}
                <dt>
                    {{ new.date_notice_disp }}
                    <span class="label label_new">{{ new.newMark }}</span>
                    {% if new.category == 'NEWS' %}
                        <span class="label label_news">News</span>
                    {% elseif new.category == 'REPORT_M' %}
                        <span class="label label_report">report</span>
                    {% elseif new.category == 'REPORT_W' %}
                        <span class="label label_report">report</span>
                    {# 2017/07/27 #}
                    {% elseif new.category == 'REPORT_LFC' %}
                        <span class="label label_report">report</span>
                    {# 2017/11/16 #}
                    {% elseif new.category == 'REPORT_GS' %}
                        <span class="label label_report">report</span>
                    {# 2018/05/04 #}
                    {% elseif new.category == 'REPORT_VA' %}
                        <span class="label label_report">report</span>
                    {% elseif new.category == 'REPORT_RP' %}
                        <span class="label label_report">report</span>
                    {% elseif new.category == 'MODEL' %}
                        <span class="label label_model">model</span>
                    {% endif %}
                </dt>
                <dd>
                {% if new.category == 'NEWS' %}
                    {% if new.url_e is not empty %}
                        {{ link_to(new.url_e, new.title_e, 'target': '_blank', new.relativeFlag) }}
                    {% else %}
                        {{ new.title_e }}
                    {% endif %}
                {% elseif new.category == 'REPORT_M' %}
                    {% if enable_report_monthly %}
                        {{ link_to('/report/m/' ~ new.url_e, new.title_e, 'target': '_blank') }}
                    {% else %}
                        {{ new.title_e }}
                    {% endif %}
                {% elseif new.category == 'REPORT_W' %}
                    {% if enable_report_weekly %}
                        {{ link_to('/report/w/' ~ new.url_e, new.title_e, 'target': '_blank') }}
                    {% else %}
                        {{ new.title_e }}
                    {% endif %}
                {% elseif new.category == 'REPORT_LFC' %}
                    {% if enable_report_fc %}
                        {{ link_to('/report/fc/' ~ new.url_e, new.title_e, 'target': '_blank') }}
                    {% else %}
                        {{ new.title_e }}
                    {% endif %}
                {% elseif new.category == 'REPORT_GS' %}
                    {% if enable_report_gs %}
                        {{ link_to('/report/gs/' ~ new.url_e, new.title_e, 'target': '_blank') }}
                    {% else %}
                        {{ new.title_e }}
                    {% endif %}
                {% elseif new.category == 'REPORT_VA' %}
                    {% if enable_report_va %}
                        {{ link_to('/report/va/' ~ new.url_e, new.title_e, 'target': '_blank') }}
                    {% else %}
                        {{ new.title_e }}
                    {% endif %}
                {% elseif new.category == 'REPORT_RP' %}
                    {% if enable_report_rp %}
                        {{ link_to('/report/rp/' ~ new.url_e, new.title_e, 'target': '_blank') }}
                    {% else %}
                        {{ new.title_e }}
                    {% endif %}
                {% elseif new.category == 'REPORT_O' %}
                    {% if enable_report_misc %}
                        {{ link_to('/report/o/' ~ new.url_e, new.title_e, 'target': '_blank') }}
                    {% else %}
                        {{ new.title_e }}
                    {% endif %}
                {% elseif new.category == 'MODEL' %}
                    {% if new.url is not empty %}
                        {{ link_to(new.url_e, new.title_e, 'target': '_blank', new.relativeFlag) }}
                    {% else %}
                        {{ new.title_e }}
                    {% endif %}
                {% endif %}
                </dd>
            {% endfor %}
            </dl>
            
<div class="link_news">{{ link_to('/news/en', 'View notice list<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>') }}</div>
</div>
</div>


<!--main -->
<div class="col-xs-12 col-md-9">
<!-- row_in -->
<div class="row">

<div class="col-xs-12 col-sm-4 topmenu_box">
<div class="explain_box">
<h1>Introduction</h1>
{{ image('img/top_box_1_e.png') }}
	<div class="explain_txt_area box_tile">
	<p>Introducing MPX's efforts regarding wholesale power trading.</p>
	</div>
<p class="top_btn_area">{{ link_to('background/e', 'See in detail', 'class': "btn btn-success") }}</p>
</div>
</div>

{#
<div class="col-xs-12 col-sm-4 topmenu_box">
<div class="explain_box">
<h1>What is a power forward curve</h1>
{{ image('img/top_box_2.jpg') }}
	<div class="explain_txt_area box_tile">
	<span class="label_box label_basic">Basic knowledge</span>
	<p>This section itroduces the outline of the power forward curve, general creation method, and usage.</p>
	</div>
<p class="top_btn_area">{{ link_to('aboutforwardcurve', 'See in detail', 'class': "btn btn-success") }}</p>
</div>
</div>
#}

<div class="col-xs-12 col-sm-4 topmenu_box">
<div class="explain_box">
<h1>Login</h1>
{{ image('img/top_box_login.jpg') }}
	<div class="explain_txt_area box_tile">　</div>
<p class="top_btn_area">{{ link_to('login/e', '<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>Login', 'class': "btn btn-success") }}</p>
</div>
</div>

{#
<div class="col-xs-12 col-sm-4 topmenu_box">
<div class="explain_box">
<h1>MPX features</h1>
{{ image('img/top_box_3.jpg') }}
	<div class="explain_txt_area box_tile"><span class="label_box label_service">service</span>
	<p>Introducing the features of the MPX model and the platform functions.</p>
    </div> 
<p class="top_btn_area">{{ link_to('mpx', 'See in detail', 'class': "btn btn-success") }}</p>
</div>
</div>

<div class="col-xs-12 col-sm-4 topmenu_box">
<div class="explain_box">
<h1>Servide menu</h1>
{{ image('img/top_box_4.jpg') }}
	<div class="explain_txt_area box_tile"><span class="label_box label_service">service</span>
	<p>MPX offers multiple service menus depending on the customer's usage.</p> 
    </div>
<p class="top_btn_area">{{ link_to('service', 'See in detail', 'class': "btn btn-success") }}</p>
</div>
</div>


<div class="col-xs-12 col-sm-4 topmenu_box">
<div class="explain_box">
<h1>Sample</h1>
 {{ image('img/top_box_sample.png') }}
	<div class="explain_txt_area box_tile">
    <span class="label_box label_service">service</span>
	<p>You can experience MPX functions and services.</p>
    </div>
<p class="top_btn_area">{{ link_to('sample', 'See in detail', 'class': "btn btn-success") }}</p>
</div>
</div>
#}

<div class="col-xs-12 col-sm-4 topmenu_box">
<div class="explain_box">
<h1>Inquiries</h1>{# 2020/02/08 #}
{{ image('img/top_box_7.jpg') }}
	<div class="explain_txt_area box_tile">　</div>
<p class="top_btn_area">{{ link_to('inquiry/gueste', 'Inquiries', 'class': "btn btn-success") }}</p>
</div>
</div>

</div>
<!-- /row_in -->


</div>
<!--/main -->

</div>
<!-- /row -->
<!-- contents_end -->
