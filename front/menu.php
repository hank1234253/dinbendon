<?php
    $sql="select * from `restaurant` where `id`='{$_GET['id']}'";
    $row=$pdo->query($sql)->fetch();
?>
<h2>menu</h2>
<p><?=$row['name']?></p>
<p><?=$row['img']?></p>
<p>地址:<?=$row['addr']?></p>
<p>電話:<?=$row['tel']?></p>
<table>
    <tr>
        <td>品項</td>
        <td>價格</td>
        <td>數量</td>
        <td>備註</td>
    </tr>
    <?php
        
    ?>
    <tr>

    </tr>
</table>
