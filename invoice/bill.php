<html dir="rtl">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme/sb-admin")?>/css/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url("theme/sb-admin")?>/css/bootstrap.css">
<title>فاتورة</title>

</head>

<body>
<div id="contaner">
<div id="header">
<div id="title"> 
<h1>فاتورة مبيعات</h1>
</div>
<div id = "info" >
<p>
تاريخ الفاتورة  :<br>
رقم الفاتورة:<br>
تاريخ الطلب :
</p>
</div>
</div>
<div id="logo" >
<img src="<?php echo base_url("theme")?>/images/logo.png" />
</div>
<div id ="info2">
<span>&#1575;&#1604;&#1575;&#1587;&#1605;:<?php echo $rows['user_id']; ?> </span> <span>&#1585;&#1602;&#1605; &#1575;&#1604;&#1580;&#1608;&#1575;&#1604;</span> <span>&#1575;&#1604;&#1602;&#1587;&#1605;</span>

</div>

<div id="table">
 <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th><span lang="ar-sa">&#1585;&#1602;&#1605; &#1575;&#1604;&#1589;&#1606;&#1601;</span></th>
                                                <th><span lang="ar-sa">&#1575;&#1587;&#1605; &#1575;&#1604;&#1589;&#1606;&#1601;</span></th>
                                                <th><span lang="ar-sa">&#1575;&#1604;&#1603;&#1605;&#1610;&#1577;</span></th>
                                                <th><span lang="ar-sa">&#1587;&#1593;&#1585; 
												&#1575;&#1604;&#1608;&#1581;&#1583;&#1577;</span></th>
                                                <th><span lang="ar-sa">&#1575;&#1604;&#1605;&#1580;&#1605;&#1608;&#1593;</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $sum = 0; 
                                            foreach($bill as $store)
                                                 {
                                                    ?>
                                            <tr>
                                                <td><?php echo $store->product_id ; ?></td>
                                                <td><?php echo $store->name ; ?></td>
                                                <td>1</td>
                                                <td> <?php echo $store->price ; ?></td>
                                                <td><?php echo $store->price * 1; ?></td>
                                                <?php $sum=$sum + $store->price ?>
                                            </tr>
                                            <?php 
                                             }?>
                                           
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3">&nbsp;</th>
                                                <th><span lang="ar-sa">&#1575;&#1604;&#1605;&#1580;&#1605;&#1608;&#1593; 
												&#1575;&#1604;&#1603;&#1604;&#1610;</span></th>
                                                <th><?php echo $sum?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
</div>
<div id="contaner2">
<div id="cond">
<h3>&#1575;&#1604;&#1588;&#1585;&#1608;&#1591; &#1608;&#1575;&#1604;&#1578;&#1593;&#1604;&#1610;&#1605;&#1575;&#1578;:</h3>
<small>1-	????????? ??? ??? ????????.<br />
2-	?? ??? ??????? ??????????? ???? ??????<br />
3-	????????????? ?? ?????? ?? ????? ????? <br />???????????????? ?? ???? ????? ? ? ? ????? ?br />???????????? ??? ??????????<br />????? 1435-1436 ? .<br />
4-	??????????? ???????????? ? ?? .<br />
5-	?????????? ??? ? ????3 ?? ??????? ??? ???.<br />
6-	??? ?????? ? ?????????? ???? ????? ??? ???br />??  ?????????????????? . <br />
7-	?? ??? ??????????? ????? ??? ??? ?? ???. <br />
8-	??? ????? ? ???? ???? ????.<br />
9-	? ???? ?????????????????????? ????? ??? ?<br />??? ??????? ??  24 ?? ? ????  ? ? ??? <br />? ??? ?? ???????.<br />
</small>
</div>
<div id="money">
<h3>&#1585;&#1571;&#1610; &#1575;&#1604;&#1588;&#1572;&#1608;&#1606; &#1575;&#1604;&#1605;&#1575;&#1604;&#1610;&#1577; &#1608;&#1578;&#1608;&#1586;&#1610;&#1593; &#1575;&#1604;&#1571;&#1602;&#1587;&#1575;&#1591;</h3>
<table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>&#1575;&#1604;&#1602;&#1587;&#1591;</th>
                                                <th>&#1575;&#1604;&#1588;&#1607;&#1585;</th>
                                                <th>&#1605;&#1576;&#1604;&#1594; &#1575;&#1604;&#1578;&#1602;&#1587;&#1610;&#1591;</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>??????/td>
                                                <td></td>
                                                <td></td>
                                                                                           </tr>
                                            <tr>
                                                <td>??????</td>
                                                <td></td>
                                                <td></td>
                                                
                                            </tr>
                                            <tr>
                                                <td>??????</td>
                                                <td></td>
                                                <td></td>
                                                                                          </tr>
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="1">&nbsp;</th>
                                                <th><span lang="ar-sa">&#1575;&#1604;&#1605;&#1580;&#1605;&#1608;&#1593; 
												&#1575;&#1604;&#1603;&#1604;&#1610;</span></th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                                
<p></p>
</div>

</div>
</div>
<div id="footer">
????? ??? :  6313355  ???  516   -   ??? ????? : e-store@alaqsa.edu.sa </div>
</body>

</html>