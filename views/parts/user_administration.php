<div class='adminControl'>
    <span>Add administrator</span><br><br>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <table class='borderino'>
            <tr>
                <th>Username:</th>
                <th>Password:</th>
            </tr>
            <tr>
                <td>
                    <input type="text" name="username" />
                </td>
                <td>
                    <input type="password" name="password" />
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" value="INSERT" class="buttonInput"/>
                    <input type="hidden" name="insertUser" />
                </td>
            </tr>
        </table>
    </form>
    <br/>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
        <table border="1">
            <?php
                $users = $db_handle->runQuery("SELECT * FROM users;");
                foreach ($users as $key => $user) {
                ?>
                <tr>
                    <td>
                        <?php echo $user["id"]; ?>
                    </td>
                    <td>
                        <?php echo $user["username"]; ?>
                    </td>
                    <td>
                        <?php echo $user["role"]; ?>
                    </td>
                    <td>
                        <a class='deletee' href='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?deleteUser=true&id=<?php echo $user['id']; ?>'>DELETE</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </form>
    
</div>