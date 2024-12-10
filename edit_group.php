<?php
$page_title = 'Edit Group';
require_once('includes/load.php');
require_once('DBobjects/Group.php');
// Check user permission
page_require_level(1);


// Instantiate the Group class
$group = new Group($db);

// Fetch the group by ID
$group_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$e_group = $group->findById($group_id);

if (!$e_group) {
    $session->msg("d", "Missing Group ID.");
    redirect('group.php');
}

// Handle form submission
if (isset($_POST['update'])) {
    $name   = remove_junk($_POST['group-name']);
    $level  = remove_junk($_POST['group-level']);
    $status = remove_junk($_POST['status']);

    // Attempt to update the group
    $result = $group->update($group_id, $name, $level, $status);
    if ($result) {
        $session->msg('s', "Group has been updated!");
        redirect('edit_group.php?id=' . $group_id, false);
    } else {
        $session->msg('d', "Failed to update group.");
        redirect('edit_group.php?id=' . $group_id, false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page">
    <div class="text-center">
        <h3>Edit Group</h3>
    </div>
    <?php echo display_msg($msg); ?>
    <form method="post" action="edit_group.php?id=<?php echo (int)$e_group['id']; ?>" class="clearfix">
        <div class="form-group">
            <label for="name" class="control-label">Group Name</label>
            <input type="text" class="form-control" name="group-name" value="<?php echo remove_junk(ucwords($e_group['group_name'])); ?>">
        </div>
        <div class="form-group">
            <label for="level" class="control-label">Group Level</label>
            <input type="number" class="form-control" name="group-level" value="<?php echo (int)$e_group['group_level']; ?>">
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status">
                <option <?php if ($e_group['group_status'] === '1') echo 'selected="selected"'; ?> value="1">Active</option>
                <option <?php if ($e_group['group_status'] === '0') echo 'selected="selected"'; ?> value="0">Deactive</option>
            </select>
        </div>
        <div class="form-group clearfix">
            <button type="submit" name="update" class="btn btn-info">Update</button>
        </div>
    </form>
</div>
<?php include_once('layouts/footer.php'); ?>
