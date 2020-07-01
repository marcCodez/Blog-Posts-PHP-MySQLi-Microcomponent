<?php
    require('config/config.php');
    require('config/db.php');

       // Check for Delete - adjusted the check submit code from edit.php
       if(isset($_POST['delete'])){
        // Get form data
        // add connection since we're using escape string
        $delete_id = mysqli_real_escape_string($connection, $_POST['delete_id']);

        // delete whichever post id is passed when we submit
        $query = "DELETE FROM posts WHERE id = {$delete_id}";

        // same thing run it through mysqli query and redirect
        if(mysqli_query($connection, $query)){
            //if query is succesful
            header('Location: '.ROOT_URL.'');
        } else {
            echo 'ERROR: '. mysqli_error($connection);
        }
    }

    // get ID - if we want it to get info for the corresponding selected post
    // mysqli_real_escape_string safety precaution to escape dangerous characters
    $id = mysqli_real_escape_string($connection, $_GET['id']);

    // Create query
    $query = 'SELECT * FROM posts WHERE id='.$id;

    // Get Result
    // can use the conenction variable since we required db.php
    $result = mysqli_query($connection, $query);

    // Fetch Data
    // return an associative array e.g. ['name' => 'marc']
    // fetch assoc instead, whill take the one post and turn it into an assoc array
    $post = mysqli_fetch_assoc($result);
    // var_dump($posts);

    // Free result - free it from memory
    mysqli_free_result($result);

    // Close connection
    mysqli_close($connection);

    ?>

<?php include('inc/header.php'); ?>
    <div class="container">
        <!-- create a config variable for the root url for the back button -->
        <a href="<?php echo ROOT_URL; ?>" class="btn btn-default">Back</a>
        <h1><?php echo $post['title']; ?></h1>
        <!-- remove foreach since only one post -->
        <small>Created on <?php echo $post['created_at']; ?> by <?php echo $post['author']; ?></small>
        <p><?php echo $post['body']; ?></p>
        <hr>
        <!-- align to right -->
        <form class="pull-right" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="delete_id" value="<?php echo $post['id']; ?>">
            <input type="submit" name="delete" value="Delete" class="btn btn-danger">
        </form>
        <!-- go to edit page with the id of the post -->
        <a href="<?php echo ROOT_URL; ?>editpost.php?id=<?php echo $post['id']; ?>" class="btn btn-default">Edit</a>
    </div>
    <?php include('inc/footer.php'); ?>