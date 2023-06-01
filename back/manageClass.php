<?php
$class=$pdo->query("select `class` from `members` where `acc`='{$_SESSION['login']}'")->fetchColumn();
?>
<h1>班級管理系統</h1>
    <table>
        <button type="button" onclick="location.href='?do=add_student_form&class=<?=$class?>'">新增學生</button>
        <tr>
            <td>姓名</td>
            <td>帳號</td>
            <td>班級</td>
            <td>座號</td>
            <td>權限</td>
            <td>操作</td>
        </tr>
        <?php
            $sql="select * from `members` where `class`='{$class}'";
            $rows=$pdo->query($sql)->fetchAll();
            foreach($rows as $row){
            if($row['pr']!='teacher'){
        ?>
        <tr>
            <form action="./api/edit_member.php" method="post">
            <td><?=$row['name']?></td>
            <td><?=$row['acc']?></td>
            <td><?=$row['class']?></td>
            <td>
                <input type="text" name="num" value="<?=$row['num']?>" onkeyup="value=value.replace(/^(0+)|[^\d]+/g,'')" require>
            </td>
            <td>學生</td>
            <td>
                <input type="hidden" name="id" value="<?=$row['id']?>">
                <button type="submit">變更</button>
                <button type="button" onclick="location.href='?do=change&id=<?=$row['id']?>'">修改密碼</button>
                <button type="button" onclick="location.href='?do=check_member&id=<?=$row['id']?>'">刪除</button>
            </td>
            </form>
        </tr>
        <?php
            }
            }
        ?>
    </table>