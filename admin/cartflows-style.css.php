<?php if ( isset( $rebranding['plugin_name'] )  && !empty($rebranding['plugin_name']) ) { ?>
	span#footer-thankyou {
		display: none;
	}
	
<?php } ?>	

.wcf-button-wrap {
    margin-top: 0;
    position: absolute;
    top: 18px;
    left: calc(100% - 407px) !important;
}
.wrap h1.wp-heading-inline {
    width: calc(100% - 413px);
}
.wcf-template-logo-wrap > img {
    display: inline-block;
    vertical-align: middle;
}
.wcf-template-logo-wrap .wcf-cartflows-title {
    display: inline-block;
    vertical-align: middle;
}

/***media start***/
@media (max-width:850px){
	.wcf-button-wrap {
		left: auto;  !important;
		right: 0;
	}
	.wrap h1.wp-heading-inline {
		width: calc(100% - 114px);
	}	
}
