<style>
    main {
        text-align: center;
        box-sizing: border-box;
    }

    img {
        max-width: 500px;
    }

    #delBtn,
    #delBtn2 {
        display: none;
    }

    #space {
        height: 330px;
    }

    .container {
        width: 900px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        margin: 0 auto;
    }

    .container>div {
        margin-bottom: 10px;
    }
    .menu{ 

        border: 1px solid #ccc;
        padding: 30px;
        margin: 0 auto;
        box-shadow: 0 0 8px #ccc;
        background-color: white;
    }
    .menu th{
        width:500px;
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
    .restaurant{
        text-align: center;
        background-color: white;
        width: 900px;
        margin: 0 auto;
        border: 1px solid #ccc;
        border-radius: 1em;
        box-shadow: 0 0 8px #ccc;
    }
    form{
        margin: 0 auto;
    }

    .del{
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
            border: 0;
    }
    .del:hover{
        top:84vh;
    }
    
</style>
<h2>編輯餐廳</h2>
<button class='del' type="button" onclick="del(<?=$_GET['id']?>);"  >刪除餐廳</button>
<?php
if (!empty($_GET['error'])) {
    if($_GET['error']==1){
    echo "<h3 style='color:red'>已有相同餐廳名稱</h3>";
    }else{
        echo "<h3 style='color:red'>有重複的菜單項目</h3>";
    }
}

$restaurant=$pdo->query("select * from `restaurant` where `id`='{$_GET['id']}'")->fetch();
$options=$pdo->query("select * from `options` where `restaurant_id`='{$_GET['id']}'")->fetchAll();
?>
<form action="./api/edit_restaurant.php" method="post" enctype="multipart/form-data">
    <div class="restaurant">
<div class="mt-3">
        <img id="img" src="
        <?php
            if(file_exists("./img/{$restaurant['img']}")&&!empty($restaurant['img'])){
                echo "./img/{$restaurant['img']}";
            }else{
                echo "./img/unknow.jpg";
            }
        ?>" alt="">
    </div>
    <div class="container mt-3">
        <div>
            <label for="img">餐廳圖片</label>
            <input type="file" name="img" id="img_file" accept="image/gif, image/jpeg, image/png">
            <button type="button" id="delBtn" onclick="delImg('img_file','img',this)">刪除圖片</button>
        </div>
        <div>
            <label for="name">餐廳名稱</label>
            <input type="text" name="name" id="name" value="<?=$restaurant['name']?>" required>
        </div>
        <div>
            <label for="tel">餐廳電話</label>
            <input type="text" name="tel" id="tel" value="<?=$restaurant['tel']?>" onkeyup="value=value.replace(/[^\d]+/g,'')" required>
        </div>
        <div>
            <label for="addr">餐廳地址</label>
            <input type="text" name="addr" id="addr" value="<?=$restaurant['addr']?>" required>
        </div>
    </div>
    </div>
    <div class="restaurant mt-5 mb-5">
    <div class="mt-3">
        <img id="menu_img" src="<?php
            if(file_exists("./img/{$restaurant['menu_img']}")&&!empty($restaurant['menu_img'])){
                echo "./img/{$restaurant['menu_img']}";
            }else{
                echo "./img/unknow.jpg";
            }
        ?>
        " alt="">
    </div>
    <div class="container mt-3">
        
        <div>
            <label for="menu_img">菜單圖片</label>
            <input type="file" name="menu_img" id="menu_img_file" accept="image/gif, image/jpeg, image/png">
            <button type="button" id="delBtn2" onclick="delImg('menu_img_file','menu_img',this)">刪除圖片</button>
        </div>
    </div>
    </div>
    <div class="container">
        <table class=menu>
            <tr>
                <th>項目</th>
                <th>價格</th>
                <th>操作</th>
            </tr>
            <tr>
                <td><input type="text" name="menu[]" value="<?=$options[0]['name']??''?>" required></td>
                <td><input type="number" name="dollar[]" class="dollar" min="0" value="<?=$options[0]['dollar']??''?>" onkeyup="value=value.replace(/^(0+)|[^\d]+/g,'')" required></td>
                <td>
                    <button type="button" onclick="addDiv()">+</button>
                </td>
            </tr>
            <?php
                foreach($options as $idx => $option){
                    if($idx==0){
                        continue;
                    }
            ?>
            <tr>
                <td><input type="text" name="menu[]" value="<?=$option['name']?>" required></td>
                <td><input type="number" name="dollar[]" class="dollar" value="<?=$option['dollar']?>" min="0" onkeyup="value=value.replace(/^(0+)|[^\d]+/g,'')" required></td>
                <td>
                    <button type="button" onclick="addDiv()">+</button>
                    <button type="button" onclick="delDiv(this)">-</button>
                </td>
            </tr>
            <?php
                }
            ?>
        </table>
    </div>
    <div class="mt-3">
        <input type="hidden" name="id" value="<?=$_GET['id']?>">
        <button type="submit">編輯</button>
        <button type="button" onclick="location.href='./index.php'">取消</button>
    </div>
    <div id="space" data-img="<?php 
    if(file_exists("./img/{$restaurant['img']}")&&!empty($restaurant['img'])){
        echo "1,";
    }else{
        echo "0,";
    }if(file_exists("./img/{$restaurant['menu_img']}")&&!empty($restaurant['menu_img'])) {
        echo "1";
    }else{
        echo "0";
    }
    ?>
    ">


</form>
<script>
    let flag=document.getElementById("space").getAttribute("data-img");
    let img=document.getElementById('img').src;
    let menu_img=document.getElementById('menu_img').src;
    flag=flag.split(","); 
    function addDiv() {
        let str = `<tr>
                <td><input type="text" name="menu[]" required></td>
                <td><input type="number" name="dollar[]" class="dollar" min="0" onkeyup="value=value.replace(/^(0+)|[^\\d]+/g,'')" required></td>
                <td>
                    <button type="button" onclick="addDiv()">+</button>
                    <button type="button" onclick="delDiv(this)">-</button>
                </td>
            </tr>`;
        $(".menu").append(str);
    }

    function delDiv(el) {
        let dom = $(el).parent().parent();
        dom.remove();
    }

    $("#img_file").change(function() {
        readURL(this, "#img");
        document.getElementById("delBtn").style.display = "inline-block";
    });
    $("#menu_img_file").change(function() {
        readURL(this, "#menu_img");
        document.getElementById("delBtn2").style.display = "inline-block";
    });

    function readURL(input, img) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $(img).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }


    function delImg(file, img_in, obj) {
        document.getElementById(file).value = "";
        if(img_in=='img'){
            if(flag[0]==1){
                document.getElementById(img_in).src = img;
            }else{
            document.getElementById(img_in).src = "./img/unknow.jpg";
        }
        }else if(img_in=='menu_img'){
            if(flag[1]==1){
                document.getElementById(img_in).src = menu_img;
            }else{
            document.getElementById(img_in).src = "./img/unknow.jpg";
        }
        }
        obj.style.display = "none";
    }

    let name=document.getElementById("name").value;
    function del(id){
        if(confirm(`你確定要刪除以下餐廳?
        ${name}`)){
            location.href=`./api/del_restaurant.php?id=${id}`;
        }
    }
</script>