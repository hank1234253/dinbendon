<?php
?>
<form action="./api/add_member.php" method="post">
    <div>
        <label for="name">姓名:</label>
        <input type="text" name="name" id="name" required>
    </div>
    <div>
        <label for="acc">帳號:</label>
        <input type="text" name="acc" id="acc" required>
    </div>
    <div>
        <label for="pw">密碼:</label>
        <input type="password" name="pw" id="pw" required>
    </div>
    <div>
        <label for="class">班級:</label>
        <input type="text" name="class" id="class">
    </div>
    <div>
        <label for="pr">權限</label>
        <select name="pr">
            <option value="teacher">老師</option>
            <option value="student">學生</option>
        </select>
    </div>
    <div>
        <input type="hidden" name="type" value="0">
        <input type="submit" value="新增">
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