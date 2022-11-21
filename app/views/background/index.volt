{# views/background/index.volt #}
<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <ol class="breadcrumb">
                <li>{{ link_to('/', 'ホーム') }}</li>
                <li class="active">はじめに</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <h2>はじめに</h2>

        <div class="row">
            <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                  {{ flash.output() }}
            </div>
        </div>

        <p>三菱総合研究所は、欧州のクウォンツハウス“KYOS社”と共同で、日本市場向けの電力フォワードカーブモデルを開発しました。</p>
        <p>三菱総合研究所が持つ日本の電力市場に対する知見と、電力自由化で先行する欧州で培ったKYOS社のモデリング技術やソフトウエアを融合し、最高30分単位、最長3年先までの電力フォワードカーブを生成することが可能なモデルです。</p>
        <p>“MPX：MRI Power Price Index”は、この独自モデルを活用した、卸電力取引のためのオンライン情報サービスです。<br>
        卸電力市場に影響を及ぼす様々なファンダメンタルデータと、独自モデルで導いた電力フォワードカーブを、専用WEBサイト上で、ワンストップでご提供します。</p>
        <p>電力ビジネスにかかわるあらゆる企業にとって、卸電力市場の一層の活用は、安定的・持続的な事業運営のために不可欠です。</p>
        <p>弊社は、KYOS社と協力しつつ、上記の配信サービスを主軸に、卸電力取引に関連する多様なサービスをご提供し、お客様の電力ビジネスをご支援していく所存です。</p>

        {{ image('img/background_img.png', 'alt': 'MRI 日本の電力市場・政策に対する深い理解×KYOS　欧州市場で培ったモデルリング技術・ソフトウエア', "class": "center-block img-responsive page_images") }}
    </div>
</div>
