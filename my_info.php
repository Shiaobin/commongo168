<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="expires" content="0">
<?php include("indexconfig.php"); ?>
</head>
  <body>
    <div id="wrapper-box">
     <?php include("include/topmenu2.php"); ?>


<div id="header-box" class="row">
        <div class="jumbotron col-sm-10 col-sm-offset-1">
     <?php include("include/banner.php"); ?>

          <!--頁頭flash end.captioned-gallery-->
          <div class="jumbotron-box"><!-- 導覽列：會員登入前 -->
            <nav class="navbar navbar-default" role="navigation">
              <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <!-- <a class="navbar-brand" href="#">57</a>-->
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->

              </div><!-- /.container-fluid -->
            </nav>
          </div> <!-- end.jumbotron-box 導覽列：會員登入前-->

        </div>

        <!--頁頭flash end.jumbotron-->
          <ol class="breadcrumb col-sm-10 col-sm-offset-1" id="p_breadcrumb">
            <li class="font-small"><a href="index.php">首頁</a></li>
          <li class="font-small">會員專區</li>

          </ol>
        </div>

        <!-- end#header-box-->

      <div class="row" id="content-box">
        <div class="col-sm-8 col-sm-push-3 col-xs-12" id="content">
 <?php
if(isset($_SESSION['yuserid']) and $_SESSION['ypassword']){
echo "<table  class='table table-bordered table-striped'>
 <tr><th ><h4>
 會 員 中 心:&nbsp;&nbsp;";?>
<?php
include("Comm/m_menu.php");
 ?>
 </h4>
 </th></tr>
    </table>
      <?php
$userid=$_SESSION['yuserid'];
$password=$_SESSION['ypassword'];
$username=$_SESSION['username'];


$query="select * from usermain where UserId='".$userid."' and UserPassword='".$password."'";
$result=mysql_query($query, $webshop) or die("cannot connect to table" . mysql_error( ));
while($rs = mysql_fetch_array($result)){ ?>
<table  class='table table-bordered table-striped'>
<tr> <td>以下是您的個人資料，修改完成後單擊「確認修改」：</td></tr>

        <form name="myinfo" action="my_info_save.php" method="post">
        <tr>
            <td >姓名:<input type="text" name="Username" value="<?php echo $rs['UserName']; ?>"  class="sizeS" size="20" ></td>
        </tr>
	<tr>
            <td >密 碼:<input type="password" name="pw1" value="<?php echo $rs['UserPassword']; ?>" class="sizeS" size="20" ></td>
        </tr>

        <tr>
            <td >信 箱:<input type="text" name="UserMail" value="<?php echo $rs['UserMail']; ?>" class="sizeM" size="20" ></td>
        </tr>
		<tr>
            <td >LINE_ID:<input type="text" name="UserQQ" value="<?php echo $rs['UserQQ']; ?>" class="sizeS" size="20" ></td>
        </tr>
		<tr>
            <td >性 別:<input name="Sex" type="radio" value="1" <?php if($rs['Sex']==1) echo "checked"; ?>>男<input type="radio" name="Sex" value="0" <?php if($rs['Sex']==0) echo "checked"; ?>>女
        </td></tr>
		<tr>
            <td >婚 姻:<input name="MaritalStatus" type="radio" value="1" <?php if($rs['MaritalStatus']==1) echo "checked"; ?>>未婚<input type="radio" name="MaritalStatus" value="0" <?php if($rs['MaritalStatus']==0) echo "checked"; ?>>已婚
        </td></tr>
        <?php
		if(isset($rs['Birthday']) && $rs['Birthday']!="") $Date= $rs['Birthday'];
		else $Date=" "."-"." "."-"." ";
		$Ym=explode('-',$Date);
        $day=explode('-',$Ym[2]);
		?>

        <tr>
            <td >生 日:<input type="text" name="Birthday" value="<?php echo $Ym[0];?>" class="sizeSss" size="20" >年<select class="input-mini" name="D1">
  <option value="<?php echo $Ym[1];?>"><?php echo $Ym[1];?></option>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  </select>月<select class="input-mini" name="D2">
  <option value="<?php echo $day[0];?>"><?php echo $day[0];?></option>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15">15</option>
  <option value="16">16</option>
  <option value="17">17</option>
  <option value="18">18</option>
  <option value="19">19</option>
  <option value="20">20</option>
  <option value="21">21</option>
  <option value="22">22</option>
  <option value="23">23</option>
  <option value="24">24</option>
  <option value="25">25</option>
  <option value="26">26</option>
  <option value="27">27</option>
  <option value="28">28</option>
  <option value="29">29</option>
  <option value="30">30</option>
  <option value="31">31</option>
  </select>日</td>
        </tr>
<!--input type="hidden" name="IncomeRange" value="<%=rsinfo("IncomeRange")%>" class="sizeS" -->
        <tr>
            <td >職 業:<input type="text" name="Occupation" value="<?php echo $rs['Occupation']; ?>" class="sizeM" size="20" ></td>
        </tr>
        <tr>

            <td >公 司:<input type="text" name="CompanyName" value="<?php echo $rs['CompanyName']; ?>" class="sizeM" size="20" ></td>
        </tr>
        <tr>
            <td >電 話:<input type="text" name="HomePhone" value="<?php echo $rs['HomePhone']; ?>" class="sizeM" size="20" ></td>
        </tr>
        <tr>
            <td height="25" >手 機:<input type="text" name="CompPhone" value="<?php echo $rs['CompPhone']; ?>" class="sizeM" size="20" ></td>
        </tr>
        <tr>
            <td >地 址:<input type="text" name="Address" value="<?php echo $rs['Address']; ?>" class="sizeML" size="20" ></td>
        </tr>
        <tr>
            <td >郵遞區號:<input type="text" name="ZipCode" value="<?php echo $rs['ZipCode']; ?>" class="sizeSss" size="20" ></td>
        </tr>
		 <tr>
            <td >備 忘 錄:<br><TEXTAREA type="text" name="Memo"  ROWS="3" COLS="30"><?php echo $rs['Memo']; ?></TEXTAREA></td>
        </tr>
        <!--tr>
            <td >是否接收郵件通知:<?php if($rs['WantMessage']==1) ?><input name="WantMessage" type="radio" value="1" <?php if($rs['WantMessage']==1) echo "checked"; ?>>
            願意
            <input type="radio" name="WantMessage" value="0" <?php if($rs['WantMessage']==0) echo "checked"; ?>>
            暫時不要

       </td> </tr-->

 <tr> <td>
		  <input type="submit" name="Submit" value="確認修改">&nbsp;&nbsp;&nbsp;&nbsp;
          <input name="Submit2" type="reset" value="不做修改">
        </form>
	</td></tr> </table>
<?php
}
}else{
include("usererror.php");
}
?>

        </div><!--內容 end#content-->



       <div class="col-sm-2 col-sm-offset-1 col-sm-pull-8 col-xs-12" id="nav-box">
<?php include("include/leftmenu_comp.php"); ?>
          </div><!--導覽 end#nav-box-->
        </div><!--內容 end#content-box-->
     </div><!--頁尾以外 end#wrapper-box-->




<div id="footer-box">
      <div id="footer" class="row">
  <?php include("include/bottom.php"); ?>
      </div><!--頁尾 end#footer-->
    </div><!--頁尾 end#footer-box-->

 </body></html>