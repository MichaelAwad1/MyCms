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
              $post_author = $_GET['author'];
                
            }
                $query = "SELECT * FROM POSTS WHERE post_author = '{$post_author}'";
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
                    <a href="post.php?p_id=<?php echo $post_id ; ?>"> <?php echo $post_title;  ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"> <?php echo $post_author ; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date;  ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image?>" alt="">
                <hr>
                <p> <?php echo $post_content  ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id ;?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
            
            
            
                
                
           <?php }  ?>



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


               
               
               

               

            </div>

            <!-- Blog Sidebar Widgets Column -->
          
            <?php  include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>

      
<?php  include "includes/footer.php" ?>