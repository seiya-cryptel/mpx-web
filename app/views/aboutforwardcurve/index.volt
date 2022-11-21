{# views/aboutforwardcurve/index.volt #}
<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <ol class="breadcrumb">
                <li>{{ link_to('/', 'ホーム') }}</li>
                <li>基礎知識</li>
                <li class="active">電力フォワードカーブとは</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <h2>電力フォワードカーブとは</h2>

        <div class="row">
            <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                  {{ flash.output() }}
            </div>
        </div>

        <h3 class="sub_title">“電力フォワードカーブ”とは</h3>
        <p>将来の電力の受け渡しについて、現時点で約定する場合の価格を、将来の受け渡し期間毎に表した曲線です。<br>
        将来の卸電力価格に対する、現時点での平均的な見通しを表するものです。</p>
        {{ image('img/forward-curve_img_1.gif', "class": "center-block img-responsive page_images") }}

        <h3 class="sub_title_mt">卸電力価格はどのように決まるのか</h3>
        <p>卸電力価格は、時々刻々と変化する“需要”と“供給”のバランスによって決まります。<br>
        需要は、短期的には季節、曜日、時間帯や気象条件によって変化し、長期的には、人口動態や経済成長、省エネ・節電の進展などによって変化します。一方、供給は、短期的には、定期修繕やトラブルにともなう発電所の稼動・停止によって、長期的には、発電所の新設・廃止などによって変化します。<br>
        このように、“需要”、“供給”各々に影響を及ぼす様々なファンダメンタルの動きを織り込みつつ、卸電力価格は決まっています。</p>
        {{ image('img/forward-curve_img_2.jpg', "class": "center-block img-responsive page_images") }}

        <h3 class="sub_title_mt">何に利用するのか</h3>
        <h4 class="sub_title_blue">プライシング</h4>
        <p>需給バランスを踏まえた公正価格（フェアバリュー）を理解することは、卸電力取引の第一歩です。<br>
        電力フォワードカーブは、卸電力取引の公正価格を表す指標として、日本卸電力取引所（JEPX）で行われている“先渡取引”、将来上場が計画されている“先物取引”、取引所を介さない“相対取引”など、様々な卸電力取引のプライシングに利用されます。</p>

        <h4 class="sub_title_blue">プランニング</h4>
        <p>将来の電力価格に対する見通しなしに、電力ビジネスの計画を立てることは出来ません。<br>
        電力フォワードカーブは、発電所の定期修繕計画、稼動計画、それを踏まえた燃料の調達計画、外部電源の調達計画、これらを総括した経営計画などを立案する際、将来の卸電力価格に対する平均的な見通しを示す指標として利用されます。</p>

        <h4 class="sub_title_blue">リスクマネジメント</h4>
        <p>自社の保有ポジション（発電所、売買契約）の市場価値を把握することは、リスクマネジメントの第一歩です。<br>
        電力フォワードカーブは、将来の卸電力市場における保有ポジションの市場価値を表す指標として、その時価評価、リスク量の把握、これらを踏まえたヘッジ取引の判断に利用されます。</p>

        <h3 class="sub_title_mt">どのように作成するのか</h3>
        <p>一般的に、フォワードカーブを作成するためのモデルとして、“ファンダメンタルモデル”と“ヒストリカルモデル”の2つがあります。</p>
        {{ image('img/forward-curve_img_3.jpg', "class": "center-block img-responsive page_images_mb0") }}
        
        <p class="size_att">注1　発電プラントをコスト（限界費用）の安いものから順に稼動させること<br>
        注2　限界費用</p>
    </div>
</div>


