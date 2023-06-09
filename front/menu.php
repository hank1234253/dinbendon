<style>
    main{
        box-sizing: border-box;
        text-align: center;
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

    .menu{
        border: 1px solid #ccc;
        padding: 30px;
        margin: 0 auto;
        box-shadow: 0 0 8px #ccc;
        background-color: white;
    }
    .menu td,th{
        width: 230px;
        text-align: left;
    }
    .menu th{
        padding: 10px;
        padding-left: 50px;
        border-bottom: 1px solid #ccc;
        color:red;
    }
    .menu td{
        padding: 15px;
        padding-left: 50px;
        border-bottom: 1px solid #ccc;
    }
    .menu td>input{
        width: 200px;
        height: 22px;
    }
    img{
        max-width: 700px;
    }
    .restaurant{
        margin: 0 auto;
        background-color: white;
        width: 1000px;
        border: 1px solid #ccc;
        border-radius: 1em;
        box-shadow: 0 0 8px #ccc;
        padding: 30px;
    }
</style>

<?php

$sql = "select * from `restaurant` where `id`='{$_GET['id']}'";
$row = $pdo->query($sql)->fetch();
?>
<div class="restaurant mb-5">
    <h1 class="mb-3">&nbsp;&nbsp;&nbsp;<?= $row['name'] ?>&nbsp;<a href="?do=edit_restaurant&id=<?=$row['id']?>"><img src="./img/edit.png" alt="" width="25"></a></h1>
    <p>餐廳地址：<?= $row['addr'] ?></p>
    <p>餐廳電話：<?= $row['tel'] ?></p>
</div>
<div>
    <?php
    if (file_exists("./img/{$row['menu_img']}")) {
        echo "<img src=\"./img/{$row['menu_img']}\" alt=\"\">";
    } else {
        echo '';
    }
    ?>
</div>
<form action="./api/order.php" method="post">
<table class="menu mt-4 rounded">
    <tr>
        <th>品項</th>
        <th>價格</th>
        <th>數量</th>
        <th>備註</th>
    </tr>
    
    <?php
    $sql = "select * from `options` where `restaurant_id`='{$_GET['id']}'";
    $options = $pdo->query($sql)->fetchAll();
    foreach ($options as $opt) {
    ?>
        
            <tr>
                <td><input type="hidden" name="name[]" class="store"  value="<?= $opt['name'] ?>" data-name="<?= $opt['name'] ?>"><?= $opt['name'] ?></td>
                <td class="dollar"><?= $opt['dollar'] ?></td>
                <td><input type="number" name="number[]" class="number" min="0" onchange="sum()" onkeyup="value=value.replace(/^(0+)|[^\d]+/g,'')"></td>
                <td><input type="text" name="remark[]" class="remark"></td>
            </tr>
    <?php
        }
    ?>


</table>
<div class="mt-3">
    <span>總計:</span>
    <span id="total">0</span>
    <span>元</span>
</div>
<div class="mt-3">
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
<br>
<br>
<br>
<br>
<br>
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
        let text="<table class='menu mt-5'><tr><td>品項</td><td>價格</td><td>數量</td><td>小計</td><td>備註</td>";
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