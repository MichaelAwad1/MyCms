<?php 

if(isset($_POST['checkBoxArray'])){
    foreach($_POST['checkBoxArray'] as $post_value_id){
        $bulk_options = $_POST['bulk_options'];

        switch($bulk_options) {
                case 'published':
                    $query = "UPDATE posts SET post_status = 'published' WHERE post_id = {$post_value_id}";
                    $set_to_published = mysqli_query($connection , $query);
                    confirmQuery($set_to_published);
                    break;
            
            
            
                case 'draft':
                    $query = "UPDATE posts SET post_status = 'draft' WHERE post_id = {$post_value_id}";
                    $set_to_draft = mysqli_query($connection , $query);
                    confirmQuery($set_to_draft);
                    break;
           
           
           
                case 'delete':
                    $query = "DELETE FROM posts WHERE post_id = {$post_value_id}";
                    $delete_posts = mysqli_query($connection , $query);
                    confirmQuery($delete_posts);
                    break;



                case 'clone':
                    $query = "SELECT *  FROM posts WHERE post_id = {$post_value_id}";
                    $cloned_posts = mysqli_query($connection , $query);
                    confirmQuery($cloned_posts);
                    while($row = mysqli_fetch_assoc($cloned_posts)) {
                        $post_id = $row['post_id'];
                        $post_author = $row['post_author'];
                        $post_title = $row['post_title'];
                        $post_category_id = $row['post_category_id'];                        
                        $post_status = $row['post_status'];
                        $post_image = $row['post_image'];
                        $post_tags = $row['post_tags'];
                        $post_comment_count = $row['post_comment_count'];
                        $post_date = $row['post_date'];
                        $post_content = $row['post_content'];
                        $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date,post_image,
                        post_content,post_tags,post_status, post_view_count) ";         
                        $query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}',
                        '{$post_content}','{$post_tags}', '{$post_status}', 0) "; 
                                
                        $create_post_query = mysqli_query($connection, $query); 
                        confirmQuery($create_post_query);
                    }
                   


                    break;

            
            
            
            case 'clone':
            break;        
        }

    }

}

?>



<form action="" method="post" autocomplete="off">
    <table class= "table tabled-bordered table-hover">
        
    <div id="bulkOptionContainer" class="col-xs-4">

        <select class="form-control" name="bulk_options" id="">
            
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="clone">Clone</option>
        </select>

    </div> 

    
    <div class="col-xs-4">

        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>

    </div>

        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>ID</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>Views</th>
                
            </tr>
        </thead>
        <tbody>
        <?php 


            $query = "SELECT * FROM posts";
            $select_posts = mysqli_query($connection,$query);  

            while($row = mysqli_fetch_assoc($select_posts)) {
            $post_id = $row['post_id'];
            $post_author = $row['post_author'];
            $post_title = $row['post_title'];
            $post_category_id = $row['post_category_id'];                        
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_date = $row['post_date'];
            $post_view_count = $row['post_view_count'];
            
            echo "<tr>";
            ?>
            <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>
            <?php
                
            echo "<td>{$post_id}</td>";
            echo "<td>{$post_author}</td>";
            echo "<td><a href= '../post.php?p_id=$post_id'>{$post_title}</td>";
            
            $query ="SELECT category_title FROM categories WHERE category_id = {$post_category_id}";
            $map_id_to_title = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($map_id_to_title)) {
                $category_title = $row['category_title'];
            }
            echo "<td>{$category_title}</td>";

            echo "<td>{$post_status}</td>";
            echo "<td><img width=100 src='../images/$post_image' alt='image'></td>";
            echo "<td>{$post_tags}</td>";
            echo "<td>{$post_comment_count}</td>";
            echo "<td>{$post_date}</td>";
            echo "<td>{$post_view_count}</td>";
            
            echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
            echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \" 
            
            href='posts.php?source=view_posts&delete={$post_id}'>Delete</a></td>";
            
            
            echo "</tr>";

            }


        ?>




        </tbody>

    </table>
</form>
                <?php 
                    deletePost();
                ?>