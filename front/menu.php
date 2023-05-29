<?php
$sql = "select * from `restaurant` where `id`='{$_GET['id']}'";
$row = $pdo->query($sql)->fetch();
?>
<h2>menu</h2>
<p><?= $row['name'] ?></p>
<div>
    <?php
    if (file_exists("./img/{$row['img']}")) {
        echo "<img src=\"./img/{$row['img']}\" alt=\"\">";
    } else {
        echo '';
    }
    ?>
</div>
<p>地址:<?= $row['addr'] ?></p>
<p>電話:<?= $row['tel'] ?></p>
<div>
    <?php
    if (file_exists("./img/{$row['menu_img']}")) {
        echo "<img src=\"./img/{$row['menu_img']}\" alt=\"\">";
    } else {
        echo '';
    }
    ?>
</div>
<table>
    <tr>
        <td>品項</td>
        <td>價格</td>
        <td>數量</td>
        <td>備註</td>
    </tr>
    <?php
    $sql = "select * from `options` where `restaurant_id`='{$_GET['id']}'";
    $options = $pdo->query($sql)->fetchAll();
    foreach ($options as $opt) {
    ?>
        <form action="" method="post">
            <tr>
                <td><?= $opt['name'] ?></td>
                <td class="dollar"><?= $opt['dollar'] ?></td>
                <td><input type="number" name="number" class="number" min="0" onchange="sum()" onkeyup="value=value.replace(/^(0+)|[^\d]+/g,'')"></td>
                <td><input type="text" name="remark"></td>
            </tr>
        <?php
    }
        ?>


</table>
<div>
    <span>總計:</span>
    <span id="total">0</span>
    <span>元</span>
</div>
<div><input type="submit" value="點餐"></td>
    <td><button type="button">取消</button></td>
</div>
</form>
<script>
    const dollar = document.getElementsByClassName("dollar");
    const number = document.getElementsByClassName("number");
    const total = document.getElementById("total");

    function sum() {
        let tmp = 0;
        for (let i = 0; i < dollar.length; i++) {
            tmp = Number(tmp) + Number(dollar[i].innerText) * Number(number[i].value);
        }
        total.innerText = tmp;
    }
</script>