{# views/service/index.volt #}
<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <ol class="breadcrumb">
                <li>{{ link_to('/', 'ホーム') }}</li>
                <li>サービス</li>
                <li class="active">サービスメニュー</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <h2>サービスメニュー</h2>

        <div class="row">
            <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                  {{ flash.output() }}
            </div>
        </div>

        <p>ご利用になる電力フォワードカーブの粒度などに応じて、以下の4つのプランをご用意しています。<br>
        取引市場での定型取引をお考えのお客様には、Aプラン、Bプランを、取引市場外（相対）での非定型取引もお考えのお客様や、小売事業・発電事業を行うお客様にはCプラン、Dプランをお奨めしています。</p>
        {{ image('img/service_img_1.jpg', "class": "center-block img-responsive page_images") }}

    </div>
</div>
<!-- /row -->
