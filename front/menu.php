<style>
    *{
        box-sizing: border-box;
    }
    #check {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
    }

    #check>div {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        top: 15vh;
        left: 25vw;
        background-color: skyblue;
        width: 1000px;
        height: 500px;
        border-radius: 1em;
        padding: 30px;
    }

    #check>div>div:nth-child(1) {
        position: absolute;
        top: 10px;
        right: 10px;
    }
    #buy{
        text-align: center;
        margin: 0 auto;
    }
    #check>div>div:nth-child(3) {
        position: absolute;
        left: 480px;
        bottom: 50px;
    }
    #check>div>div:nth-child(4) {
        position: absolute;
        left: 470px;
        bottom: 10px;
    }
</style>

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
        <form action="./api/order.php" method="post">
            <tr>
                <td><input type="hidden" name="id[]" class="store"  value="<?= $opt['id'] ?>" data-name="<?= $opt['name'] ?>"><?= $opt['name'] ?></td>
                <td class="dollar"><?= $opt['dollar'] ?></td>
                <td><input type="number" name="number[]" class="number" min="0" onchange="sum()" onkeyup="value=value.replace(/^(0+)|[^\d]+/g,'')"></td>
                <td><input type="text" name="remark[]" class="remark"></td>
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
<div>
    <button type="button" onclick="openDiv()">點餐</button>
    <button type="button" onclick="location.href='?'">取消</button>
</div>


<div id="check">
    <div>
        <div>
            <button type="button" onclick="closeDiv()">X</button>
        </div>
        <div id="buy">

        </div>
        <div>
            <span>總計:</span>
            <span id="total2">0</span>
            <span>元</span>
        </div>
        <div>
            <input type="hidden" name="restaurant_id" value="<?=$_GET['id']?>">
            <button type="submit">送出</button>
            <button type="button" onclick="closeDiv()">取消</button>
        </div>
    </div>
</div>
</form>
<script>
    const store = document.getElementsByClassName("store");
    const dollar = document.getElementsByClassName("dollar");
    const number = document.getElementsByClassName("number");
    const total = document.getElementById("total");
    const total2 = document.getElementById("total2");
    const check = document.getElementById("check");
    const buy = document.getElementById("buy");
    const remark = document.getElementsByClassName("remark");
    function sum() {
        let tmp = 0;
        for (let i = 0; i < dollar.length; i++) {
            tmp = Number(tmp) + Number(dollar[i].innerText) * Number(number[i].value);
        }
        total.innerText = tmp;
    }

    function openDiv() {
        sum();
        if(Number(total.innerText)>0){
        let text="<table><tr><td>品項</td><td>價格</td><td>數量</td><td>小計</td><td>備註</td>";
            for (let i = 0; i < dollar.length; i++) {
            if(Number(number[i].value)>0){
                text=text+"<tr><td>"+store[i].getAttribute('data-name')+"</td><td>"+dollar[i].innerText+"</td><td>"+number[i].value+"</td><td>"+ Number(dollar[i].innerText)*Number(number[i].value) + "元</td><td>"+remark[i].value+"</td></tr>";
            }
            }
            text+="</table>";
            buy.innerHTML=text;
            total2.innerText=total.innerText;
            check.style.display = "block";    
        }
    }
    function closeDiv(){
        check.style.display = "none";
    }
</script>