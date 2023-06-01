<style>
    img{
        max-width: 500px;
    }
    #delBtn,
    #delBtn2{
        display: none;
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
        <button type="button" id="delBtn" onclick="delImg('img_file','img',this)">刪除圖片</button>
    </div>
    <div>
        <label for="img">餐廳圖片</label>
        <input type="file" name="img" id="img_file" accept="image/gif, image/jpeg, image/png">
    </div>
    <div>
        <label for="name">餐廳名字</label>
        <input type="text" name="name" id="name" required>
    </div>
    <div>
        <label for="tel">電話</label>
        <input type="text" name="tel" id="tel" onkeyup="value=value.replace(/[^\d]+/g,'')" required>
    </div>
    <div>
        <label for="addr">餐廳地址</label>
        <input type="text" name="addr" id="addr" required>
    </div>
    <hr>
    <div>
        <img id="menu_img" src="#" alt="">
        <button type="button" id="delBtn2" onclick="delImg('menu_img_file','menu_img',this)">刪除圖片</button>
    </div>
    <div>
        <label for="menu_img">菜單圖片</label>
        <input type="file" name="menu_img" id="menu_img_file" accept="image/gif, image/jpeg, image/png">
    </div>
    <div class=menu>
        <label for="">項目:</label>
        <input type="text" name="menu[]" required>
        <label for="">價格:</label>
        <input type="number" name="dollar[]" class="dollar" min="0" onkeyup="value=value.replace(/^(0+)|[^\d]+/g,'')" required>
        <span onclick="addDiv()">+</span>
    </div>
    <div>
        <input type="submit" value="新增">
        <button type="button" onclick="location.href='./index.php'">取消</button>
    </div>

</form>
<script>
    function addDiv() {
        let str = `<div>
                <label for="">項目:</label>
                <input type="text" name="menu[]" required>
                <label for="">價格:</label>
                <input type="number" name="dollar[]" onkeyup="value=value.replace(/^(0+)|[^\\d]+/g,'')" required>
                <span onclick="addDiv()">+</span>
                <span onclick="delDiv(this)">-</span>
            </div>`;
        $(".menu").append(str);
    }

    function delDiv(el) {
        let dom = $(el).parent();
        dom.remove();
    }

    $("#img_file").change(function() {
        readURL(this,"#img");
        document.getElementById("delBtn").style.display="block";
    });
    $("#menu_img_file").change(function() {
        readURL(this,"#menu_img");
        document.getElementById("delBtn2").style.display="block";
    });

    function readURL(input,img) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $(img).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }


    function delImg(file,img,obj){
        document.getElementById(file).value="";
        document.getElementById(img).src="";
        obj.style.display="none";
    }
</script>