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
<?php
    $sql="select `acc` from `members` where id='{$_GET['id']}'";
    $row=$pdo->query($sql)->fetchColumn();
?>
<div class="box">
<h2 class="mb-3">修改密碼</h2>
<div class="mb-3">
    <span>帳號:</span>
    <span><?=$row?></span>
</div>
<form action="./api/change_member.php" method="post">
    <div class="mb-3">
    <label for="pw" >更新密碼:</label>
    <input type="password" name="pw">
    </div>
    <div>
        <input type="hidden" name="id" value="<?=$_GET['id']?>">
    <button class="btn btn-primary" type="submit">更新</button>
    <button class="btn btn-secondary" type="button" onclick="location.href='./backend.php'">取消</button>
    </div>
    
</form>
</div>