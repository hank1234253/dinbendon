<h2>你確定要刪除以下帳號及資料?</h2>
<?php
    $sql="select * from `member` where id='{$_GET['id']}'";
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
<div>
    <span>權限:</span>
    <span><?=$row['pr']?></span>
</div>
<div>
    <button type="button" onclick="location.href='./api/del.php?id=<?=$_GET['id']?>'">確定</button>
    <button type="button" onclick="location.href='./backend.php'">取消</button>
</div>