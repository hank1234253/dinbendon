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
            <td><?=$row['name']?></td>
            <td><?=$row['acc']?></td>
            <td><?=$row['class']?></td>
            <td><?=$row['pr']?></td>
            <td>
                <button type="button" onclick="location.href='?do=change&id=<?=$row['id']?>'">修改密碼</button>
                <button type="button" onclick="location.href='?do=check_member&id=<?=$row['id']?>'">刪除</button>
            </td>
        </tr>
        <?php
            }
            }
        ?>
    </table>