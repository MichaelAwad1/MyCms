<?php  include "includes/db.php" ?> 
<?php  include "includes/header.php" ?> 
 
    <!-- Navigation -->
    
    <?php  include "includes/navigation.php" ?> 
    
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
            <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small></h1>


            <?php 
            if(isset($_GET['p_id'])){
              $post_id = $_GET['p_id'];
              $query = "UPDATE POSTS SET post_view_count = post_view_count +1  WHERE post_id = {$post_id}";
              $increment_post_view_count = mysqli_query($connection , $query);
              confirmQuery($increment_post_view_count);


            
                $query = "SELECT * FROM POSTS WHERE post_id = {$post_id}";
                $select_posts = mysqli_query($connection , $query);
                
                while($row = mysqli_fetch_assoc($select_posts)){
                    // $postID = $row['post_id'];
                    // $postCategoryID = $row['post_category_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];
                    // $postTags = $row['post_tags'];
                    // $postCommentCount = $row['post_comment_count'];
                    // $postStatus = $row['post_status'];
            
                    ?>

           

                <!-- First Blog Post -->
                <h2>
                    <a href="#"> <?php echo $post_title  ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_post.php"> <?php echo $post_author  ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date  ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image?>" alt="">
                <hr>
                <p> <?php echo $post_content  ?></p>
               
                <hr>
            
            
            
                
                
           <?php }}
           
           else {
               header("Location: index.php");
           }

           ?>



                    <?php 
                    if(isset($_POST['create_comment'])){

                        $comment_post_id = $post_id;
                        $comment_author = $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = $_POST['comment_content'];
                        
                        if(!empty($comment_author) && !empty($comment_author) && !empty($comment_author) ){

                            $query = "INSERT INTO COMMENTS (comment_post_id, comment_author,comment_email,
                            comment_content, comment_status, comment_date) ";
                           $query .= "VALUES ({$comment_post_id}, '{$comment_author}', '{$comment_email}',
                            '{$comment_content}', 'unapproved' , now())";
                              $create_comment_query = mysqli_query($connection, $query);
                              confirmQuery($create_comment_query);
                           $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 
                                       WHERE post_id = {$comment_post_id}";
                           $update_comment_count = mysqli_query($connection, $query);
                           confirmQuery($update_comment_count);       
                           }
                           else {
                            echo "<script>alert('Fields cannot be empty') </script>";

                           }



                        }
                      
                        
                    
                   


                    
                    
                    ?>


               
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">
                    <div class="form-group">
                    <label for="Author">Author</label>
                           <input type="text" class="form-control" name="comment_author">
                        </div>
                        <div class="form-group">
                        <label for="Email">Email</label>
                           <input type="email" class="form-control" name="comment_email">
                        </div>
                        <div class="form-group">
                        <label for="comment">Your Comment</label>
                            <textarea class="form-control" id="body" rows="3" name="comment_content"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

            <?php 
                $query = "SELECT * FROM comments where comment_post_id = $post_id AND comment_status = 'approved'";
                $get_all_posts_comments = mysqli_query($connection , $query);
                confirmQuery($get_all_posts_comments);
                while($row = mysqli_fetch_assoc($get_all_posts_comments)){

                    $comment_author = $row["comment_author"];
                    $comment_date = $row["comment_date"];
                    $comment_content = $row["comment_content"];


                    ?>

                    <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>


            <?php
                }
            ?>
                 

                <!-- Comment -->
               

               

            </div>

            <!-- Blog Sidebar Widgets Column -->
          
            <?php  include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>

      
<?php  include "includes/footer.php" ?>