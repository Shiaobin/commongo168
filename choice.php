<style>
.a_demo_five {
	background-color:#9827d3;
	width:220px;
	display:inline-block;
	font-family: 'Open Sans', sans-serif;
	font-size:16px;
	text-decoration:none;
	color:#fff;
	position:relative;
	margin-top:200px;
	margin-rigth:20px;
	margin-left:20px;
	padding-bottom:10px;
	padding-top:10px;
	background-image: linear-gradient(bottom, rgb(168,48,232) 100%, rgb(141,32,196) 0%);
	border-bottom-right-radius: 5px;
	border-bottom-left-radius: 5px;
	box-shadow: inset 0px 1px 0px #ca73f8, 0px 5px 0px 0px #6a1099, 0px 10px 5px #999;

}

.a_demo_five:active {
	top:3px;
	background-image: linear-gradient(bottom, rgb(168,48,232) 0%, rgb(141,32,196) 100%);
	box-shadow: inset 0px 4px 1px #7215a3, 0px 2px 0px 0px #6a1099, 0px 5px 3px #999;
}

.a_demo_five::before {
	background-color:#fff;
	background-image:url(images/reg.png);
	background-size:40px 40px;
	background-repeat:no-repeat;
	background-position:center center;
	border-left:solid 1px #CCC;
	border-top:solid 1px #CCC;
	border-right:solid 1px #CCC;
	content:"";
	width:218px;
	height:80px;
	position:absolute;
	top:-70px;
	left:0px;
	margin-top:-11px;
	z-index:-1;
	border-top-left-radius: 5px;
	border-top-right-radius: 5px;
}

.a_demo_five:active::before {
	top:-70px
	box-shadow: 0px 3px 0px #ccc;
}

.a_demo_six {
	background-color:rgba(44, 201, 38, 1);
	width:220px;
	display:inline-block;
	font-family: 'Open Sans', sans-serif;
	font-size:16px;
	text-decoration:none;
	color:#fff;
	position:relative;
	margin-top:200px;
	margin-rigth:20px;
	margin-left:20px;;
	padding-bottom:10px;
	padding-top:10px;
	background-image: linear-gradient(bottom, rgba(44, 201, 38, 1) 100%, rgba(44, 201, 38, 1) 0%);
	border-bottom-right-radius: 5px;
	border-bottom-left-radius: 5px;
	box-shadow: inset 0px 1px 0px rgba(44, 201, 38, 1), 0px 5px 0px 0px rgba(88, 150, 10, 50), 0px 10px 5px #999;

}

.a_demo_six:active {
	top:3px;
	background-image: linear-gradient(bottom, rgba(44, 201, 38, 1) 0%, rgba(44, 201, 38, 1) 100%);
	box-shadow: inset 0px 4px 1px rgba(44, 201, 38, 1), 0px 2px 0px 0px rgba(44, 201, 38, 1), 0px 5px 3px #999;
}

.a_demo_six::before {
	background-color:#fff;
	background-image:url(images/login.png);
	background-size:40px 40px;
	background-repeat:no-repeat;
	background-position:center center;
	border-left:solid 1px #CCC;
	border-top:solid 1px #CCC;
	border-right:solid 1px #CCC;
	content:"";
	width:218px;
	height:80px;
	position:absolute;
	top:-70px;
	left:0px;
	margin-top:-11px;
	z-index:-1;
	border-top-left-radius: 5px;
	border-top-right-radius: 5px;
}

.a_demo_six:active::before {
	top:-70px
	box-shadow: 0px 3px 0px #ccc;
}
p{font-family: "Helvetica Neue", Helvetica, Arial, "微軟正黑體", sans-serif;}
</style>

<center>
<p style="font-size:30px;">選擇購物身分</p>
<p>如已有帳號請選擇會員登入；若尚未成為會員請選擇快速註冊並購買。</p>
<a class="a_demo_five" href="quick_reg.php?go=order" target="_top">
                            快速註冊
                        </a>

<a class="a_demo_six" href="my_accounts.php?go=order" target="_top">
                            會員登入
                        </a>

</center>
