	<style type="text/css">
			@media screen and (min-width:900px){
		        .no-pad{
		        	padding-right:0px;
		        }
		        .no-pad:nth-child(3){
		        	padding-right:15px;
		        }
			}
				*{
					margin:0px;
					padding:0px;
				}
				:root{
					--primary-color-1:<?php echo $primeColor; ?>;
					--sec-color:<?php echo $secondColor; ?>;
					--color-3:<?php echo $color3; ?>;
					--color-4:<?php echo $color4; ?>;
					--color-5:<?php echo $color5; ?>;
					--color-6:<?php echo $color6; ?>;
					--color-7:<?php echo $color7; ?>;
					--color-9:<?php echo $color9; ?>;
					--color-op-1:<?php echo $color7; ?>;
					--color-op-2:<?php echo $color7; ?>;
					--color-op-5:<?php echo $color8; ?>;
				}
				body{
					background: var(--sec-color);
				}
				header{
					background: var(--primary-color-1);
					height:50px;
				}
				header > ul{
					/*display: block;*/
					/*height: 50px*/
				}
				header > ul  li{
					float:left;
					list-style: none;
				}
				header > ul  li a{
					padding:15px 15px;
					font-size: 14px;
					display: block;
					color:var(--color-5);
					font-family: roboto;
				}
				header > ul  li a:hover{
					background:var(--primary-color-2);
					text-decoration: none;

				}
				footer{
					height:50px;
					background:var(--primary-color-1);
				}
				#banner-cont{
					background:var(--color-4);
				}
				#banner-cont .banner-item{
					min-height: 300px;
				}
				#banner-cont .owl-item .overlay-divider-right{
					background:-webkit-linear-gradient(left,transparent,var(--color-4));
					position:absolute;
					right:0px;
					width:20%;
					height:100%;
				
				}
				#banner-cont .owl-item  .overlay-divider-left{
					background:-webkit-linear-gradient(right,transparent,var(--color-4));
					position:absolute;
					left:0px;
					width:20%;
					height:100%;
				
				}
				.banner-overlay{
					position:absolute;
					bottom:0px;
					left:0px;
					width:100%;
					height:100%;
					background:-webkit-linear-gradient(top,transparent,var(--color-4));
					color:var(--color-6);
				}
				
				
				.nav-form-field-cont{
		            position:relative;
		            top: 13px;
		            display: inline-block;
				}
				.nav-form-field-cont input{
					background: var(--color-op-2);
					border:1px solid var(--color-op-1);
					padding:2px 8px;
					color:var(--color-touch-2);
					font-family: calibri
				}
				.nav-form-field-cont a{
					background: var(--color-op-5);
					padding:7px 8px 5px; 
					color:var(--sec-color);
					font-size: 12px;
				}
				.ppix{
					width:40px;
					height: 40px;
					border-radius: 50%;
					border:1px solid var(--sec-color);
					position:relative;
		            top: 5px;
				}
				#user-info-cont{
					float:right;position:relative;left:0px;
					background:var(--color-3) ;
					display: inline-block;
					padding:2px 20px 8px 10px;
				}
				#user-info-cont:hover{
					cursor: pointer;
				}
				#user-info-cont:active{
					background: rgba(0,0,0,0.9);
				}
				#user-info-cont li{
					
					display: block !important;
					clear:both;
				
				}
				#user-info-cont li a{
					
					display: block !important;
				
				}
				#user-info-cont img.ppix,#user-info-cont .udetail{
					float:left;
				}
				#user-info-cont img.ppix{
					margin-right:4px;
				}
				#user-info-cont .udetail{
					
				}
				#user-info-cont .udetail .uname{
					position: relative;
					top: 4px;
					color: var(--sec-color);
					font-weight: bold;
					font-family: dekko
				}
				#user-info-cont .udetail .uunit{
					font-size: 12px;
					font-family: play;
					color:var(--color-5);
					
				}
				.dropdown-menu{
					background:var(--color-3);
					padding-top:0px;
					margin:0px;
					border-top-left-radius: 0px;
					border-top-right-radius: 0px;

				}
				.dropdown-menu li a{
					color:var(--sec-color);
				}



				.col-inside{
					min-height: 360px;
					margin-top:10px;
					background:var(--color-4);
				}
				.col-inside .col-head{
					padding:10px 20px 0px;
					font-family: monda;
					color:var(--color-7);
				}
				.col-inside .col-body{
					padding:10px;
					font-family: roboto

				}
				.col-inside .col-footer{
					padding:10px;
				}

				.single-news-cont{
					border-bottom:1px solid #eaeaee;
					padding-bottom: 10px;
					margin-bottom: 20px;
					color:var(--color-9);
				}
				.single-news-cont:last-child{
					border-bottom:none;
				}
				.single-news-cont .news-img,.single-news-cont .news-text {
					float:left;
				}
				.single-news-cont .news-img{
					width:80px;
					height:80px;
					border:1px solid #dedede;
					margin-right: 4px;
				}
				.single-news-cont .news-text{
					width:210px;
					min-height:100px;
					/*border:1px solid #dedede;*/
					padding:0px 10px 10px;
					
				}
				.single-news-cont .news-text h5.news-head{
					padding:0px;
					margin:0px;
					font-weight: bold;
					
				}
				.single-news-cont .news-text .news-caption{
					font-size: 12px;
					font-family: roboto;
					
				}
				.col-body .cat-img{
					width: 100%;
					height:auto;

				}
				.col-body .cat-text{
					color:var(--color-7);
					
				}
				.col-body .cat-text .cat-head{
					padding:10px 0px 0px;
					font-weight: bold;
					font-family: play;
					font-size:16px;
					
				}
				.col-body .cat-text .cat-caption{
					font-size: 12px;
					font-family: roboto;
					
				}
				.col-footer .col-btn{
					border:1px solid var(--color-3);
					padding:10px 20px;
					display: inline-block;
					width: 49.2%;
					text-align: center;
				}
				.col-footer .col-btn:hover{
					text-decoration: none;
				}
				.col-footer .prime-btn{
					background: var(--color-3);
					color:var(--sec-color);
				}
				.col-footer .second-btn{
					background: -webkit-linear-gradient(top,#fff,#fff);
					/*border:1px solid var(--color-3);*/
					color:var(--color-3);
				}
				.form-field-cont{
					margin-bottom: 10px;
					width: 380px;
					background: var(--color-3);
					color: var(--sec-color);
					/*background: -webkit-linear-gradient(top,#ccc,#fff);*/
					border-bottom: 1px solid #ccc;
					border-left: 1px solid #ccc;
					position: relative;
					
				}
				.form-field-cont label{
					margin-right: 10px;
					float:left;
					position: relative;
					top: 10px;
					left: 10px;
					font-weight: normal;
					/*width: 80px;*/
					/*overflow-x: hidden;*/
				}
				.form-field-cont input,.form-field-cont select{
					padding:10px;
					float: right;
					width:270px;
					color: #555;
					border:1px solid #ccc;
					border-bottom: none;
					-webkit-appearance:none;
					-moz-appearance:none;
					appearance:none;
					
				}
				.form-field-cont .fancy-select:after{
					content: "\f104";
					font-family: ionicons;
					/*display: inline-block;*/
					/*height: 90px;
					width: 90px;*/
					position:absolute;
					right: 3px;
					top: 3px;
					background: var(--color-3);
					padding:8px 10px;
					color:var(--sec-color);
					pointer-events: none;
				}

				form button{
					padding:10px 20px;
					width: 188px;
					margin-top: 10px;
				}
				.default-message{
					font-size: 22px;
					font-weight: bold;
					color: #ccc;
					text-align: center;
					padding: 50px 20px;
				}
				
</style>