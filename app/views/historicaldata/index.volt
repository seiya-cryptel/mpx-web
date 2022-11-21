<?php

use Phalcon\Tag; ?>
<?php
use Phalcon\Mvc\Url;
$url = new Url();
$url->setBaseUri('http://jpfc.officeu.com/');
?>

<div id="left_content">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#spot_trading" data-toggle="tab" role="tab">JEPXスポット取引情報</a></li>
        <li><a href="#daily_index" data-toggle="tab" role="tab">JEPXインデックス</a></li>
        <li><a href="#coal" data-toggle="tab" role="tab">原油先物</a></li>
        <li><a href="#oil" data-toggle="tab" role="tab">石炭先物</a></li>
        <li><a href="#exchange" data-toggle="tab" role="tab">為替</a></li>
    </ul>


    <div id="tabContent2" class="tab-content">


        <!-- JEPXスポット取引情報 -->
        <div class="tab-pane fade in active" id="spot_trading">
            <h2>JEPXスポット取引情報</h2>
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#spot" data-toggle="tab" role="tab">{{ spot_upload_date }}受渡分</a></li>
                <li><a href="#spot_all" data-toggle="tab" role="tab">全履歴</a></li>
            </ul>
            <div id="tabContent" class="tab-content">
                <!-- JEPXスポット取引情報 日時 -->
                <div class="tab-pane fade in active" id="spot">
                    <div style="position:relative;width:100%;padding-bottom:20px;height:42px;">

                        <div style="position:absolute;top:10px;left:20px;">
                        <?php echo Tag::form(
                            array(
                                "historicaldata",
                                "id" => "calendar"
                        )); ?>
                            <ul>
                                <label for="date" accesskey="n">日付:</label>
                                <input name="day" id="date" maxlength="10" type="text" readonly="readonly">

                                <?=$this->tag->submitButton("表示") ?>
                            </ul>
                            </form>
                        </div>

                        <!--

                        <div style="position:absolute;top:10px;right:20px;">
                                <?php echo Tag::form("forwardcurve"); ?>
                                    <?php echo $this->tag->hiddenField(array(
                                        "download"
                                    )) ?>
                                <input type="hidden" name="day" value="{{ day }}">
                                <button type="submit" class="btn btn-primary">ダウンロード</button>
                            </form>
                        </div>
                        -->
                    </div>
                    <div id="chartdiv_spot" class="chartdiv_spot"></div>
                    <p>出所）<a class="source" href="http://www.jepx.org/market/index.html">日本卸電力取引所（JEPX）</a></p>
                    <p>注：MPXのウェブサイト上にあるすべてのデータは参考価格としての利用を前提としており、営利目的で第三者に再送するために一部でもコピーや表示することを禁止いたします。</p>
                </div>

                <!-- JEPXスポット取引情報 全履歴 -->
                <div class="tab-pane fade" id="spot_all">
                    <div style="position:relative;width:100%;padding-bottom:20px;height:42px;">


                        <!--
                        <div style="position:absolute;top:10px;right:20px;">
                                <?php echo Tag::form("forwardcurve"); ?>
                                    <?php echo $this->tag->hiddenField(array(
                                        "download"
                                    )) ?>
                                <input type="hidden" name="day" value="{{ day }}">
                                <button type="submit" class="btn btn-primary">ダウンロード</button>
                            </form>
                        </div>
                        -->
                    </div>
                    <div id="chartdiv_spot_all" class="chartdiv_spot"></div>                     
                    <p>出所）<a class="source" href="http://www.jepx.org/market/index.html">日本卸電力取引所（JEPX）</a></p>
                    <p>注：MPXのウェブサイト上にあるすべてのデータは参考価格としての利用を前提としており、営利目的で第三者に再送するために一部でもコピーや表示することを禁止いたします。</p>
                </div>

            </div>       

        </div>


        <!-- JEPX日時インデックス -->
        <div class="tab-pane fade" id="daily_index">
            <h2>JEPXインデックス</h2>
            <div style="position:relative;width:100%;padding-bottom:20px;height:42px;">

            </div>
            <div id="chartdiv_index"></div>

            <ul>
                <div style="width: 50%;height:30px;float:left;">
                    <div style="width: 350px;margin:0 auto;">
                        <div style="margin-right:10px;margin-top:5px;float:left;border-radius:50%;height:10px;width:10px;background:orange;"></div>
                        <li style="float:left;">TTV 1日に約定された電力の総量</li>
                    </div>
                </div>

                <div style="width: 50%;height:30px;float:left;">
                    <div style="width: 350px;margin:0 auto;">
                        <div style="margin-right:10px;margin-top:5px;float:left;border-radius:50%;height:10px;width:10px;background:rgb(103, 183, 220);;"></div>
                        <li style="float:left;">DA-24 24時間のシステムプライスの平均値</li>
                    </div>
                </div>

                <div style="width: 50%;height:30px;float:left;">
                    <div style="width: 350px;margin:0 auto;">
                        <div style="margin-right:10px;margin-top:5px;float:left;border-radius:50%;height:10px;width:10px;background:rgb(253, 212, 0);"></div>
                        <li style="float:left;">DA-DT 8:00-22:00のシステムプライスの平均値</li>
                    </div>
                </div>

                <div style="width: 50%;height:30px;float:left;">
                    <div style="width: 350px;margin:0 auto;">
                        <div style="margin-right:10px;margin-top:5px;float:left;border-radius:50%;height:10px;width:10px;background:rgb(132, 183, 97);"></div>
                        <li style="float:left;">DA-PT 13:00-16:00のシステムプライスの平均値</li>
                    </div>
                </div>
            </ul>
            <div style="clear:both;"></div>
            <p>出所）<a class="source" href="http://www.jepx.org/market/index.html">日本卸電力取引所（JEPX）</a></p>
            <p>注：MPXのウェブサイト上にあるすべてのデータは参考価格としての利用を前提としており、営利目的で第三者に再送するために一部でもコピーや表示することを禁止いたします。</p>
        </div>

        <!-- 原油先物 -->
        <div class="tab-pane fade" id="coal">
            <h2>原油先物 {{ subs_upload_date }} 配信</h2> 
            <div id="chartdiv_oil" class="chartdiv_hst_cme"></div>
            <p>出所）<a class="source" href="http://www.cmegroup.com/trading/energy/coal/coal-api-5-fob-newcastle-argus-mccloskey.html">CME Group</a></p>
            <p>直近年と翌年以降３年分の各限月（横軸）のセトルメント価格を表示しています。</p>
            <p>注：MPXのウェブサイト上にあるすべてのデータは参考価格としての利用を前提としており、営利目的で第三者に再送するために一部でもコピーや表示することを禁止いたします。</p>
        </div>

        <!-- 石炭先物 -->
        <div class="tab-pane fade" id="oil">
            <h2>石炭先物 {{ subs_upload_date }} 配信</h2>
            <div id="chartdiv_coal" class="chartdiv_hst_cme"></div>
            <p>出所）<a class="source" href="http://www.cmegroup.com/trading/energy/crude-oil/dubai-crude-oil-calendar-swap-futures.html">CME Group</a></p>
            <p>直近年と翌年分の各限月（横軸）のセトルメント価格を表示しています。</p>
            <p>注：MPXのウェブサイト上にあるすべてのデータは参考価格としての利用を前提としており、営利目的で第三者に再送するために一部でもコピーや表示することを禁止いたします。</p>
        </div>

        <!-- 為替 -->
        <div class="tab-pane fade" id="exchange">
            <h2>為替 {{ subs_upload_date }} 配信</h2>
            <div id="chartdiv_exchange" class="chartdiv_hst_cme"></div>
            <p>出所）<a class="source" href="http://www.cmegroup.com/trading/fx/g10/japanese-yen.html">CME Group</a></p>
            <p>四半期毎の20か月分の各限月（横軸）のセトルメント価格を表示しています。</p>
            <p>注：MPXのウェブサイト上にあるすべてのデータは参考価格としての利用を前提としており、営利目的で第三者に再送するために一部でもコピーや表示することを禁止いたします。</p>
        </div>

    </div>
</div>

