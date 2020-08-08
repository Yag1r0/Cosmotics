<div class='adminControl'>
    <span>Add product</span><br><br>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <th>Name:</th>
                <th>Code:</th>
                <th>Price:</th>
                <th>Image:</th>
            </tr>
            <tr class='rowStuff'>
                <td>
                    <input type="text" name="name" />
                </td>
                <td>
                    <input type="text" name="code" />
                </td>
                <td>
                    <input type="text" name="price" />
                </td>
                <td>
                    <input type="file" name="image" />
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" value="INSERT" class="buttonInput"/>
                    <input type="hidden" name="insertProduct" />
                </td>
            </tr>
        </table>
    </form>
    <br/>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
        <table border="1">
            <?php
                $products = $db_handle->runQuery("SELECT * FROM tblproduct;");
                foreach ($products as $key => $product) {
                ?>
                <tr>
                    <td>
                        <?php echo $product["id"]; ?>
                    </td>
                    <td>
                        <?php echo $product["name"]; ?>
                    </td>
                    <td>
                        <?php echo $product["code"]; ?>
                    </td>
                    <td>
                        <?php
                        if (!empty($product["image"])) {
                            echo "<img width='130' src='{$product["image"]}'/>";
                        }
                        ?>
                    </td>
                    <td>
                        <?php echo number_format($product["price"], 2); ?>
                    </td>
                    <td>
                        <a class='deletee' href='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?deleteProduct=true&id=<?php echo $product['id']; ?>'>DELETE</a>
                    </td>
                </tr>
	        <?php } ?>
        </table>
    </form>
    
</div>