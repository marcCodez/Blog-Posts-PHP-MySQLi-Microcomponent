<?php
    require('config/config.php');
    require('config/db.php');

    // Create query
    $query = 'SELECT * FROM posts';

    // Get Result
    // can use the conenction variable since we required db.php
    $result = mysqli_query($connection, $query);

    // Fetch Data
    // return an associative array e.g. ['name' => 'marc']
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    // var_dump($posts);

    // Free result - free it from memory
    mysqli_free_result($result);

    // Close connection
    mysqli_close($connection);

    ?>
<?php include('inc/header.php'); ?>
    <div class="container">
        <h1>Posts</h1>
        <!-- loop through posts shorthand php syntax -->
        <?php foreach($posts as $post) : ?>
            <div class="well">
                <h3><?php echo $post['title']; ?></h3>
                <small>Created on <?php $post['created_at']; ?> by <?php echo $post['author']; ?></small>
                <p><?php echo $post['body']; ?></p>
                <a class="btn btn-default" href="<?php echo ROOT_URL;?>post.php?id=<?php echo $post['id']; ?>">Read More</a>
            </div>
        <?php endforeach; ?>
    </div>
    <?php include('inc/footer.php'); ?>