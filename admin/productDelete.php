<?php require '../conn.inc.php'; ?>
<?php $cate="";?>

<?php include 'header.php';?>

<script>
      function remove (id,category) {

          $.ajax({
            url:"singleProductDelete.php?id="+id+"&cat="+category, //the page containing php script
            type: "POST", //request type
            success:function(result){
                $('#results').load('productDelete.php?cat='+category+' #results');
           }
         });
        
     }
     </script>
<div class="container my-3">
<h2>Product Delete:</h2>
    <?php
        if(isset($_POST['sub'])){
            $cate=$_POST['category'];
            $s1=$_POST['search_text'];
            $s=explode(" ",$s1);
            $sql="";
            foreach($s as $i){
                  $sql .= "union SELECT * FROM `productdetails` where ((title like '%{$i}%' or details like '%{$i}%') and category='$cate')";
                   
            } 
            $sql=substr($sql,6);
        }
     ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-5">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="category">Select Category:</label>
                    </div>
                    <div class="col-sm-8">
                    <select name="category" class="form-control" id="category" value="<?php echo $q['category'];?>">
                        <option value="" <?php
                                                            if(($cate)==('')){
                                                                echo  "selected";
                                                            } ?>>Select category</option>
                        <option value="clothes" <?php
                                                            if(($cate)==('clothes')){
                                                                echo  "selected";
                                                            } ?>>Clothes</option>
                            <option value="perfume" <?php
                                                            if(($cate)==('perfume')){
                                                                echo  "selected";
                                                            } ?> >Perfume</option>
                            
                            <option value="shoes" <?php
                                                            if(($cate)==('shoes')){
                                                                echo  "selected";
                                                            } ?>>Shoes</option>
                            <option value="handbags" <?php
                                                            if(($cate)==('handbags')){
                                                                echo  "selected";
                                                            } ?>>Hand Bags</option>
                            
                        </select>
                    </div>
                </div>
            </div>
            <div class=" offset-1 col-sm-5 text-right">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                    <input type="text" name="search_text" class="form-control" placeholder="Search">
                </div> 
            </div>
            <div class="col-sm-1">
                <button type="submit" class="btn btn-primary" name="sub">Submit</button>
            </div>
        </div> 
    </form>
    
<br><br>
<h3>Choose Product:</h3>

    <section class="results border" >
        <div id="results">
            <?php
                $cat=@$cate;
                if(!isset($sql))
                    $qu = mysqli_query($conn,"Select * from productdetails where category='$cat'") or die(mysqli_error($conn));
                else
                    $qu = mysqli_query($conn,@$sql);
                while($q=mysqli_fetch_assoc($qu)){
                    ?>

                    <div class="row px-3 py-2 disprow">
                        <div class="col-md-3 img text-center">
                            <img src="<?php echo "../images/".$cat."/".$q['image1'];?>" alt="GadgetsPick" class="img-fluid">
                        </div>
                        <div class="col-md-5 text title text-center"><?php echo $q['title'];?></div>
                        <div class="col-md-3 price text-center">PKR <?php echo $q['newPrice'];?></div>
                        <div class="col-md-1  text-center">
                            <button  onclick='<?php echo 'remove('.$q['id'].',"'.$q['category'].'")';?>' class="btn btn-danger">Delete</a>
                        </div>
                    </div>

                    <?php
                }
        ?>

        </div>
    </section>
    </div>

<?php include 'footer.php';?>
