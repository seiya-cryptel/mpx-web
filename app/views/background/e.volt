{# views/background/e.volt #}

<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <ol class="breadcrumb">
                <li>{{ link_to('/index/e', 'Home') }}</li>
                <li class="active">Introduction</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <h2>Introduction</h2>

        <div class="row">
            <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                  {{ flash.output() }}
            </div>
        </div>

        <p>MPX, Inc. developed a proprietary model to produce Japan Power Forward Curve in cooperation with Kyos, a European quants- house.
            </p>
        <p>This model combined our expertise and intelligence in Japan’s power market with Kyos’ modeling technology and software well positioned in Europe, which preceded power market deregulation. It now brings about Japan Power Forward Curves by up to half-hourly intervals and up to 30 years forward.
            </p>
        <p>MPX is the online information service using this proprietary model to support power market trading. This web-based one-stop service provides various fundamental data that impacts wholesale power market, and the forward curve using our model.
            </p>
        <p>Wholesale trading does help many industries involved in power market for sustainable business administration.</p>
        <p>We will continue to suport international customers’ power market activities by delivering our service.</p>

        {{ image('img/backgrounde_img.png', 'alt': 'Deep understanding of Japan power market and energy policy<br>Modeling technology and software developed in Europe', "class": "center-block img-responsive page_images") }}
    </div>
</div>
