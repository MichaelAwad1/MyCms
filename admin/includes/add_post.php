<?php 
if(isset($_POST["create_post"])){
    $post_title = $_POST["title"];
    $post_category_id = $_POST["post_category"];
    $post_author = $_POST["author"];
    $post_status = $_POST["status"]; 
    $post_image = $_FILES["image"]["name"];
    $post_image_temp = $_FILES["image"]["tmp_name"];
    
    
    
    $post_tags = $_POST["tags"];
    $post_content = $_POST["content"];
   // $post_date = date(d-m-y);
    $post_comment_count = 4;

    move_uploaded_file($post_image_temp,"../images/$post_image");

    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date,post_image,
    post_content,post_tags,post_status) ";         
    $query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}',
    '{$post_content}','{$post_tags}', '{$post_status}') "; 
             
    $create_post_query = mysqli_query($connection, $query); 
    confirmQuery($create_post_query);
    $post_id = mysqli_insert_id($connection);

    echo "<p class='bg-success'>Post Added <a href='../post.php?p_id=$post_id'>View post</a>" . " or " . "<a href='posts.php' >View All Posts</a></p>";

}
?>


<form action="" method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="post_category">Post Category</label>
    
        <select class="form-control" name="post_category" id="post_category">
        <?php $query = "SELECT * FROM categories  ";
        $select_categories_id = mysqli_query($connection,$query);  
        confirmQuery($select_categories_id);

            while($row = mysqli_fetch_assoc($select_categories_id)) {
            $cat_id = $row['category_id'];
            $cat_title = $row['category_title'];
                echo "<option value='{$cat_id}'>{$cat_title}</option>";
        }

            ?>
            
            </select>
        
    </div>
    <div class="form-group">
        <label for="author">Post Author</label>
        <input type="text" class="form-control" name="author">
    </div>
    <div class="form-group">
        <label for="status">Post Status</label>
        <select class="form-control" name="status" id="post_status">
            
            <option value="published">published</option>
            <option value="draft">draft</option>
            
            </select>
        
    </div>
    <div class="form-group">
        <label for="image">Post Image</label>
        <input type="file" class="form-control" name="image">
    </div>
    <div class="form-group">
        <label for="tags">Post Tags</label>
        <input type="text" class="form-control" name="tags">
    </div>
    <div class="form-group">
        <label for="content">Post Content</label>
        <textarea type="text" class="form-control" name="content" id="body" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>

</form>