<!--css--->	
<style>
* {box-sizing: border-box}
body {font-family: Verdana, sans-serif; margin:0}
.mySlides {display: none}
img {vertical-align: middle;}


@-webkit-keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .prev, .next,.text {font-size: 11px}
  
  
}


.panel-body {
    padding: 15px;
}

.panel {
    margin-bottom: 20px;
    background-color: #fff;
    border: 1px solid transparent;
    border-radius: 4px;
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.05);
    box-shadow: 0 1px 1px rgba(0,0,0,0.05);
}

.panel-footer {
    padding: 10px 15px;
    background-color: lavenderblush;
    border-top: 1px solid #ddd;
    border-bottom-right-radius: 3px;
    border-bottom-left-radius: 3px;
}

 tr
 {
     float:left;
     width:20%;
	}

td
{
	 text-align:center;
	  margin:auto;
}


@media only screen and (max-width: 768px) {
	    tr{
	        float:left;
	        width:50%;
	    }
}




	</style>
	

<div class="container">
	
  <div class="row text-center portfolio" style="margin-top:5%";>
      
      <table id="product" style="width:100%">
      <thead style="display:none;">
				<tr>
					<th>Name</th>
				</tr>
  </thead>
  
    <?php  
         
       $list = $this->db->get('stock_products');?>
       
  
      <tbody>
  <?php foreach($list->result() as $productlist):?>
  
  <?php if (strlen($productlist->name)>=1) { ?>
    <div class="col-lg-3 col-sm-4 col-xs-6">
         <tr style="text-align: -webkit-center;">
      <td>
        <div class="panel panel-default" style="margin-bottom:10%; border-color:rgb(242, 0, 137);">
            <div class="panel-body ">
			
                <a href="<?php echo base_url();?>index.php/auth/signin">
				    
				<?php if ($productlist->file1){?>
                    <img src="<?php echo $this->config->item('asset_url'); ?>/productimg/<?php  echo $productlist->file1;?>" style="height:139px; width:182px;" class="img-thumbnail img-responsive">
				<?php }else{?>
					<img src="<?php echo $this->config->item('asset_url'); ?>/productimg/noimage.png" class="img-thumbnail img-responsive">
				<?php }?>
               
			    </a>
            </div>
            <div class="panel-footer">
                <span style="display:none;"><?php echo $productlist->id; ?></span><br/>
		<span style="text-transform: uppercase"><?php echo $productlist->company; ?></span><br/>
		<span style="text-transform: uppercase">	<?php echo $productlist->p_type; ?></span><br/>
			<span style="text-transform: capitalize"><?php echo $productlist->name; ?><span><br/>
			<!--<span style="text-transform: capitalize">Rs. <?php //echo $productlist->selling_price; ?><span>-->
            </div>  
        </div> 
        
        
        </td>
    </tr>
    </div>
    
    <?php } ?>
    
	<?php endforeach;?>
	
	</tbody>
      </table>
    
  </div>

 
  
</div>








