<style>
.section{
    margin-left: -20px;
    margin-right: -20px;
    font-family: "Raleway",san-serif;
}
.section h1{
    text-align: center;
    text-transform: uppercase;
    color: #808a97;
    font-size: 35px;
    font-weight: 700;
    line-height: normal;
    display: inline-block;
    width: 100%;
    margin: 50px 0 0;
}
.section ul{
    list-style-type: disc;
    padding-left: 15px;
}
.section:nth-child(even){
    background-color: #fff;
}
.section:nth-child(odd){
    background-color: #f1f1f1;
}
.section .section-title img{
    display: table-cell;
    vertical-align: middle;
    width: auto;
    margin-right: 15px;
}
.section h2,
.section h3 {
    display: inline-block;
    vertical-align: middle;
    padding: 0;
    font-size: 24px;
    font-weight: 700;
    color: #808a97;
    text-transform: uppercase;
}

.section .section-title h2{
    display: table-cell;
    vertical-align: middle;
    line-height: 25px;
}

.section-title{
    display: table;
}

.section h3 {
    font-size: 14px;
    line-height: 28px;
    margin-bottom: 0;
    display: block;
}

.section p{
    font-size: 13px;
    margin: 25px 0;
}
.section ul li{
    margin-bottom: 4px;
}
.landing-container{
    max-width: 750px;
    margin-left: auto;
    margin-right: auto;
    padding: 50px 0 30px;
}
.landing-container:after{
    display: block;
    clear: both;
    content: '';
}
.landing-container .col-1,
.landing-container .col-2{
    float: left;
    box-sizing: border-box;
    padding: 0 15px;
}
.landing-container .col-1 img{
    width: 100%;
}
.landing-container .col-1{
    width: 55%;
}
.landing-container .col-2{
    width: 45%;
}
.premium-cta{
    background-color: #808a97;
    color: #fff;
    border-radius: 6px;
    padding: 20px 15px;
}
.premium-cta:after{
    content: '';
    display: block;
    clear: both;
}
.premium-cta p{
    margin: 7px 0;
    font-size: 14px;
    font-weight: 500;
    display: inline-block;
    width: 60%;
}
.premium-cta a.button{
    border-radius: 6px;
    height: 60px;
    float: right;
    background: url(<?php echo YITH_WCCOS_ASSETS_URL?>/images/upgrade.png) #ff643f no-repeat 13px 13px;
    border-color: #ff643f;
    box-shadow: none;
    outline: none;
    color: #fff;
    position: relative;
    padding: 9px 50px 9px 70px;
}
.premium-cta a.button:hover,
.premium-cta a.button:active,
.premium-cta a.button:focus{
    color: #fff;
    background: url(<?php echo YITH_WCCOS_ASSETS_URL?>/images/upgrade.png) #971d00 no-repeat 13px 13px;
    border-color: #971d00;
    box-shadow: none;
    outline: none;
}
.premium-cta a.button:focus{
    top: 1px;
}
.premium-cta a.button span{
    line-height: 13px;
}
.premium-cta a.button .highlight{
    display: block;
    font-size: 20px;
    font-weight: 700;
    line-height: 20px;
}
.premium-cta .highlight{
    text-transform: uppercase;
    background: none;
    font-weight: 800;
    color: #fff;
}

.section.one{
    background: url(<?php echo YITH_WCCOS_ASSETS_URL?>/images/01-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.two{
    background: url(<?php echo YITH_WCCOS_ASSETS_URL?>/images/02-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.three{
    background: url(<?php echo YITH_WCCOS_ASSETS_URL?>/images/03-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.four{
    background: url(<?php echo YITH_WCCOS_ASSETS_URL?>/images/04-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.five{
    background: url(<?php echo YITH_WCCOS_ASSETS_URL?>/images/05-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.six{
    background: url(<?php echo YITH_WCCOS_ASSETS_URL?>/images/06-bg.png) no-repeat #fff; background-position: 85% 75%
}

@media (max-width: 768px) {
    .section{margin: 0}
    .premium-cta p{
        width: 100%;
    }
    .premium-cta{
        text-align: center;
    }
    .premium-cta a.button{
        float: none;
    }
}

@media (max-width: 480px){
    .wrap{
        margin-right: 0;
    }
    .section{
        margin: 0;
    }
    .landing-container .col-1,
    .landing-container .col-2{
        width: 100%;
        padding: 0 15px;
    }
    .section-odd .col-1 {
        float: left;
        margin-right: -100%;
    }
    .section-odd .col-2 {
        float: right;
        margin-top: 65%;
    }
}

@media (max-width: 320px){
    .premium-cta a.button{
        padding: 9px 20px 9px 70px;
    }

    .section .section-title img{
        display: none;
    }
}
</style>
<div class="landing">
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH WooCommerce Custom Order Status%2$s to benefit from all features!','yith-wccos'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-wccos');?></span>
                    <span><?php _e('to the premium version','yith-wccos');?></span>
                </a>
            </div>
        </div>
    </div>
    <div class="one section section-even clear">
        <h1><?php _e('Premium Features','yith-wccos');?></h1>
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCCOS_ASSETS_URL?>/images/01.png" alt="WooCommerce status" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCCOS_ASSETS_URL?>/images/01-icon.png" alt="icon 01"/>
                    <h2><?php _e('WooCommerce status ','yith-wccos');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('With the premium version of the plugin, all the %1$sWooCommerce order status%2$s can be overwritten. Customize them following your needs, and make the management of your orders more comfortable and functional to your business.', 'yith-wccos'), '<b>', '</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="two section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCCOS_ASSETS_URL?>/images/02-icon.png" alt="icon 02" />
                    <h2><?php _e('Icon or text?','yith-wccos');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('It is always hard to find quickly an order in a long list, especially if there are no identifying traits that make it stand from the other. With the %1$sYITH WooCommerce Custom Order Status%2$s plugin, you can assign an icon or a textual label to each orderstatus, choosing the color you want so that you can see them immediately.', 'yith-wccos'), '<b>', '</b>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCCOS_ASSETS_URL?>/images/02.png" alt="4 layouts" />
            </div>
        </div>
    </div>
    <div class="three section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCCOS_ASSETS_URL?>/images/03.png" alt="Actions" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCCOS_ASSETS_URL?>/images/03-icon.png" alt="icon 03" />
                    <h2><?php _e( 'Following actions ','yith-wccos');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('A list of actions you will be able to apply when the order will change its status. The premium version of the plugin offers you this too.%3$s%1$sCreate your logic sequence of actions%2$s and, with a simple click, your order will get the status you have indicated.', 'yith-wccos'), '<b>', '</b>','<br>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="four section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCCOS_ASSETS_URL?>/images/04-icon.png" alt="icon 04" />
                    <h2><?php _e('User interaction ','yith-wccos');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('For both WooCommerce order status and your customized ones, the plugin will let your users %1$scancel an order%2$s or %1$sdownload%2$s possible files depending on the selected order status.', 'yith-wccos'), '<b>', '</b>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCCOS_ASSETS_URL?>/images/04.png" alt="User interaction" />
            </div>
        </div>
    </div>
    <div class="five section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCCOS_ASSETS_URL?>/images/05.png" alt="Social network" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCCOS_ASSETS_URL?>/images/05-icon.png" alt="icon 05" />
                    <h2><?php _e('Report','yith-wccos');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('Who said that the %1$sWooCommerce report%2$s has to trace only the "Completed" orders? With a simple click, you can include also all the other orders with one or more status.Simple, useful and unique!','yith-wccos'),'<b>','</b>'); ?>
                </p>
            </div>
        </div>
    </div>
    <div class="six section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCCOS_ASSETS_URL?>/images/06-icon.png" alt="icon 06" />
                    <h2><?php _e('Customizable emails','yith-wccos');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __( 'Even the orders assigned to one of your customized status will generate an email for the %1$sadministrator%2$s and/or the %1$susers%2$s that have purchased.%3$sConfigure the settings in the related section, and your email will be ready in few steps.','yith-wccos' ),'<b>','</b>','<br>' ) ?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCCOS_ASSETS_URL?>/images/06.png" alt="Customizable emails" />
            </div>
        </div>
    </div>
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH WooCommerce Custom Order Status%2$s to benefit from all features!','yith-wccos'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-wccos');?></span>
                    <span><?php _e('to the premium version','yith-wccos');?></span>
                </a>
            </div>
        </div>
    </div>
</div>