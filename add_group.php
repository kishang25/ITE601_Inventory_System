<?php
$page_title = 'Add Group';
require_once('DBobjects/Group.php');
require_once('includes/load.php');


// Instantiate the Group classd
$group = new Group($db, $session);

// Handle form submission for adding a new group
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    // Call the addGroup method of the Group class
    if ($group->addGroup($_POST)) {
        redirect('group.php', false); // Redirect to the group list page after successful addition
    } else {
        redirect('add_group.php', false); // Redirect back to the add group page if adding fails
    }
}
?>

<?php include_once('layouts/header.php'); ?>
<div class="login-page">
    <div class="text-center">
        <h3>Add new user Group</h3>
    </div>
    <?php echo display_msg($msg); ?>
    <form method="post" action="add_group.php" class="clearfix">
        <div class="form-group">
            <label for="name" class="control-label">Group Name</label>
            <input type="text" class="form-control" name="group-name">
        </div>
        <div class="form-group">
            <label for="level" class="control-label">Group Level</label>
            <input type="number" class="form-control" name="group-level">
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status">
                <option value="1">Active</option>
                <option value="0">Deactive</option>
            </select>
        </div>
        <div class="form-group clearfix">
            <button type="submit" name="add" class="btn btn-info">Add Group</button>
        </div>
    </form>
</div>
<?php include_once('layouts/footer.php'); ?>
