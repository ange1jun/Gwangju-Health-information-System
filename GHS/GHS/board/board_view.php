<!DOCTYPE html>
<html>    
<head>
<meta charset="utf-8">
<title> Gwangju Health Information </title>


<style>    
footer {
    position : fixed;
    bottom : 0;
    left: 0;
    bottom: 0;
    width: 100%;
    padding: 5px 0;
    text-align: center;
    color: white;
    background: brown;
    font-size:0.7em;
    
}
header{
    text-align: center;
    font-size: 35px;
    font-family: Arial;
    color: black;
    padding: 40px 40px;
    font-family: 'Kdam Thmor Pro', sans-serif;
}
body {
    background-color :	#FFE4E1;
}
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;    
}
li {
    float: right; 
}
li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none; 
}
li a:hover {
    background-color: #115;
}
.active {
    overflow: hidden;    
}
h3{
    color:gray;
}
#view_content{
    background-color:#FFE4E1;
}

#view_content .col1{
    padding:100;
    font-size:40px;
    border-bottom: solid 1px gray;
    background-color:#FFE4E1;
}
#view_content .col2{
    padding:100;
}
#view_button {
    background-color:#FFE4E1;
}

#REPLY_BOX {
    background-color:#FFE4E1;
    width:1841px;
    margin: top 100px;
    word-break:break-all;
}
#content_button{
    background-color:#FFE4E1;
}

#reply_BOX{
    background-color:#FFE4E1;
}
.reply_button {
    position: absolute;
    width: 100px;
    height:56px;
    font-size:16px;
    margin-left: 10px;
}

</style>
</head>
<body>
<header>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kdam+Thmor+Pro&display=swap" rel="stylesheet">    
<B> Gwangju Health Information System </b>
</header>
<ul>
<li><a class="active" href="../main.php">Home</a></li>
  <li><a class="active"  href="../login/logout.php">๋ก๊ทธ์์</a></li>
  <li><a class="active" href=""> ๋ง์ดํ์ด์ง </a></li>
  <li><a class="active" href= "../board/board_list.php"> ๊ฒ์ํ </a></li>
  <li><a class="active" href=""> ์ด๋์์ค </a></li>
  <li><a class="active" href="../location.php">์ฐพ์์ค์๋๊ธธ</a></li>
</ul>
</body>
<footer>
(์ฃผ) Gwangju Health System   / ๋ํ: ๊น๋ฒ์ค, ์?์ฑํ, ๋ฐ๋ฏผ์ฑ <br>
์ฃผ์: ์?๋ผ๋จ๋ ๊ด์ฃผ๊ด์ญ์ ๋จ๊ตฌ ํจ๋๋ก 277 ์?์ฐ๊ด ์ปดํจํฐ๊ณตํ๊ณผ์ค์ต์ค1004 <br>
์ฌ์์๋ฑ๋ก๋ฒํธ 685-86-00329 / ํต์?ํ๋งค์์?๊ณ?๋ฒํธ ์? 2022-์?๋จ๊ด์ฃผ-1004ํธ / <br> 
๋ฌธ์์?ํ๋ฒํธ : 1004-1004 (์ด์์๊ฐ ํ์ผ 10:00~17:30)<br>
๊ฐ์ธ์?๋ณด๊ด๋ฆฌ์ฑ์์ : ๊น๋ฒ์ค angel@naver.com<br><br>   
Copyright ยฉ 2022 GHS. All Rights Reserved.        
</footer>
</html>

<?php
    session_start();
    include "../lib/dbconn.php";
    include "../lib/global.php";
    
    $num = $_GET["num"];
    $page = $_GET["page"];

    $sql ="SELECT *
           FROM BOARD
           WHERE B_NUM = '$num'";

    $stid = oci_parse($conn, $sql);
    oci_execute($stid);

    $row = oci_fetch_array($stid);
    $subject     = $row[2];
    $content     = $row[3];    //1 ๊ธ์ด์ด //2์?๋ชฉ //3๋ด์ฉ 
    $nick        = $row[1];
    $regist_day    = $row[4];

    $content = str_replace(" ", "&nbsp;", $content);
	$content = str_replace("\n", "<br>", $content);

    // ์กฐํ์
	$sql = "UPDATE BOARD
            SET B_HIT = B_HIT + 1
            WHERE B_NUM = '$num'";   
	$stid = oci_parse($conn, $sql);
    
    oci_execute($stid);
    ?>

<ul id="view_content">
				<span class="col1"> <b> <?=$subject?></b><br></span>
				<span class="col2"><br><?=$content?></span>
                <span class="col3"><br><br><br><?=$regist_day?></span>
                <span class="col4"><?=$nick?>๋ ์์ฑ</span>

</ul>
<ul id="view_button" class="buttons">
<li><button onclick="location.href='board_list.php?page=<?=$page?>'">๋ชฉ๋ก</button></li>
<li><button onclick="location.href='board_modify_form.php?num=<?=$num?>&page=<?=$page?>'">์์?</button></li>
<li><button onclick="location.href='board_delete.php?num=<?=$num?>&page=<?=$page?>&userid=<?=$userid?>'">์ญ์?</button></li>
</ul>

<form name="REPLY" id="REPLY" method="post" action = "reply_write.php?num=<?=$num?>">
<span name="REPLY_">๋๊ธ๋ชฉ๋ก<br></span>
<input type="hidden" id = "RNO" name = "RNO">  
<input type="txt" id = "R_TXT" name = "R_TXT" placeholder="๋๊ธ์ ์๋?ฅํด ์ฃผ์ธ์.">
<button name = "reply_button" id="submit">๋ฑ๋ก</button>
</form>


<ul id=REPLY_BOX>
<span class="col1">๋ด์ฉ</span>
<span class="col2">์์ฑ์</span>
<span class="col3">๋ฑ๋ก์ผ</span>
<span class="col4">์ญ์?</span>
</ul>


<?php
    $sql = "SELECT * 
            FROM REPLY 
            WHERE RNO = '$num' 
            ORDER BY RNO DESC";
    $stid = oci_parse($conn, $sql);
	oci_execute($stid);

	while($row = oci_fetch_array($stid)) {
		$content= $row[1];				
		$regi_day= $row[2];				
		$num = $row[0];				
?>
	

<span class="col2"><?=$content?></span>
<span class="col3"><?=$regi_day?></span>
<button class="col4" onclick="location.href='reply_delete.php?num=<?=$num?>&page=<?=$page?>&id=<?=$id?>'">์ญ์?</button>
				 
<?php
	}
   oci_close($conn);

?>      
</ul>

