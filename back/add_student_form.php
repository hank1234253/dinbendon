<style>
    .box{
        margin: 0 auto;
        background-color: white;
        width: 1000px;
        border: 1px solid #ccc;
        border-radius: 1em;
        box-shadow: 0 0 8px #ccc;
        padding: 30px;
    }
</style>
<h1>新增學生</h1>

<div class="box">
<form action="./api/add_member.php" method="post">
    <div class="mb-2">
        <label for="name">姓名:</label>
        <input type="text" name="name" id="name" required>
    </div>
    <div class="mb-2">
        <label for="acc">帳號:</label>
        <input type="text" name="acc" id="acc" required>
    </div>
    <div class="mb-2">
        <label for="pw">密碼:</label>
        <input type="password" name="pw" id="pw" required>
    </div>
    <div class="mb-2" > 
        <label for="class">班級:</label>
        <input type="hidden" name="class" value="<?=$_GET['class']?>" readonly>
        <span><?=$_GET['class']?></span>
    </div>
    <div class="mb-2">
        <label for="pr">權限</label>
        <input type="hidden" name="pr" id="pr" value="student" >
        <span>學生</span>
    </div>
    <div>
    <input type="hidden" name="type" value="1">
        <button type="submit">新增</button>
        <button type="button" onclick="location.href='./backend.php'">取消</button>
    </div>
    <div style="color:red">
        <?php
            if(!empty($_GET['error'])){
                echo ($_GET['error']=='1')?"帳號重複，請變更帳號":"";
            }
        ?>
    </div>
</form>
</div>