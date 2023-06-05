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
        height: 350px;
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
        border-radius: 1em;
        box-shadow: 0 0 8px #ccc;
    }
    .menu td,th{
        width: 600px;
        text-align: left;
    }
    .menu th{
        padding: 10px;
        border-left: 15px solid seagreen;
        border-bottom: 1px solid #ccc;
        color:red;
    }

    .menu td{
        padding: 15px;
        padding-left: 15px;
        border-bottom: 1px solid #ccc;
    }
    .menu td>input{
        width: 200px;
        height: 22px;
    }
    .menu tr>td:nth-child(3){
        padding-left: 120px;
    }
    input[type="file"]{
        margin-right: 85px;
    }
</style>
<h2>新增餐廳</h2>
<?php
if (!empty($_GET['error'])) {
    echo "<span style='color:red'>已有相同餐廳</span>";
}
?>
<form action="./api/add_restaurant.php" method="post" enctype="multipart/form-data">
    <div>
        <img id="img" src="#" alt="">
    </div>
    <div class="container">
        <div>
            <label for="img">餐廳圖片</label>
            <input type="file" name="img" id="img_file" accept="image/gif, image/jpeg, image/png">
            <button type="button" id="delBtn" onclick="delImg('img_file','img',this)">刪除圖片</button>
        </div>
        <div>
            <label for="name">餐廳名字</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div>
            <label for="tel">餐廳電話</label>
            <input type="text" name="tel" id="tel" onkeyup="value=value.replace(/[^\d]+/g,'')" required>
        </div>
        <div>
            <label for="addr">餐廳地址</label>
            <input type="text" name="addr" id="addr" required>
        </div>
    </div>
    <hr>
    <div>
        <img id="menu_img" src="#" alt="">
    </div>
    <div class="container">
        <div>
            <label for="menu_img">菜單圖片</label>
            <input type="file" name="menu_img" id="menu_img_file" accept="image/gif, image/jpeg, image/png">
            <button type="button" id="delBtn2" onclick="delImg('menu_img_file','menu_img',this)">刪除圖片</button>
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
                <td><input type="text" name="menu[]" required></td>
                <td><input type="number" name="dollar[]" class="dollar" min="0" onkeyup="value=value.replace(/^(0+)|[^\d]+/g,'')" required></td>
                <td>
                    <button type="button" onclick="addDiv()">+</button>
                </td>
            </tr>
        </table>
    </div>
    <div>
        <input type="submit" value="新增">
        <button type="button" onclick="location.href='./index.php'">取消</button>
    </div>
    <div id="space">


</form>
<script>
    function addDiv() {
        let str = `<tr>
                <td><input type="text" name="menu[]" required></td>
                <td><input type="number" name="dollar[]" class="dollar" min="0" onkeyup="value=value.replace(/^(0+)|[^\d]+/g,'')" required></td>
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


    function delImg(file, img, obj) {
        document.getElementById(file).value = "";
        document.getElementById(img).src = "";
        obj.style.display = "none";
    }
</script>