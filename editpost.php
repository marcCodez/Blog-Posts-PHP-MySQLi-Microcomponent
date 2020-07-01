<?php
    require('config/config.php');
    require('config/db.php');

    // Check for Submit
    if(isset($_POST['submit'])){
        // Get form data
        // add connection since we're using escape string
        $update_id = mysqli_real_escape_string($connection, $_POST['update_id']);
        $title = mysqli_real_escape_string($connection, $_POST['title']);
        $body = mysqli_real_escape_string($connection, $_POST['body']);
        $author = mysqli_real_escape_string($connection, $_POST['author']);

        // update whichever post id is passed when we submit
        $query = "UPDATE posts SET
                    title='$title',
                    author='$author',
                    body='$body'
                WHERE id = {$update_id}";

        //  run it through mysqli query and redirect us back to root
        if(mysqli_query($connection, $query)){
            //if query is succesful
            header('Location: '.ROOT_URL.'');
        } else {
            echo 'ERROR: '. mysqli_error($connection);
        }
    }

    // we need a query to get the current post just like in post.php
    // so we can just reuse that code below

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
        <h1>Add Post</h1>
        <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo $post['title']; ?>">
        </div>
        <div class="form-group">
            <label>Author</label>
            <input type="text" name="author" class="form-control" value="<?php echo $post['author']; ?>">
        </div>
        <div class="form-group">
            <label for="">Title</label>
            <textarea name="body" class="form-control"><?php echo $post['body']; ?></textarea>
        </div>
        <!-- add a hidden input for id and adjust the query to update at top -->
        <input type="hidden" name="update_id" value="<?php echo $post['id']; ?>">
        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
        </form>
    </div>
    <?php include('inc/footer.php'); ?>