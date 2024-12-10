<?php
$page_title = 'Add Sale';
require_once('includes/load.php');
require_once('DBobjects/Sale.php');


$sale = new Sale($db, $session);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_sale'])) {
    if ($sale->addSale($_POST)) {
        redirect('add_sale.php', false);
    } else {
        redirect('add_sale.php', false);
    }
}
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-6">
        <?php echo display_msg($msg); ?>
        <form method="post" action="ajax.php" autocomplete="off" id="sug-form">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Find It</button>
                    </span>
                    <input type="text" id="sug_input" class="form-control" name="title" placeholder="Search for product name">
                </div>
                <div id="result" class="list-group"></div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Add Sale</span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="add_sale.php">
                    <table class="table table-bordered">
                        <thead>
                            <th> Item </th>
                            <th> Price </th>
                            <th> Qty </th>
                            <th> Total </th>
                            <th> Date</th>
                            <th> Action</th>
                        </thead>
                        <tbody id="product_info">
                            <tr>
                                <td><input type="number" name="s_id" class="form-control" placeholder="Product ID"></td>
                                <td><input type="number" name="price" class="form-control" placeholder="Price"></td>
                                <td><input type="number" name="quantity" class="form-control" placeholder="Quantity"></td>
                                <td><input type="number" name="total" class="form-control" placeholder="Total"></td>
                                <td><input type="date" name="date" class="form-control"></td>
                                <td><button type="submit" name="add_sale" class="btn btn-success">Add Sale</button></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
