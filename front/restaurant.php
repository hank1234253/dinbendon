<?php
$sql="select * from `restaurant`";
$rows=$pdo->query($sql)->fetchAll(2);
?>
<button type="button" onclick="location.href='?do=add_restaurant'">新增餐廳</button>
<table>
    <tr>
        <td>序號</td>
        <td>餐廳</td>
        <td>圖片</td>
        <td>選擇</td>
    </tr>
<?php
foreach($rows as $idx => $row){   
?>
    <tr>
        <td><?=$idx+1?></td>
        <td><?=$row['name']?></td>
        <td>
        <?php
            if(file_exists("./img/{$row['img']}")){
                echo "<img src=\"./img/{$row['img']}\" alt=\"\">";
            }
            if(file_exists("./img/{$row['menu_img']}")){
                echo "<img src=\"./img/{$row['menu_img']}\" alt=\"\">";
            }
        ?>
        
        </td>
        <td><button type="button" onclick="location.href='?do=menu&id=<?=$row['id']?>'">選擇</button></td>
    </tr>
<?php
}
?>
</table>