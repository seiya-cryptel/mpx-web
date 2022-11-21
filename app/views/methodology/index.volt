<div class="container" style="width:350px;margin:0 auto;">
    {{ flash.output() }}
</div>
<div style="width:90%;max-width:1000px;padding:20px;margin:0 auto;" id="left_content">
    <h2 style="padding:8px 8px 20px 20px;border-left: solid 8px #196c9e;border-bottom: solid 5px #196c9e;font-size: 20px;">MPXのアプローチ</h2>
    <p>MPXでは、日本の卸電力市場の現状を踏まえ、ファンダメンタル／ヒストリカル各々の利点を組合せてフォワードカーブを作成するユニークなアプローチを採用しています。</p>
    <br>
    {% set my_image = image('img/approach_of_mpx.png', 'class':'about_forwardcurve_img') %}
    {{ my_image }}
    <br>
    
    <h2 style="padding:8px 8px 20px 20px;border-left: solid 8px #196c9e;border-bottom: solid 5px #196c9e;font-size: 20px;">MPXのメソドロジー</h2>
    <p>需給環境の変化を反映するため、月平均価格をファンダメンタルモデルによって算定した上、ヒストリカルモデルで市場の値動きを反映しつつ、上記月平均価格を30分単位の価格に分解します。</p>
    <br>
    {% set my_image = image('img/methodology_of_mpx.png', 'class':'about_forwardcurve_img') %}
    {{ my_image }}
    <br>
    
    <h2 style="padding:8px 8px 20px 20px;border-left: solid 8px #196c9e;border-bottom: solid 5px #196c9e;font-size: 20px;">MPXの特徴</h2>
    <p>アプローチの詳細（各モデルの概要、ファンダメンタルモデルの入力データ）は、以下の通りです。</p>
    <br>
    {% set my_image = image('img/characteristic_of_mpx.png', 'class':'about_forwardcurve_img') %}
    {{ my_image }}
    <br>
    
    
</div>
<div style="clear:both;"></div>

