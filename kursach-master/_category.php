<?php
	include_once 'config.php';

	if($_GET['category'] == 0){
		$query_category = mysqli_query($link, "SELECT * FROM category"); 
	}else{
		$query_category = mysqli_query($link, "SELECT * FROM category WHERE id_category = ". $_GET['category']);
	}

	while($category = mysqli_fetch_array($query_category))
	{
		echo '<div class="category mb-3">
				    <h6 class="category-head border-bottom pb-2">'.$category["category"].'<img src="' .wayDir(). 'img/triangle.png" class="ml-2 mb-1 triangleRotate ';
				    if(!isset($_GET['category'])){ echo 'triangleClose'; }
				    echo '" width="10" height="10"></img></h6>
				    <ul class="list-unstyled list-group '; 
				    if(!isset($_GET['category'])){ echo 'category-ul'; }
				    echo '" style="display:none">';

					$query_subcategory = mysqli_query($link, "SELECT * FROM subcategory WHERE id_category = ".$category['id_category']);
					while($subcategory = mysqli_fetch_array($query_subcategory))
					{
						$cat = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM category WHERE id_category = ".$subcategory['id_category']));
						echo '<a href="' .way(). 'lot/index.php?search=&category=' .$cat["id_category"]. '&subcat=' .$subcategory["id_subcategory"]. '" class="d-flex justify-content-between align-items-center">
				    			'.$subcategory["subcategory"].'
					    	  <span class="badge badge-primary badge-pill">';

							  $count = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(id_subcategory) FROM lot WHERE id_subcategory = '".$subcategory['id_subcategory']."'"));
							  echo $count[0];

					    echo '</span>';
					}			    
	    echo '</a>
	    </ul>
	</div>';
	}
?>