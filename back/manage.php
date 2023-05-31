<h1>會員管理系統</h1>
    <table>
        <button type="button" onclick="location.href='?do=add_form'">新增會員</button>
        <tr>
            <td>姓名</td>
            <td>帳號</td>
            <td>班級</td>
            <td>權限</td>
            <td>操作</td>
        </tr>
        <?php
            $sql="select * from `members`";
            $rows=$pdo->query($sql)->fetchAll();
            $classes=$pdo->query("select `class` from `members` group by `class`")->fetchAll();
            foreach($rows as $row){
            if($row['pr']!='super'){
        ?>
        <tr>
            <form action="./api/edit_member.php" method="post">
            <td><?=$row['name']?></td>
            <td><?=$row['acc']?></td>
            <td>
                <select name="class">
                <?php
                    foreach($classes as $class){
                        if($class['class']!='0'){
                ?>
                    <option value="<?=$class['class']?>" <?php if($class['class']==$row['class'])echo "selected"?> ><?=$class['class']?></option>
                <?php
                }
                }
                ?>
                </select>
            </td>
            <td>
                <select name="pr">
                    <option value="teacher" <?=($row['pr']=="teacher")?"selected":""?>>老師</option>
                    <option value="student" <?=($row['pr']=="student")?"selected":""?>>學生</option>
                </select>
            </td>
            <td>
                <input type="hidden" name="id" value="<?=$row['id']?>">
                <button type="submit">變更</button>
                <button type="button" onclick="location.href='?do=check_member&id=<?=$row['id']?>'">刪除</button>
                <button type="button" onclick="location.href='?do=change&id=<?=$row['id']?>'">修改密碼</button>
            </td>
            </form>
        </tr>
        <?php
            }
            }
        ?>
    </table>