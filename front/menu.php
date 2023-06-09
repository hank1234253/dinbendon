<style>
    main {
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
        top: 15px;
        right: 15px;
    }

    #buy {
        text-align: center;
        margin: 0 auto;
    }

    #check>div>div:nth-child(3) {
        position: absolute;
        left: 480px;
        bottom: 60px;
    }

    #check>div>div:nth-child(4) {
        position: absolute;
        left: 470px;
        bottom: 20px;
    }

    .menu {
        padding: 30px;
        margin: 0 auto;
        box-shadow: 0 0 8px #ccc;
        background-color: white;
        border-radius: 1em;
    }

    .menu td,
    .menu th {
        width: 230px;
        text-align: left;
    }

    .menu th {
        padding: 10px;
        padding-left: 50px;
        border-bottom: 1px solid #ccc;
        color: red;
    }

    .menu td {
        padding: 15px;
        padding-left: 50px;
        border-top: 1px solid #ccc;
    }

    .menu td>input {
        width: 200px;
        height: 22px;
    }

    img {
        max-width: 700px;
    }

    .restaurant {
        margin: 0 auto;
        background-color: white;
        width: 1000px;
        border: 1px solid #ccc;
        border-radius: 1em;
        box-shadow: 0 0 8px #ccc;
        padding: 30px;
    }
    img{
        max-width: 800px;
    }
    .top{
            display: block;
            background-color: skyblue;
            width: 100px;
            height: 100px;
            line-height: 100px;
            position: fixed;
            top:86vh;
            right: 3vw;
            border-radius: 50px;
            box-shadow: 0 0 10px #ccc;
            transition: 0.2s;
            color:#0d6efd;
    }
    button{
        border: 0;
    }
    .top:hover{
        top:84vh
    }
    .cancel{
        color:white;
        background-color: #dc3545;
    }
</style>

<?php
$lastday = date("Y-n-d", strtotime("-1 day", strtotime("now")));
$nextday = date("Y-n-d", strtotime("+1 day", strtotime("now")));
$sql = "select * from `restaurant` where `id`='{$_GET['id']}'";
$row = $pdo->query($sql)->fetch();
$sql = "select * from `logs` where `create_time`>'{$lastday}'&&`create_time`<'{$nextday}'&&`acc`='{$_SESSION['login']}'";
$log=$pdo->query($sql)->fetch();

if(!empty($log)){
    $buy = unserialize($log['buy']);
    echo  "<button type='button' class='top cancel' onclick='cancel()'>取消訂餐</button>";
}

?>
<div class="restaurant mb-5">
    <h1 class="mb-3">&nbsp;&nbsp;&nbsp;<?= $row['name'] ?>&nbsp;<a href="?do=edit_restaurant&id=<?= $row['id'] ?>"><img src="./img/edit.png" alt="" width="25"></a></h1>
    <p>餐廳地址：<?= $row['addr'] ?></p>
    <p>餐廳電話：<?= $row['tel'] ?></p>
    <div>
    <?php
    if (file_exists("./img/{$row['menu_img']}")) {
        echo "<img src=\"./img/{$row['menu_img']}\" alt=\"\">";
    } else {
        echo '';
    }
    ?>
</div>
</div>

<form action="<?=(empty($log))?"./api/order.php":"./api/edit_order.php"?>" method="post">
    <table class="menu mt-4 ">
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
                <td><input type="hidden" name="name[]" class="store" value="<?= $opt['name'] ?>" data-name="<?= $opt['name'] ?>"><?= $opt['name'] ?></td>
                <td class="dollar"><?= $opt['dollar'] ?></td>
                <td><input type="number" name="number[]" class="number" min="0" onchange="sum()" onkeyup="value=value.replace(/^[^\d]+/g,'')" 
                value="<?php 
                            if(!empty($log)){
                                if(!empty($buy[$opt['name']][0])){
                                    echo $buy[$opt['name']][0];
                                }else{
                                    echo 0;
                                }
                            }else{
                                echo 0;
                            }
                        ?>">
                </td>
                <td><input type="text" name="remark[]" class="remark" 
                value="<?php if(!empty($log)){if($buy[$opt['name']][0]!=0){echo $buy[$opt['name']][1];}}?>"></td>
            </tr>
        <?php
        }
        ?>
        <tr>
            <td colspan="4" class="text-center">
                <span>總計:</span>
                <span id="total">0</span>
                <span>元</span>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="text-center" style="border:0">
            <input type="hidden" name="id" value="<?=!empty($log)?$log['id']:"";?>">
            <button type="button" class="btn btn-primary" onclick="openDiv()"><?=(empty($log))?"點餐":"修改"?></button>
            <button type="button" class="btn btn-secondary" onclick="location.href='?'">取消</button>
            </td>
        </tr>
    </table>
    
    


    <div id="check">
        <div>
            <div>
                <button type="button" class="btn btn-primary btn-light" onclick="closeDiv()">X</button>
            </div>
            <div id="buy">

            </div>
            <div>
                <span>總計:</span>
                <span id="total2">0</span>
                <span>元</span>
            </div>
            <div>
                <input type="hidden" name="restaurant_id" value="<?= $_GET['id'] ?>">
                <button class="btn btn-primary" type="submit">送出</button>
                <button class="btn btn-secondary" type="button" onclick="closeDiv()">取消</button>
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
    sum();
    function sum() {
        let tmp = 0;
        for (let i = 0; i < dollar.length; i++) {
            tmp = Number(tmp) + Number(dollar[i].innerText) * Number(number[i].value);
        }
        total.innerText = tmp;
    }

    function openDiv() {
        sum();
        if (Number(total.innerText) > 0) {
            let text = "<table class='menu mt-5'><tr><th>品項</th><th>價格</th><th>數量</th><th>小計</th><th>備註</th>";
            for (let i = 0; i < dollar.length; i++) {
                if (Number(number[i].value) > 0) {
                    text = text + "<tr><td>" + store[i].getAttribute('data-name') + "</td><td>" + dollar[i].innerText + "</td><td>" + number[i].value + "</td><td>" + Number(dollar[i].innerText) * Number(number[i].value) + "元</td><td>" + remark[i].value + "</td></tr>";
                }
            }
            text += "</table>";
            buy.innerHTML = text;
            total2.innerText = total.innerText;
            check.style.display = "block";
        }
    }

    function closeDiv() {
        check.style.display = "none";
    }
    function cancel(){
        if(confirm("你確定要取消今日訂餐?")){
            location.href="./api/cancel.php";
        }
    }
</script>