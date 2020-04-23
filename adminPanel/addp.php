<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Add product</title>

</head>

<body>
<div class="row mx-4">
    <div class="col-md-4">
        <form action="addp_transaction.php" method="post" enctype='multipart/form-data'>
            <input type="hidden" id = "id" name = "id" required>
            <div class="form-group">
                <label for="name">Name: </label>
                <input class="form-control" type="name" id = "name" name = "name" required autofocus>
            </div>
            <div class="form-group">
                <label for="description">Description: </label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price: </label>
                <input class="form-control" type="number" id = "price" name = "price">
            </div>
            <div class="form-group">
                <label for="quantity">Quantity: </label>
                <input class="form-control" type="number" id = "quantity" name = "quantity" required>
            </div>
            <div class="form-group">
                <label for="category_id">Category: </label>

                <?php
                require_once 'DbConnect.php';
                $statement = $conn->prepare("SELECT id,name from category");
                //        $statement->bindParam(":category",$category, PDO::PARAM_STR);
                $statement->execute();
                $categories = $statement->fetchAll(PDO::FETCH_OBJ);
                ?>
                <select id="category" name="category">
                    <?php foreach($categories as $category): ?>
                        <option value="<?= $category->id; ?>"><?= $category->name; ?></option>
                    <?php endforeach; ?>
                </select>

            </div>
            <input type="submit" class="btn btn-primary" value="Add Product">

    </div>
            <div class='col-md-2 mt-4'>
                <label class="text-center">Photo 1</label><br>
                <div class='form-group'>
                    <input type='file' name='photo1'>
                </div>
            </div>
            <div class='col-md-2 mt-4'>
                <label class="text-center">Photo 2</label><br>
                <div class='form-group'>
                    <input type='file' name='photo2'>
                </div>
            </div>
            <div class='col-md-2 mt-4'>
                <label class="text-center">Photo 3</label><br>
                <div class='form-group'>
                    <input type='file' name='photo3'>
                </div>
            </div>

        </form>
    </div>
    <div class="col-md-1">
    </div>

<!--    <div class='col-md-2 mt-4'>-->
<!--        <label class="text-center">Photo 2</label><br>-->
<!--        <div class='form-group'>-->
<!--            <input type='file' name='photo2'>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class='col-md-2 mt-4'>-->
<!--        <label class="text-center">Photo 3</label><br>-->
<!--        <div class='form-group'>-->
<!--            <input type='file' name='photo3'>-->
<!--        </div>-->
<!--    </div>-->



</body>
</html>