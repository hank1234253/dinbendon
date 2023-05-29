<h2>修改密碼</h2>
<?php
    $sql="select `acc` from `member` where id='{$_GET['id']}'";
    $row=$pdo->query($sql)->fetchColumn();
?>
<div>
    <span>帳號:</span>
    <span><?=$row?></span>
</div>
<form action="./api/change.php" method="post">
    <div>
    <label for="pw">更新密碼:</label>
    <input type="password" name="pw">
    </div>
    <div>
        <input type="hidden" name="id" value="<?=$_GET['id']?>">
    <input type="submit" value="更新">
    <button type="button" onclick="location.href='./backend.php'">取消</button>
    </div>
</form>