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
<h2>你確定要刪除以下帳號及資料?</h2>
<?php
    $sql="select * from `members` where id='{$_GET['id']}'";
    $row=$pdo->query($sql)->fetch();
?>
<div>
    <span>帳號:</span>
    <span><?=$row['acc']?></span>
</div>
<div>
    <span>班級:</span>
    <span><?=$row['class']?></span>
</div>
<div class="mb-3">
    <span>權限:</span>
    <span><?=$row['pr']?></span>
</div>
<div>
    <button class="btn btn-danger" type="button" onclick="location.href='./api/del_member.php?id=<?=$_GET['id']?>'">確定</button>
    <button class="btn btn-secondary" type="button" onclick="location.href='./backend.php'">取消</button>
</div>
</div>