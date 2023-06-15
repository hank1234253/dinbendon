<style>
    .menu {
        border-radius: 1em;
        padding: 30px;
        margin: 0 auto;
        box-shadow: 0 0 8px #ccc;
        background-color: white;
    }

    .menu td,
    .menu th {
        width: 200px;
        text-align: left;
    }

    .menu th {
        padding: 15px;
        padding-left: 50px;
        border-bottom: 1px solid #ccc;
        color: red;
    }

    .menu td {
        padding: 15px;
        padding-left: 50px;
        border-bottom: 1px solid #ccc;
    }

    .menu tr th:nth-child(4),
    .menu tr td:nth-child(4) {
        width: 700px;
        padding: 0;
    }

    .order {
        display: flex;
        min-width: 140px;
        text-align: center;
        border-radius: 1em;
        margin-top: 5px;
        margin-bottom: 5px;
        margin-right: 5px;
    }

    .order>.id {
        display: inline-block;
        border-top-left-radius: 1em;
        border-bottom-left-radius: 1em;
        color: white;
        background-color: gray;
        padding: 3px;
        padding-left: 5px;
    }

    .order>.num {
        display: inline-block;
        border-top-right-radius: 1em;
        border-bottom-right-radius: 1em;
        color: white;
        padding: 3px;
        background-color: skyblue;
        padding-right: 5px;

    }

    .order>.name {
        display: inline-block;
        color: white;
        font-family: "微軟正黑體";
        width: 85px;
        padding: 3px;
    }

    .order>.none {
        display: none;
        position: fixed;
        margin-top: -50px;
        margin-left: -30px;
        z-index: 1;
        background-color: white;
        min-width: 200px;
        padding: 10px;
        box-shadow: 0 0 10px #ccc;
    }

    .myContainer {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
    }

    .restaurant {
        margin: 0 auto;
        margin-bottom: 5vh;
        background-color: white;
        width: 65vw;
        border: 1px solid #ccc;
        border-radius: 1em;
        box-shadow: 0 0 8px #ccc;
        padding: 30px;
    }

    .remark>.name {
        background-color: red;
    }

    .pay{
        padding: 30px;
        margin: 0 auto;
        box-shadow: 0 0 8px #ccc;
        background-color: white;
        border-radius: 1em;

    }
    .pay th {
        padding: 15px;
        border-bottom: 1px solid #ccc;
        color: red;
        
    }
    .pay td {
        padding: 15px;
        border-bottom: 1px solid #ccc;
    }
</style>
<?php
$lastday = date("Y-n-d", strtotime("-1 day", strtotime("now")));
$nextday = date("Y-n-d", strtotime("+1 day", strtotime("now")));
$class = $pdo->query("select `class` from `members` where `acc`='{$_SESSION['login']}'")->fetchColumn();
$sql = "select * from `logs` where `create_time`>'{$lastday}'&&`create_time`<'{$nextday}'&&`class`='{$class}'";
$logs = $pdo->query($sql)->fetchAll();

?>
<?php
if (!empty($logs)) {
    $restaurant = $pdo->query("select * from `restaurant` where `name`='{$logs[0]['restaurant']}'")->fetch();
    ?>
    <h2 class="mb-3">今日點餐</h2>
    <div class="restaurant">
        <p>餐廳名稱：<?=$restaurant['name']?></p>
        <p>餐廳地址：<?=$restaurant['addr']?></p>
        <p>餐廳電話：<?=$restaurant['tel']?></p>
    </div>

    <table class="menu" id="menu">
    </table>
    <table class="pay mt-5 mb-5" id="pay">
        
    </table>
<?php
} else {
    echo "<h2>今日尚未選擇餐廳</h2>";
}
?>

<script>
    let menu=document.getElementById("menu");
    let pay=document.getElementById("pay");
    let checkOrder="";
    getDate();
    getPay();
    setInterval(getDate, 5000);



    function getDate() {
        $.ajax({
            url: "./api/log.php",
            method: "post",
            dataType: "json",
            success: function(require) {
                if (JSON.stringify(checkOrder) !== JSON.stringify(require)){
                    checkOrder=require;
                let key = Object.keys(require);
                let value = Object.values(require);
                let html = `<tr>
                                <th>品項</th>
                                <th>價格</th>
                                <th>數量</th>
                                <th>訂餐者</th>
                            </tr>`;
                menu.innerHTML=html;
                for (let i = 0; i < key.length; i++) {
                    html = `<tr>
                                <td>${key[i]}</td>
                                <td>${value[i].dollar}</td>
                                <td>${value[i].num}</td>
                                <td>
                                    <div class="myContainer">`;
                    let key2 = Object.keys(value[i]);
                    let value2 = Object.values(value[i]);
                    for (let j = 0; j < key2.length; j++) {
                        if (key2[j] != "num" && key2[j] != "dollar") {
                            if (key2[j] != "num" && key2[j] != "dollar") {
                                if (value2[j].remark.length == 0) {
                                    html = html + `<div class='order'>
                                                        <div class='id'>${value2[j].id}</div>
                                                        <div class='name' style='background-color:#4caf50'>${key2[j]}</div>
                                                        <div class='num'>x${value2[j].num}</div>
                                                    </div>`;
                                } else {
                                    html = html + `<div class='order remark'>
                                                        <div class='id'>${value2[j].id}</div>
                                                        <div class='name'>${key2[j]}</div>
                                                        <div class='num'>x${value2[j].num}</div>
                                                        <div class='none'>${value2[j].remark}</div>
                                                    </div>`;
                                }
                            }
                            
                        }
                        
                    }
                    html =html+`</td>
                            </tr>`;
                    $(".menu").append(html);
                }
                hover();
                
                }
                getPay();
            }
        })
        
    }
    function hover(){
        let order=document.querySelectorAll(".remark");
        let none=document.querySelectorAll(".none");
        order.forEach((element,key) => {
            element.addEventListener("mouseenter",()=>{
                none[key].style.display="block";
            })
        });
        order.forEach((element,key) => {
            element.addEventListener("mouseleave",()=>{
                none[key].style.display="none";
            })
        });
    }
    
    let checkPay="";
    function getPay(){
        $.ajax({
            url: "./api/pay.php",
            method: "post",
            dataType: "json",
            success: function(require){
                if (JSON.stringify(checkPay) !== JSON.stringify(require)){
                    checkPay=require;
                let html=`<tr>
                            <th>座號</th>
                            <th>姓名</th>
                            <th>餐點</th>
                            <th>應付</th>
                            <th>實收</th>
                            <th>找零</th>
                         </tr>`;
                pay.innerHTML=html;
                for(let i=0;i<require.length;i++){
                    html=`<tr>
                            <td>${require[i].id}</td>
                            <td>${require[i].name}</td>
                            <td>${require[i].order}</td>
                            <td class="paid" data-id="${require[i].log_id}">${require[i].sum}</td>
                            <td><input type="number" name="number" class="number" min="0" value="${require[i].pay}" onchange="_count()" onkeyup="value=value.replace(/^[^\\d]+/g,'')"></td>
                            <td class="cash"></td>
                          </tr>`
                    $("#pay").append(html);
                }
                setTimeout(_count,100);
                }
            }
        })
    }
    
    function _count(){
        let paid=document.getElementsByClassName("paid");
        let number=document.getElementsByClassName("number");
        let cash=document.getElementsByClassName("cash");
        
        for(let i=0;i<paid.length;i++){
            let tmp=Number(number.item(i).value)-Number(paid.item(i).innerText);
            $.ajax({
                    url:"./api/update_log.php",
                    type:'post',
                    data:{id:paid.item(i).getAttribute("data-id"),pay:number.item(i).value},
                    success:function(check){
                        
                    }
                }
                )
            if(tmp>=0){
                cash.item(i).innerText=tmp;
            }else{
                cash.item(i).innerText="尚未繳錢";
            }
        }
    }
</script>

