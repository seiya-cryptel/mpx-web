<div class="row">
<div class="col-xs-12 col-sm-10 col-sm-offset-1">
<ol class="breadcrumb">
	<li>{{ link_to('/', 'ホーム') }}</li>
	<li>{{ link_to('/news', 'お知らせ一覧') }}</li>
	<li class="active">お知らせ</li>
</ol>
</div>
</div>

<div class="row">
<div class="col-xs-12 col-sm-10 col-sm-offset-1">
<h2>お知らせ</h2>

<div class="row">
<div class="col-xs-12 col-sm-4 col-sm-offset-4">
      {{ flash.output() }}
</div>
</div>

<p class="news_title_txt">{{ news.title }}</p>
<p class="mt10">{{ news.date_notice_disp }}</p>
<div class="mt30">{{ news.content }}</div>
</div>

</div>