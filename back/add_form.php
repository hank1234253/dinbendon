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
<div class="box">
<h1 class="mb-3">新增會員</h1>
<form action="./api/add_member.php" method="post">
    <div class="mb-1">
        <label for="name">姓名:</label>
        <input type="text" name="name" id="name" required>
    </div>
    <div class="mb-1">
        <label for="acc">帳號:</label>
        <input type="text" name="acc" id="acc" required>
    </div>
    <div class="mb-1">
        <label for="pw">密碼:</label>
        <input type="password" name="pw" id="pw" required>
    </div>
    <div class="mb-3">
        <label for="class">班級:</label>
        <input type="text" name="class" id="class">
    </div>
    <div class="mb-3">
        <label for="pr">權限</label>
        <select name="pr">
            <option value="teacher">老師</option>
            <option value="student">學生</option>
        </select>
    </div>
    <div class="mb-1">
        <input type="hidden" name="type" value="0">
        <button class="btn btn-primary" type="submit">新增</button>
        <button class="btn btn-secondary" type="button" onclick="location.href='./backend.php'">取消</button>
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