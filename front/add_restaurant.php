<h2>新增餐廳</h2>
<?php
    if(!empty($_GET['error'])){
        echo "<span style='color:red'>已有相同餐廳</span>";
    }
?>
<form action="./api/add_restaurant.php" method="post" enctype="multipart/form-data">
<div>
    <label for="img">餐廳圖片</label>
    <input type="file" name="img" id="img" >
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
    <label for="menu_img">菜單圖片</label>
    <input type="file" name="menu_img" id="menu_img">
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
            let str=`<div>
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

    </script>