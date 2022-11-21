{# views/mpx/index.volt #}
<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <ol class="breadcrumb">
                <li>{{ link_to('/', 'ホーム') }}</li>
                <li>サービス</li>
                <li class="active">MPXの特徴</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <h2>MPXの特徴</h2>

        <div class="row">
            <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                  {{ flash.output() }}
            </div>
        </div>

        <p>MPXは、卸電力取引のための、オンライン情報サービスです。<br>
        卸電力取引に必要なあらゆるデータをタイムリーに収集・反映し、オランダのKYOS社と共同開発したモデルで導いた長期・高粒度のフォワードカーブを、バックデータ（ファンダメンタルデータ）とともにワンストップでご提供します。</p>

        <div class="btn_area">
            <ul>
            <li>{{ link_to('/mpx/#link01', '独自のアプローチ', 'class': "btn btn-green", 'role': "button") }}</li>
            <li>{{ link_to('/mpx/#link02', '最高30分単位×最長3年', 'class': "btn btn-green", 'role': "button") }}</li>
            <li>{{ link_to('/mpx/#link03', 'タイムリーなデータ更新', 'class': "btn btn-green", 'role': "button") }}</li>
            <li>{{ link_to('/mpx/#link04', '充実の機能', 'class': "btn btn-green", 'role': "button") }}</li>
            </ul>
        </div>

        <!-- 独自のアプローチ -->
        <h3 class="sub_title_mt" id="link01">独自のアプローチ</h3>
        <p>MPXモデルは、日本の特殊な市場環境を表現するため、“ファンダメンタルモデル”と“ヒストリカルモデル”各々の利点を組み合わせたユニークなモデルです。</p>

        <p>“ファンダメンタル・アプローチ”で月平均価格（Monthly）を算定することで、今後想定される需給環境の変化（例えば、原子力発電の再稼動）を電力フォワードカーブに反映します。</p>

        <p>さらに、“ヒストリカル・アプローチ”で月平均価格を、日平均価格（Daily）、30分単位の価格（Half Hourly）に展開することで、ファンダメンタルモデルだけでは表現しきれないデイタイプ（曜日・祝祭日・年中行事等）や時間帯毎の細かい価格変動を表現します。</p>
        {{ image('img/mpx_img_1.jpg', "class": "center-block img-responsive page_images") }}

        <!-- 最高30分×最長3年 -->
        <h3 class="sub_title_mt" id="link02">最高30分単位×最長3年間</h3>
        <p>電力取引を、日々の発電・小売のオペレーションと融合させるためには、長期にわたり、且つ高粒度の電力フォワードカーブが必要です。MPXでは、卸電力取引の最小単位である30分単位の電力フォワードカーブを生成し、一般に流動性の低い長期の取引も含めて配信します。</p>
        {{ image('img/mpx_img_2.jpg', "class": "center-block img-responsive page_images") }}

        <div class="btn_area_sample">
        {{ link_to('sample', 'サンプルはこちら', 'class': "btn btn-green", 'role': "button") }}
        </div>

        <!-- タイムリーな更新 -->
        <h3 class="sub_title_mt" id="link03">タイムリーなデータ更新</h3>
        <p>MPXでは、卸電力市場に影響を及ぼす様々なファンダメンタルデータを、タイムリーに収集・反映した電力フォワードカーブを配信します。</p>
        {{ image('img/mpx_img_3.jpg', "class": "center-block img-responsive page_images") }}
        <p class="size_att">注1　FOB価格からCIF価格や発電所炉前価格への変換、原油価格からLNG価格への変換など</p>

        <!-- 充実の機能 -->
        <h3 class="sub_title_mt" id="link04">充実の機能</h3>
        <p>MPXでは、お客様自らが、卸電力市場を分析するために必要な情報・機能をワンストップでご提供します。</p>

        <ul class="list_disc">
        <li class="mb10">直近のものだけでなく、過去にさかのぼって電力フォワードカーブを取得し、ヒストリカルな値動きの傾向を分析することが可能です。</li>
        <li class="mb10">電力フォワードカーブの作成に用いたバックデータ（ファンダメンタルデータ）も同様に、過去にさかのぼって取得することが可能です。</li>
        <li class="mb10">フォワードカーブ、バックデータともに、CSV形式でダウンロードし、相関関係などの分析に利用することが可能です。</li>
        <li>今後も、分析のために必要な情報やツールを、順次拡充していく予定です。</li>
        </ul>

    </div>
</div>
<!-- /row -->
