<?php class stockController extends CI_Controller{
	
		public function __construct(){
		parent::__construct();
			$this->is_login();
			$this->load->model("stock");
			$this->load->model("branch");
				$this->load->model("shop");
	}
	
	
		function is_login(){
		$is_login = $this->session->userdata('is_login');
	
		if(($is_login != true)){
			
			redirect("index.php/homeController/index");
		}
	
	}
	
	function defineCategory(){
		
			$data['pageTitle'] = 'Stock Section';
			$data['smallTitle'] = 'Progeny Alteratiom Of Subsctibing System';
			$data['mainPage'] = 'Stock Section';
			$data['subPage'] = 'Stock Section';
			$data['title'] = 'Stock Section in PASS';
			$data['headerCss'] = 'headerCss/stockCss';
			$data['footerJs'] = 'footerJs/stockJs';
			$data['mainContent'] = 'Admin/defineCategory';
			$this->load->view("includes/mainContent", $data);
	}
   function	newsaleproduct(){
            $data['pageTitle'] = 'Stock Section';
			$data['smallTitle'] = 'Progeny Alteratiom Of Subsctibing System';
			$data['mainPage'] = 'Stock Section';
			$data['subPage'] = 'Stock Section';
			$data['title'] = 'Stock Section in PASS';
			$data['headerCss'] = 'headerCss/stockCss';
			$data['footerJs'] = 'footerJs/stockJs';
			$data['mainContent'] = 'newsaleproduct';
			$this->load->view("includes/mainContent", $data);
	    
	}
	function direct(){
	    $data['number']=$this->input->post("numrow");
	     $data['comm']=$this->input->post("comm");
	    
	    $this->load->view("direct",$data);
	}
	function addCategory(){
		$stream=$this->input->post('streamName');
		$streamList = $this->stock->insert_Category($stream);
		//print_r($streamList);
		$data['streamList'] = $streamList;
		$this->load->view("ajax/addCategory",$data);
	}
	
	function directsale(){
	   $ordernumber= str_replace(' ','',$this->input->post("comm"));
	  
	  $total= $this->input->post("total");
	  $number= $this->input->post("number");
	   $paid= $this->input->post("paid");
	   $this->db->where("username",$ordernumber);
	   $cust=$this->db->get("customers");
	   
	   if($cust->num_rows()>0){
	       
	       
	  $dt=date("dmy",strtotime(date("y-m-d")));
      $b_code   = $this->session->userdata("id");

      $billno   = $this->db->count_all("invoice_serial");
      $billno   = $billno + 1000;
      $bill_no  = $dt.$b_code."I".$billno;
      $utt=$ordernumber;

  for($i=1; $i<=15;$i++)
  {
    if(strlen($this->input->post("item_name$i"))>0)
    {
    $data = array(
        "p_code" => $this->input->post("itemid$i"),
        "p_name" => $this->input->post("item_name$i"),
        "pries_per_item" => $this->input->post("item_price$i"),
        "item_quant" => $this->input->post("item_quantity$i"),
        "sub_total" => $this->input->post("sub_total$i"),
        "category" => $this->input->post("item_catid$i"),
        
        "date"=> date("Y-m-d"),
        "bill_no" =>$bill_no,
        "subbranch_code"=>$this->session->userdata("id")
      );
          $tablename='product_sale';
         // $this->load->model("registration1");
           $this->db->insert("product_sale",$data);
         $var1= $this->db->insert_id();
        // print_r($var1);
         // exit();
    }


      


     $bal = array(
            
             "paid" => $this->input->post("paid"),
             "total"=> $this->input->post("total"),     
             "date"=> date("Y-m-d"),
              "bill_no" =>$bill_no,
              "valid_id" => $ordernumber,
             
              "subbranch_code"=>$this->session->userdata("id")
           );
              $this->db->insert("product_saletotal",$bal);
              
      if($var1):
        $invoiceData = array(
          "invoice_no" => $bill_no,
          "reason" => "Sale Invoice",
          "invoice_date" => date("Y-m-d"),
          "subbranch_id"=>$this->session->userdata("id")
        );
          $this->db->insert("invoice_serial",$invoiceData);
        
            $this->db->where("id",$var1);
            $dt3=$this->db->get("product_sale")->row();
            
            $this->db->where("bill_no",$bill_no);
            $data5=$this->db->get("product_saletotal")->row();
            // print_r($data5);
            // exit();
            $p_code= $dt3->p_code;
            $this->db->where("p_code",$p_code);
           // $this->db->or_where("sec",$p_code);
            $this->db->where("subbranch_id",$b_code);
            $var=$this->db->get("subbranch_wallet");
            
        if($var->num_rows() > 0):
         $row=  $var->row();
            $q = $row->rec_quantity;
            $totsel = $row->sale_quantity;
          
            $saleqn =$q - $dt3->item_quant;
             $recqn= $totsel + $dt3->item_quant;
             
           
            $data33 = array(
              "rec_quantity" => $saleqn,
              "sale_quantity" => $recqn
             
            );
           
           $this->db->where("p_code",$p_code);
           $this->db->where("subbranch_id",$b_code);
           // $this->db->or_where("sec",$p_code);
           $var3=$this->db->update("subbranch_wallet",$data33);
     
                   
        endif;
      endif;
	       
  }     
	       
	  $pamt= $this->input->post('paid');
         
           $username=$this->session->userdata("username");
           
             $this->db->where("login_username",$username);
          $this->db->where("opening_date",date('Y-m-d'));
         $op1 =  $this->db->get("opening_closing_balance");
       
            $balance = $op1->closing_balance;
           $close1 = $balance + $pamt;

           $bal = array(
            "closing_balance" => $close1
          );
          $this->db->where("login_username",$username);
          $this->db->where("opening_date",date('Y-m-d'));
          $this->db->update("opening_closing_balance",$bal);    
          
	         $daybook=array(
           "amount" =>$pamt,
           "pay_date"=> date("Y-m-d"),
           "reason" =>"From sale Stock",
           "pay_mode"=>"Cash",
           "dabit_cradit"=>"1",
           "closing_balance" => $close1,
           "paid_to" =>$this->session->userdata("username"),
           "invoice_no" => $bill_no,
           "paid_by"=> $utt
        
       );
     $dd=  $this->db->insert("day_book", $daybook);
	    ?>   
	        <script>
            alert('Product Sell successfully');
            </script>;
            <?php  
          
                      $this->db->where("username",$utt);
                      $data= $this->db->get("customers")->row();
                     
                      $count=0;
                      $sender = $this->db->get("sms_setting")->row();
                      $sende_Detail =$sender;
                      $msg = "Dear Sir Thanks For Shopping With  Us. Your Shopping Amount is Rs - ".$this->input->post("total")." /- Thank You .";
                      $mobileno =	$data->mobile;
                      
                    sms($mobileno,$msg,$sende_Detail->uname,$sende_Detail->password,$sende_Detail->sender_id);
                      
                     $totamt= $this->input->post("total");
                     $prcntamt= 2;
                     $prcnt=$totamt * $prcntamt;
                     $totprcnt =$prcnt/100 ;
                    $this->db->where("username",$utt);
                      $dt2=$this->db->get("customers")->row();
                     
                     $this->db->where("cid",$dt2->id);
                  $pvresult = $this->db->get("pv");
                  if($pvresult->num_rows()>0){
                       $pv2=$pvresult->row()->rupee; 
                  }else{
                       $pv2=0; 
                  }
                  
                    $newpv=$pv2+$totprcnt;
                    $pv1=array(
                    "rupee"=>$newpv
                    );
                    $this->db->where("cid",$dt2->id);
                     $uppv= $this->db->update("pv",$pv1);
                     $msg = "Dear Sir Thanks For Shopping With  Us. Your CashBack Amount is Rs - ".$totprcnt." /- Thank You .";
                      $mobileno =$data->mobile;
                      
                     sms($mobileno,$msg,$sende_Detail->uname,$sende_Detail->password,$sende_Detail->sender_id);
                
                       //$id=$dt->parentID;
                     ////$this->db->where("id",$id);
                     //  $parentdt=$this->db->get("customers")->row();
                    //$cid=$parentdt->username;

                     
                    $i=1;
                
                   $data3= $this->shop->commision($i,$utt,$totamt,$bill_no);
                   
                   if($data3){ ?>
                       <script>
                           window.location.href="<?php echo base_url();?>shopController/saleInvoice/<?php echo $bill_no;?>";
                       </script>
                        <!--redirect('shopController/saleInvoice/'.$bill_no);-->
                  <?php  }
	       
	       
	   }else{
	       
	       
	       
	       //   $this->db->where("order_no",$ordernumber);
	       $this->db->where('order_no',$ordernumber);
            $dt= $this->db->get("order_serial");
      
//   print_r($dt);
//   exit();
  if($dt->num_rows()>0){
     $data= $dt->row();

    //   $orderno = array(
    //       "order_no" =>$this->input->post("orderno"),
    //         "sub_branchid" => $this->session->userdata("id")
    //       );
      
    //   $dt=$this->db->insert("shopbill",$orderno);
    
      
      $i=1;
      while( $i<= $number )
     { 
        
    if(strlen($this->input->post("item_name".$i))>0)
     {
     
    $data2 = array(
        "p_code" => $this->input->post("itemid".$i),
        //"p_name" => $this->input->post("item_name".$i),
        "price" => $this->input->post("item_price$i"),
        "quantity" => $this->input->post("item_quantity$i"),
        "subtotal" => $this->input->post("sub_total$i"),
        "order_no" =>$ordernumber,
        "sub_branchid" => $this->session->userdata("id"),
        
        "date"=> date("Y-m-d"),
        "cust_id"=>$data->cust_id
        
      );
          
         
          $var1= $this->db->insert("shopbill",$data2);
           print_r($var1);
     // exit();
  } 
    $i++; }
   // exit;
   $this->db->where("order_no",$ordernumber);
   $var=$this->db->get("shopbill");
        if($var->num_rows() > 0){
            
           foreach($var->result() as $row):
            $q = $row->quantity;
          //  $totsel = $row->sale_quantity;
            $bid= $this->session->userdata("id");
            $this->db->where("p_code",$row->p_code);
            $this->db->where("subbranch_id",$bid);
            $subdt=$this->db->get("subbranch_wallet");
            if($subdt->num_rows()>0){
               $subbranchdata= $subdt->row();
            $squan = $subbranchdata->sale_quantity;
            $rquan = $subbranchdata->rec_quantity;
        
                 
            $data1 = array(
              "rec_quantity" => ($rquan - $q),
              "sale_quantity" => ($squan + $q),
              "date" =>  date("y-m-d")
            );
           
           $this->db->where("p_code",$row->p_code);
            $this->db->where("subbranch_id",$bid);
           $var=$this->db->update("subbranch_wallet",$data1);
            }
     endforeach;
     if($var){
         ?>
         <script>alert("product fill succussfully");
         window.location.href="<?php echo base_url();?>shopController/invoice/<?php echo $ordernumber;?>";
         </script>
       <?php  
     }
    // redirect("shopController/invoice/".$ordernumber,"refresh"); 
}

}else{
    echo "You Have entered Wrong OrderNumber ";
}
	       
	       
	       
	       
	       
	   }
	    
	}

	function addsubCategory(){
		$subcatname=$this->input->post('subcatname');
		$catid=$this->input->post('catid');
	
		$streamList = $this->stock->insertsub_Category($subcatname,$catid);
		// print_r($streamList);
		$data['streamList'] = $streamList;
		$this->load->view("ajax/addsubCategory",$data);
	}
	function updatesubCategory(){
	   $streamId= $this->input->post("streamId");
	   $streamName= $this->input->post("stream_name");
	   $this->load->model('stock');
	    $query = $this->stock->updatesub_category($streamId,$streamName);
		if($query){
			?>
			<script>
			        $.post("<?php echo site_url('stockController/addsubCategory') ?>", function(data){
			            //alert(data);
			            $("#sectionList").html(data);
					});
			</script>
			<?php 
		}	
		
		}
	function updateCategory(){
	
		if($query = $this->stock->update_category($this->input->post("streamId"),$this->input->post("streamName"))){
			?>
			<script>
			        $.post("<?php echo site_url('stockController/addCategory') ?>", function(data){
			            $("#streamList1").html(data);
					});
			</script>
			<?php 
		}	
		
		}
		
	function deleteCategory(){
		$streamid = $this->input->post("streamId");
		if($query = $this->stock->delete_category($streamid)){
			?>
						<script>
						        $.post("<?php echo site_url('stockController/addCategory') ?>", function(data){
						            $("#streamList1").html(data);
								});
						</script>
						<?php 
		}
		
	}

	function deletesubCategory(){
		$streamid = $this->input->post("streamId");
		?> <script> alert("<?php echo $streamid;?>"); </script> <?php
		if($query = $this->stock->deletesub_category($streamid)){
			?>
						<script>
						        $.post("<?php echo site_url('stockController/addsubCategory') ?>", function(data){
						            $("#sectionList").html(data);
								});
						</script>
						<?php 
		}
		
	}
	
	
	
	public function getSection(){
		$streamid = $this->input->post("streamid");
		$streamName = $this->input->post("streamid");
		$this->load->model('configureClassModel');
		$query = $this->configureClassModel->getSection($streamid);
		//print_r($query->result());exit();
	
		echo '<option value="">--Select Section--</option>';
		foreach ($query->result() as $row){
			?>
					
						<?php   
	                           $this->db->where('id',$row->section);
					 	       $row2=$this->db->get('class_section')->row();
	
	                          ?>
						<option value="<?php echo $row2->id; ?>" ><?php echo $row2->section; ?></option>
					<?php 
				}
		}
		
		public function addProduct()
		{ 
			$data['pageTitle'] = 'Stock Section';
			$data['smallTitle'] = 'Progeny Alteratiom Of Subsctibing System';
			$data['mainPage'] = 'Add Product';
			$data['subPage'] = 'Add Product';
			$data['title'] = 'Add Product in PASS';
			$data['headerCss'] = 'headerCss/stockCss';
			$data['footerJs'] = 'footerJs/branchListJs';
			$data['mainContent'] = 'stock/addProduct';
			$this->load->view("includes/mainContent", $data);
		}
		

		function getsubcat() {

			$tid = $this->input->post("classv");
		
			$var = $this->stock->getSubcat1($tid);
				if($var->num_rows() > 0){
				?>
	
	<option value="">-Select Sub Category-</option>
	
	<?php
					foreach ($var->result() as $row)
					{?>
	
	<option value="<?php echo $row->id;?>"><?php echo $row->name;?></option>
	
	<?php }
	
				}
		}

		public function addproduct_value(){
			//$this->load->model('registration1');
		 /// $photo_name1 = time().trim($_FILES['file1']['name']);
	$price=	 $this->input->post('price');
		$quantity= $this->input->post('quantity');
		$pamt=$price*$quantity;
			 $photo_name1 = time().trim($_FILES['file1']['name']);
			 $offer_image = time().trim($_FILES['file3']['name']);
			 $photo_name2 = time().trim($_FILES['file2']['name']);
			$proendate=date('Y-m-d');
			$value['sub_category']=$this->input->post('sub_category');
			$value['company']=$this->input->post('cname');
			$value['p_type']=$this->input->post('scname');
			$value['name']=$this->input->post('name');
			$value['size']=$this->input->post('size');
			$value['quantity']=$quantity;
			$value['selling_price']=$price;
			$value['hsn']=$this->input->post('p_code');
			$value['sec']=$this->input->post('sno');
			$value['proen_date']=$proendate;
			$value['protrans_date']=date('Y-m-d');
				$this->load->library('upload');
				//$image_path = realpath(APPPATH . '../assets/productimg/');
				$asset_name=$this->db->get("upload_asset")->row()->asset_name;
				$image_path=$asset_name.'/productimg';

					$config['upload_path'] = $image_path;
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size'] = '50';
	
		 
			if (!empty($_FILES['file1']['name'])) {
						 $config['file_name'] = $photo_name1;
						 $this->upload->initialize($config);
					 $f1= $this->upload->do_upload('file1');
							$value['file1']=$photo_name1;
						 }
			 if (!empty($_FILES['file3']['name'])) {
							$config['file_name'] = $offer_image;
						 $this->upload->initialize($config);
						 $f3=  $this->upload->do_upload('file3');
						$value['file3']=$offer_image;
	
					}
			 if (!empty($_FILES['file2']['name'])) {
						$config['file_name'] = $photo_name2;
						 $this->upload->initialize($config);
						 $f2=  $this->upload->do_upload('file2');
							$value['file2']=$photo_name2;
					}
			//$tablename='stock_products';
			
	
			$sb=$this->db->insert("stock_products",$value);
			if($sb){?>

				<?php            $this->db->where('id',$sb);
								 $product=$this->db->get('stock_products');
			
			
				   if($product->num_rows()>0)
				   {   $pdata= $product->row();

					$username=$this->session->userdata("username");
				  
					$op1 = $this->db->query("select closing_balance from opening_closing_balance where opening_date='".date('Y-m-d')."' AND login_username='$username'")->row();
					$balance = $op1->closing_balance;
					$close1 = $balance - $pamt;
					
					

					 $data1=array(
					 'p_code'=>$pdata->hsn,
					'bill_no'=>$this->input->post('invoice_no'),
					'cgst'=>$this->input->post('cgst'),
					'sgst'=>$this->input->post('sgst'),
					 'totalamount'=>$this->input->post('totamount'),
					 'quantity'=>$this->input->post('quantity')
					 );
				
					 $stpurches=$this->db->insert('stockpurchase_bill',$data1);

					 $bill_no=$this->input->post('invoice_no');	
					 $daybook=array(
					  "amount" =>$pamt,
					  "pay_date"=> date("Y-m-d"),
					  "reason" =>"Product Purchase",
					  "pay_mode"=>"Cash",
					  "dabit_cradit"=>"0",
					  "closing_balance" => $close1,
					  "paid_to" => "Software",
					  "invoice_no" => $bill_no,
					  "paid_by"=> $this->session->userdata("username")
				   
				  );
				
				  $this->db->where('invoice_no',$bill_no);
				  $dt1 = $this->db->get("day_book");
				  if($dt1->num_rows()>0){
				$dt=$dt1->row();
					$invoiceno=$dt->invoice_no;
					$amt=$dt->amount;
					$amount=$amt+$pamt;
					$daybook1=array(
					  "amount" =>$amount,
					  "pay_date"=> date("Y-m-d"),
					  "reason" =>"From sale Stock",
					  "pay_mode"=>"Cash",
					  "dabit_cradit"=>"0",
					  "closing_balance" => $close1,
					  "paid_to" => "Software",
					  "invoice_no" => $invoiceno,
					  "paid_by"=> $this->session->userdata("username")
				   
				  );
					$this->db->where('invoice_no',$invoiceno);
				   
					 $this->db->update("day_book", $daybook1);
				  }
				  else{
					 $this->db->insert("day_book", $daybook);
				  }
				
					
					$bal = array(
					  "closing_balance" => $close1
					);
					$this->db->where("login_username",$username);
					$this->db->where("opening_date",date('Y-m-d'));
					$this->db->update("opening_closing_balance",$bal);
				  
				   }
				  
				   
				?>
				<script>
				alert("Product Added Successfully");
				window.location.href="<?php echo base_url();?>stockController/addproduct";
				</script>
				<?php
				// 		 redirect('stockController/addproduct','refresh');
					}
				
				  else{
					echo "hello";
				  }
				}
				
	
	public function updatequantity(){

     
					$hsn=$this->input->post("hsn");
					$newhsn=$this->input->post("hsn1");
					$Qt=$this->input->post("Qt");
					$price=$this->input->post("price");
					$sec=$this->input->post("sec");
				 if($sec ||  $price ||  $Qt){
					 $data=array(
					  'quantity' =>$Qt,
					  'proen_date'=>date('Y-m-d'),
					  'selling_price'=>$price, 
					  'sec'=> $sec, 
					  'hsn'=> $newhsn, 
					);
					
			  
				   $this->db->where('hsn',$hsn);
				   $upadteee=$this->db->update('stock_products',$data);
			  
					 $this->db->where('hsn',$hsn);
					 $stockupadte=$this->db->get('stock_products')->row();
			   
					 $totpuramt=$this->input->post('total_amount');
					 if($totpuramt){
					 $data1=array(
					'p_code'=>$hsn,
				   'bill_no'=>$this->input->post('invoice_no'),
				   'cgst'=>$this->input->post('cgst'),
				   'sgst'=>$this->input->post('sgst'),
					'totalamount'=>$this->input->post('total_amount'),
					'quantity'=>$this->input->post("Qt1"),
					);
			   
				   $stpurches=$this->db->insert('stockpurchase_bill',$data1);
			  
				   $username=$this->session->userdata("username");
				
				   $op1 = $this->db->query("select closing_balance from opening_closing_balance where opening_date='".date('Y-m-d')."' AND login_username='$username'")->row();
				   $balance = $op1->closing_balance;
					  $close1 = $balance->$totpuramt;
				  $bal = array(
					"closing_balance" => $close1
				  );
				  $this->db->where("login_username",$username);
				  $this->db->where("opening_date",date('Y-m-d'));
				  $this->db->update("opening_closing_balance",$bal);
				
				  $bill_no=$this->input->post('invoice_no');	
				  $daybook=array(
				   "amount" =>$totpuramt,
				   "pay_date"=> date("Y-m-d"),
				   "reason" =>"From sale Stock",
				   "pay_mode"=>"Cash",
				   "dabit_cradit"=>"0",
				   "closing_balance" => $close1,
				   "paid_to" => "Software",
				   "invoice_no" => $bill_no,
				   "paid_by"=> $this->session->userdata("username")
				
			   );
			   
			  
				$this->db->where('invoice_no',$bill_no);
			  
			   $dt1 = $this->db->get("day_book");
			   if($dt1->num_rows()>0){
			  $dt=$dt1->row();
				 $invoiceno=$dt->invoice_no;
				 $amt=$dt->amount;
				 $amount=$amt+$totpuramt;
				  $daybook1=array(
					"amount" =>$amount,
					"pay_date"=> date("Y-m-d"),
					"reason" =>"From sale Stock",
					"pay_mode"=>"Cash",
					"dabit_cradit"=>"0",
					"closing_balance" => $close1,
					"paid_to" => "Software",
					"invoice_no" => $invoiceno,
					"paid_by"=> $this->session->userdata("username")
				 
				);
				  $this->db->where('invoice_no',$invoiceno);
				 
				   $this->db->update("day_book", $daybook1);
				}
			   else{
				$this->db->insert("day_book", $daybook);
				 }
			   }
			  
				   if( $upadteee || $stpurches){
				   echo "<h5>Quantity Updated...</h5>";
					}
					else
					{
			  
					  echo "Not Upadte";
					}
					
				 }
				 else
				 {
					  echo "<h5>Soory! Not  Updated!Please Fill...</h5>";
					 
				 }
			  }

			  function checkp_billno(){ 
				$pBalance = array();
				$tid = $this->input->post("cat");
				
				$this->db->where("bill_no",$tid);
				$var=$this->db->get("stockpurchase_bill");
				
				
				if($var->num_rows() > 0){
				    $row=$var->row();	
					$msg = '<div class="alert alert-success">Invoice No. Found ! <strong>'. strtoupper($row->bill_no).' </strong></div>';
					$pBalance['msg'] = $msg;
					$pBalance['indicator'] = "true";
					$pBalance['cgst'] = $row->cgst;
					$pBalance['sgst'] = $row->sgst;
					$pBalance['bill_no'] = $row->bill_no;
					$pBalance['totalamount'] = $row->totalamount;
				   
					echo (json_encode($pBalance));
				}
				
			  }
	
	function stocklist(){
		$data['pageTitle'] = 'Stock List';
		$data['smallTitle'] = 'Progeny Alteratiom Of Subsctibing System';
		$data['mainPage'] = 'Stock List';
		$data['subPage'] = 'Stock List';
		$data['title'] = 'Stock Section in PASS';
		$data['headerCss'] = 'headerCss/stockCss';
		$data['footerJs'] = 'footerJs/stockJs';
		$data['mainContent'] = 'stock/stocklist';

		if($this->session->userdata('login_type')==1){
		//	$this->db->select("id");
			$data['product_id']  =$this->db->get("stock_products");
			
		}
		else{
			if($this->session->userdata('login_type')==2){
			//	$this->db->select("p_code");
				$this->db->where("branch_id",$this->session->userdata("id"));
				$data['product_id']  =$this->db->get("branch_wallet");
				
			}else{
				if($this->session->userdata('login_type')==4){
				//	$this->db->select("p_code");
					$this->db->where("subbranch_id",$this->session->userdata("id"));
					$data['product_id']  =$this->db->get("subbranch_wallet");
					
			}
		}
		
	
		}
			$this->load->view("includes/mainContent", $data);
	}
	public function todaysubbranchstock(){
		$data['pageTitle'] = 'Stock List';
		$data['smallTitle'] = 'Progeny Alteratiom Of Subsctibing System';
		$data['mainPage'] = 'Stock List';
		$data['subPage'] = 'Stock List';
		$data['title'] = 'Shop Sale product';
		$data['headerCss'] = 'headerCss/stockCss';
		$data['footerJs'] = 'footerJs/stockJs';
		$data['mainContent'] = 'stock/todaysubbranchstock';
		//$data['header'] = 'header';
		//$data['sidemenu'] = 'sidemenu';
		//$data['customizer'] = 'customizer';
		//$data['footer'] = 'footer';
		$this->load->view("includes/mainContent", $data);
		}
		public function sale_product(){
			$data['pageTitle'] = 'Sale Product';
		$data['smallTitle'] = 'Sale Product';
		$data['mainPage'] = 'Sale Product';
		$data['subPage'] = 'Sale Product';
      $data['title'] = 'Sale product';
      $data['headerCss'] = 'headerCss/branchListCss';
	  $data['footerJs'] = 'footerJs/saleJs';
      $data['mainContent'] = 'stock/sale_product';

      $this->load->view("includes/mainContent", $data);
       
  } 
  public function producttransfer(){
		$data['pageTitle'] = 'Product Transfer';
		$data['smallTitle'] = 'Product Transfer';
		$data['mainPage'] = 'Product Transfer';
		$data['subPage'] = 'Product Transfer'; 
		$data['title'] = 'Product Transfer';
		$data['headerCss'] = 'headerCss/branchListCss';
		$data['footerJs'] = 'footerJs/producttransfer';
		$data['mainContent'] = 'stock/producttransfer';
		$this->load->view("includes/mainContent", $data);
		
	} 
   function checkuser(){ 
        
        $tid = $this->input->post("classv");
     //   print_r($tid);
        //$this->load->model("registration1");
        $var = $this->stock->checkjoinerid($tid);
        if($var->num_rows()>0){
            $dt=$var->row();
          echo "tt";
            
           // print_r($dt); 
       
      }
      else
      {
          echo "<span style='color:red'>user not exits</span>";
      }
    }
     public	function checkStock(){

		//$msg = '<div class="alert alert-info"><button data-dismiss="alert" class="close">&times;</button><strong><h3>New Item Entry :)</h3> </strong></div>';
    $itemNo = str_replace(' ','',$this->input->post("name"));
    
  
   
	//$this->load->model("Producttransfer");

    $var = $this->stock->checkStockp($itemNo);
		if($var->num_rows() > 0){
		    $row=$var->row();
		  //   print_r($row);
		  //     exit();
	$this->db->where("sec",$row->sec);
   // $this->db->or_where("sec",$row->sec);
    $req = $this->db->get("stock_products")->row();
    
    $catid=$req->sub_category;
    $this->db->where("id",$catid);
    $dt = $this->db->get("sub_category");
    if($dt->num_rows() > 0){
        
			
                $cat=$dt->row();
				$itemData = array(
				    "itemid" =>$req->id,
						"itemName" =>$req->name,
                         "itemCat" =>$cat->name,
                         "itemCatid" =>$cat->id,
						"itemsize" =>$req->size,
						"price" =>$req->selling_price,
						"qunatity"=>$row->rec_quantity,
						"msg" => ""
				);
			}
		
		else{
			$itemData = array(
					"itemName" =>"",
          "itemCat" =>"",
          "itemCatid" =>"",
					"itemsize" =>"",
					"price" =>"",
					"itemQuantity"=>"",
					"msg" => $msg
			);
		}
		
    echo (json_encode($itemData));
  }
  else{
echo "some configuration mistake in this product. plz contact admin.";

  }
  }
  
  
function activestockitem(){
	$rowid  = $this->input->post("rowid");
	$currentstatus =$this->input->post("currentstatus");
	if($currentstatus==1){
		$updateStatus=array(
				"status"=>0
		);
	$this->db->where("id",$rowid);
	$this->db->update("stock_products",$updateStatus);
	echo "Inactive";

	} else{
		$updateStatus=array(
				"status"=>1
		);
		$this->db->where("id",$rowid);
	$this->db->update("stock_products",$updateStatus);
	echo "Active";
	}
}


function deletestockitem(){
	$id= $this->input->post("rowid");
    $this->db->where("id",$id);
    $dt=$this->db->delete("stock_products");
    if($dt)
    {
	    echo "deleted";
	    
    }
   // redirect(base_url().'index.php/create_meeting/5','refresh');
}

function checkp_code(){ 
    $pBalance = array();
    $tid = $this->input->post("cat");
   
    $this->db->where("hsn",$tid);
    $var1=$this->db->get("stock_products")->row();
    $this->db->where('id',$var1->sub_category);
      $subcate=$this->db->get('sub_category')->row();
      
      $this->db->where('id',$subcate->cat_id);
      $cate=$this->db->get('category')->row();
    
      $this->db->where("hsn",$tid);
    $var=$this->db->get("stock_products");
  
    if($var->num_rows() > 0){
      $row=$var->row();	
        $msg = '<div class="alert alert-success">Product Found ! <strong>'. strtoupper($row->name).'</strong>--<span>Here You Can Only  Update The Quantity</span></div>';
        $pBalance['msg'] = $msg;
        $pBalance['indicator'] = "true";
        $pBalance['hsn'] = $row->hsn;
        $pBalance['cname'] = $row->company;
        $pBalance['name'] = $row->name;
        $pBalance['quantity'] = $row->quantity;
        $pBalance['sno'] = $row->sec;
        $pBalance['scname'] = $row->p_type;
        $pBalance['size'] = $row->size;
        $pBalance['price'] = $row->selling_price;
        $pBalance['cat'] = $cate->name;
        $pBalance['subcat'] =$subcate->name;
      
        echo (json_encode($pBalance));
    }
  }
  function editstockitem(){
         $data['id']=$this->uri->segment(3);
	$data['pageTitle'] = 'Stock Section';
	$data['smallTitle'] = 'Progeny Alteratiom Of Subsctibing System';
	$data['mainPage'] = 'Stock Section';
	$data['subPage'] = 'Stock Section';
	$data['title'] = 'Stock Section in PASS';
	$data['headerCss'] = 'headerCss/stockCss';
	$data['footerJs'] = 'footerJs/stockJs';
	$data['mainContent'] = 'Admin/editstock'; 
	$this->load->view("includes/mainContent", $data);
}

    function get_sub_cat()
    {
        $cat_id = $this->input->post('cat_id');
        $this->db->where('cat_id',$cat_id);
        $sb_dt = $this->db->get('sub_category');
        if($sb_dt->num_rows()>0)
        {
            foreach($sb_dt->result() as $sbdtt)
            { ?>
                  <option value="<?= $sbdtt->id;?>"><?= $sbdtt->name;?></option>
            <?php }
        }
        else
        {
            echo "N/A";
        }
    }
    function change_cat()
    {
        $id = $this->input->post('id');
        // $cat_id = $this->input->post('cat_id');
        $sub_cat_id = $this->input->post('sub_cat_id');
        $val= array('sub_category'=>$sub_cat_id);
        $this->db->where("id",$id);
        $row= $this->db->update("stock_products",$val);
        if($row)
        { 
            echo "yes";
        }
        else
        {
            echo "no";
        }
    }

  function productdetail(){
         $data['invoice']=$this->uri->segment(3);
	$data['pageTitle'] = 'Transfer Product Details';
	$data['smallTitle'] = 'Transfer Product Details';
	$data['mainPage'] = 'Transfer Product Details';
	$data['subPage'] = 'Transfer Product Details';
	$data['title'] = 'Transfer Product Details';
	$data['headerCss'] = 'headerCss/stockCss';
	$data['footerJs'] = 'footerJs/stockJs';
	$data['mainContent'] = 'Shop/productdetail'; 
	$this->load->view("includes/mainContent", $data);
}
public function generatebill(){  
     // exit;
      $ordernumber=$this->input->post("orderno");
      
    // print_r($ordernumber);
     // exit();
   $this->db->where("order_no",$ordernumber);
  $dt= $this->db->get("order_serial");
  
  if($dt->num_rows()>0){
     $data= $dt->row();
    
 // print_r($data);
 // exit();
    //   $orderno = array(
    //       "order_no" =>$this->input->post("orderno"),
    //         "sub_branchid" => $this->session->userdata("id")
    //       );
      
    //   $dt=$this->db->insert("shopbill",$orderno);
      
      for($i=1; $i<=15;$i++)
   {
    if(strlen($this->input->post("item_name$i"))>0)
    {
       
    $data2 = array(
        "p_code" => $this->input->post("item_no$i"),
        //"p_name" => $this->input->post("item_name$i"),
        "price" => $this->input->post("item_price$i"),
        "quantity" => $this->input->post("item_quantity$i"),
        "subtotal" => $this->input->post("sub_total$i"),
        "order_no" =>$this->input->post("orderno"),
        "sub_branchid" => $this->session->userdata("id"),
        
        "date"=> date("Y-m-d"),
        "cust_id"=>$data->cust_id
        
      );
         
         
          $var1= $this->db->insert("shopbill",$data2);
          
  } 
   }
   $this->db->where("order_no",$ordernumber);
   $var=$this->db->get("shopbill");
        if($var->num_rows() > 0){
            
           foreach($var->result() as $row):
            $q = $row->quantity;
          //  $totsel = $row->sale_quantity;
            $bid= $this->session->userdata("id");
            $this->db->where("p_code",$row->p_code);
            $this->db->where("subbranch_id",$bid);
            $subdt=$this->db->get("subbranch_wallet");
            if($subdt->num_rows()>0){
               $subbranchdata= $subdt->row();
            $squan = $subbranchdata->sale_quantity;
            $rquan = $subbranchdata->rec_quantity;
        
                 
            $data1 = array(
              "rec_quantity" => ($rquan - $q),
              "sale_quantity" => ($squan + $q),
              "date" =>  date("y-m-d")
            );
           
           $this->db->where("p_code",$row->p_code);
            $this->db->where("subbranch_id",$bid);
           $var=$this->db->update("subbranch_wallet",$data1);
            }
     endforeach;
     if($var){
         ?>
         <script>alert("product fill succussfully");
         window.location.href="<?php echo base_url();?>shopController/invoice/<?php echo $ordernumber;?>";
         </script>
       <?php  
     }
    // redirect("shopController/invoice/".$ordernumber,"refresh"); 
}

}else{
    echo "You Have entered Wrong OrderNumber ";
}
 }
public function edit(){
	$id= $this->uri->segment(3);
	   $photo_name1 = time().trim($_FILES['file1']['name']);
		$photo_name2 = time().trim($_FILES['file2']['name']);
		$photo_name3 = time().trim($_FILES['file3']['name']);
	   //  $photo_name4 = time().trim($_FILES['file4']['name']);
	   $value['p_type']=$this->input->post('ptype');
	   $value['name']=$this->input->post('name');
	   // $value['sub_category']=$this->input->post('sub_category');
	   $value['company']=$this->input->post('company');
	   $value['size']=$this->input->post('size');
	   // $value['quantity']=$this->input->post('quantity');
	   $value['selling_price']=$this->input->post('price');
	   // $value['hsn']=$this->input->post('hsn');
	   $value['sec']=$this->input->post('sec');
	   // $value['proen_date']=date('y-m-d h:s:i');
	   // $value['protrans_date']=date('y-m-d h:s:i');
	//===========    pcode
	$this->load->library('upload');
	
	$asset_name=$this->db->get("upload_asset")->row()->asset_name;
	$image_path=$asset_name.'/productimg';

	$config['upload_path'] = $image_path;
	$config['allowed_types'] = 'jpg|jpeg|png';
	$config['max_size'] = '5120';

	if (!empty($_FILES['file1']['name'])) { 
	  	$config['file_name'] = $photo_name1;
	   $this->upload->initialize($config);
		$this->upload->do_upload('file1');
		$value['file1']=$photo_name1;
		}
		if (!empty($_FILES['file2']['name'])) {
			$config['file_name'] = $photo_name2;
			$this->upload->initialize($config);
			 $this->upload->do_upload('file2');
			 $value['file2']=$photo_name2;
			}
			if (!empty($_FILES['file3']['name'])) {
				$config['file_name'] = $photo_name3;
			   $this->upload->initialize($config);
				$this->upload->do_upload('file3');
			  $value['file3']=$photo_name3;
	
			}
	//////////////////pcode end   
		
   
	  
		
	   //  if (!empty($_FILES['file4']['name'])) {
	   //       $config['file_name'] = $photo_name4;
	   //       $this->upload->initialize($config);
	   //         $this->upload->do_upload('file4');
	   //         $value['file4']=$photo_name4;
	   //     }
	   // $value['pan_no']=$this->input->post('pan');
	   // $value['city']=$this->input->post('city');
	   // $value['mob_no']=$this->input->post('mobile');
	   // value['gst_no']=$this->input->post('gst');
   
	  // $tablename='stock_products';
	   $this->db->where("id",$id);
	   $sb=$this->db->update("stock_products" ,$value);
	   if($sb){?>
   <script>
   alert("your Product Updated Successfully");
   window.location.href="<?php echo base_url();?>stockController/editstockitem/<?= $id;?>";
   </script>
   <?php
// 			redirect('stockController/stocklist','refresh');
	   }
   }
	 

  public function generate_invoice(){
    $recieverusername =$this->uri->segment("3");
    $date=Date("y-m-d");
    $dt=date("dmy",strtotime($date));
    // $senderusername=$this->session->userdata("username");
    $count=$this->db->Count_All("product_trans_detail");
     $invoice = $dt."PTI".$count;
    
    if($this->session->userdata("login_type")=="1"){
    
       
        
    $this->db->where("Date(date)",$date);
    $this->db->where("reciver_usernm",$recieverusername);
    $this->db->where("invoice_number",0);
    $data=$this->db->get("product_trans_detail");
   if($data->num_rows()>0){
       $arr=array(
           "invoice_number"=>$invoice
           );
             $this->db->where("Date(date)",$date);
    $this->db->where("reciver_usernm",$recieverusername);
    $this->db->where("invoice_number"," ");
    $update=$this->db->update("product_trans_detail",$arr);
    if($update){
       $arr1= array(
           "invoice_no"=>$invoice,
           "sender_username"=>$data->row()->sender_usernm,
            );
            $this->db->insert("assignproduct",$arr1);
        redirect("stockController/productinvoice/".$invoice);
        
    }
       
   }
    
        
    }
    
     elseif($this->session->userdata("login_type")=="2"){
    
       // $invoice1 = $count."BTO".$recieverusername;
        
    $this->db->where("Date(date)",$date);
    $this->db->where("reciver_usernm",$recieverusername);
    $this->db->where("invoice_number"," ");
    $data2=$this->db->get("product_trans_detail");
   if($data2->num_rows()>0){
       $arr1=array(
           "invoice_number"=>$invoice
           );
             $this->db->where("Date(date)",$date);
    $this->db->where("reciver_usernm",$recieverusername);
    $this->db->where("invoice_number"," ");
    $update1=$this->db->update("product_trans_detail",$arr1);
    if($update1){
         $arr1= array(
           "invoice_no"=>$invoice,
           "sender_username"=>$data2->row()->sender_usernm,
            );
            $this->db->insert("assignproduct",$arr1);
            redirect("stockController/productinvoice/".$invoice);
        // redirect("branchController/producttransfer");
        
    }
       
   }
    
        
    }
    
     elseif($this->session->userdata("login_type")=="4"){
    
       // $invoice2 = $count."STO".$recieverusername;
        
    $this->db->where("Date(date)",$date);
    $this->db->where("reciver_usernm",$recieverusername);
    $this->db->where("invoice_number"," ");
    $data3=$this->db->get("product_trans_detail");
   if($data3->num_rows()>0){
       $arr2=array(
           "invoice_number"=>$invoice
           );
             $this->db->where("Date(date)",$date);
    $this->db->where("reciver_usernm",$recieverusername);
    $this->db->where("invoice_number"," ");
    $update2=$this->db->update("product_trans_detail",$arr2);
    if($update2){
         $arr1= array(
           "invoice_no"=>$invoice,
           "sender_username"=>$data3->row()->sender_usernm,
            );
            $this->db->insert("assignproduct",$arr1);
            redirect("stockController/productinvoice/".$invoice);
        // redirect("stockController/producttransfer");
        
    }
       
   }
    
        
    }
    
    
   }	
           public function productinvoice(){
       	    $data['pageTitle'] = 'Product Transfer Invoice';
    		$data['smallTitle'] = 'Product Transfer Invoice';
    		$data['mainPage'] = 'Product Transfer Invoice';
    		$data['subPage'] = 'Product Transfer Invoice';
    		$data['title'] = 'Product Transfer Invoice';
    		$data['headerCss'] = 'headerCss/sublistCss';
    		$data['footerJs'] = 'footerJs/sublistJs';
    		$data['mainContent'] = 'Shop/productinvoice';
    		$this->load->view("includes/mainContent", $data);
       
   }
   
    public function genrateproductinvoice(){
          
           $data['invoice'] =$this->uri->segment(3);
          $data['title'] = 'Transfer Products Invoice';    
          $this->load->view("Shop/generateproductinvoicedetail", $data);

          }
   
   public function productstatus()
   {
        $pro_t_id = $this->uri->segment('3');
        $this->db->where('id',$pro_t_id);
        $pr_dt = $this->db->get('product_trans_detail');
        if($pr_dt->num_rows()>0)
        { 
            $ptdt = $pr_dt->row();
           if($this->session->userdata('login_type')==1)
           {
               
           }
           elseif($this->session->userdata('login_type')==2)
           {
              $this->db->where('branch_id',$this->session->userdata('id'));
              $this->db->where('p_code',$ptdt->p_code);
              $chk = $this->db->get('branch_wallet');
              if($chk->num_rows()>0)
                { //echo  $chk->row()->p_code;
                  if($chk->row()->rec_quantity >=0)
                  { 
                     $up_qt = $chk->row()->rec_quantity + $ptdt->quantity;
                     $val_a = array('rec_quantity'=>$up_qt);
                      $this->db->where('branch_id',$this->session->userdata('id'));
                      $this->db->where('p_code',$ptdt->p_code);
                      $chk = $this->db->update('branch_wallet',$val_a);
                      if($chk)
                      {
                          $this->db->where('username',$ptdt->sender_usernm);
                          $sub_b = $this->db->get('sub_branch');
                          if($sub_b->num_rows()>0)
                          {
                            $this->db->where('sub_branchid',$sub_b->row()->id);
                            $this->db->where('p_code',$ptdt->p_code);
                            $sub_bwallet = $this->db->get('subbranch_wallet')->row();
                            
                            $rmain_qt = $sub_bwallet->rec_quantity - $ptdt->quantity;
                            
                            $valb = array('rec_quantity'=>$rmain_qt);
                            $this->db->where('sub_branchid',$sub_b->row()->id);
                            $this->db->where('p_code',$ptdt->p_code);
                            $qt_up = $this->db->update('subbranch_wallet',$valb);
                            if($qt_up)
                            { 
                                            $arr_a=array("status"=>1);
                                            $this->db->where('id',$pro_t_id);
                                            $upp_dt = $this->db->update('product_trans_detail',$arr_a);
                                            if($upp_dt){        ?>
                                <script>
                                    alert("Recieved Successfully.");
                                    window.location.href="<?php echo base_url();?>shopController/recieveproductlist";
                                </script>
                            <?php } 
                            }
                            else
                            {
                                echo "Quantity not less in sender stock";
                            }
                          }
                          else
                            {
                                $this->db->where('admin_username',$ptdt->sender_usernm);
                                $admin_d = $this->db->get('general_settings');
                                if($admin_d->num_rows()>0)
                                {
                                    $this->db->where('id',$ptdt->p_code);
                                    $ad_wallet = $this->db->get('stock_products')->row();
                                    $rmain_qt = $ad_wallet->quantity - $ptdt->quantity;
                                    
                                    $valb = array('quantity'=>$rmain_qt);
                                    $this->db->where('id',$ptdt->p_code);
                                    $qt_up = $this->db->update('stock_products',$valb);
                                    if($qt_up)
                                    {
                                        $arr_a=array("status"=>1);
                                            $this->db->where('id',$pro_t_id);
                                            $upp_dt = $this->db->update('product_trans_detail',$arr_a);
                                            if($upp_dt){
                                    ?>
                                        <script>
                                            alert("Recieved Successfully.");
                                            window.location.href="<?php echo base_url();?>shopController/recieveproductlist";
                                        </script>
                                    <?php }
                                    }
                                    else
                                    {
                                        echo "Quantity not less in sender stock";
                                    }
                                }
                            }
                      }
                      else
                      {
                          echo "branch stock not updated";
                      }
                  }
                }
              else
                {
                  $this->db->where('id',$ptdt->p_code);
                  $st_dt = $this->db->get('stock_products')->row();
                  $vala = array( 'branch_id'=>$this->session->userdata('id'),
                                'p_code'=>$ptdt->p_code,
                                'date'=>date('Y-m-d'),
                                'sec'=>$st_dt->sec,
                                'rec_quantity'=>$ptdt->quantity
                      );
                      $in = $this->db->insert('branch_wallet',$vala);
                      if($in)
                        {
                          $this->db->where('username',$ptdt->sender_usernm);
                          $sub_b = $this->db->get('sub_branch');
                          if($sub_b->num_rows()>0)
                          {
                            $this->db->where('sub_branchid',$sub_b->row()->id);
                            $this->db->where('p_code',$ptdt->p_code);
                            $sub_bwallet = $this->db->get('subbranch_wallet')->row();
                            
                            $rmain_qt = $sub_bwallet->rec_quantity - $ptdt->quantity;
                            
                            $valb = array('rec_quantity'=>$rmain_qt);
                            $this->db->where('sub_branchid',$sub_b->row()->id);
                            $this->db->where('p_code',$ptdt->p_code);
                            $qt_up = $this->db->update('subbranch_wallet',$valb);
                            if($qt_up)
                            { 
                                 $arr_a=array("status"=>1);
                                            $this->db->where('id',$pro_t_id);
                                            $upp_dt = $this->db->update('product_trans_detail',$arr_a);
                                            if($upp_dt){         
                            ?>
                                <script>
                                    alert("Recieved Successfully.");
                                    window.location.href="<?php echo base_url();?>shopController/recieveproductlist";
                                </script>
                            <?php }
                            }
                            else
                            {
                                echo "Quantity not less in sender stock";
                            }
                          }
                          else
                            {
                                $this->db->where('admin_username',$ptdt->sender_usernm);
                                $admin_d = $this->db->get('general_settings');
                                if($admin_d->num_rows()>0)
                                {
                                    $this->db->where('id',$ptdt->p_code);
                                    $ad_wallet = $this->db->get('stock_products')->row();
                                    $rmain_qt = $ad_wallet->quantity - $ptdt->quantity;
                                    
                                    $valb = array('quantity'=>$rmain_qt);
                                    $this->db->where('id',$ptdt->p_code);
                                    $qt_up = $this->db->update('stock_products',$valb);
                                    if($qt_up)
                                    { 
                                             $arr_a=array("status"=>1);
                                            $this->db->where('id',$pro_t_id);
                                            $upp_dt = $this->db->update('product_trans_detail',$arr_a);
                                            if($upp_dt){
                                    ?>
                                        <script>
                                            alert("Recieved Successfully.");
                                            window.location.href="<?php echo base_url();?>shopController/recieveproductlist";
                                        </script>
                                    <?php }
                                    }
                                    else
                                    {
                                        echo "Quantity not less in sender stock";
                                    }
                                }
                            }
                        }
                        else
                        {
                            echo "product not insert in branch stock ";
                        }
                }
           }
           elseif($this->session->userdata('login_type')==4)
           {
                $this->db->where('subbranch_id',$this->session->userdata('id'));
                $this->db->where('p_code',$ptdt->p_code);
                $chk = $this->db->get('subbranch_wallet');
                if($chk->num_rows()>0)
                {
                  if($chk->row()->rec_quantity>=0)
                  {
                    //  $up_qt = $chk->row()->rec_quantity + $ptdt->quantity;
                     $up_qt = $chk->row()->rec_quantity + $ptdt->quantity;
                     $val_a = array('rec_quantity'=>$up_qt);
                      $this->db->where('subbranch_id',$this->session->userdata('id'));
                      $this->db->where('p_code',$ptdt->p_code);
                      $chk = $this->db->update('subbranch_wallet',$val_a);
                      if($chk)
                      {
                           $this->db->where('username',$ptdt->sender_usernm);
                          $br_d = $this->db->get('branch');
                          if($br_d->num_rows()>0)
                            {
                                $this->db->where('branch_id',$br_d->row()->id);
                                $this->db->where('p_code',$ptdt->p_code);
                                $b_wallet = $this->db->get('branch_wallet')->row();
                                
                                $rmain_qt = $b_wallet->rec_quantity - $ptdt->quantity;
                                
                                $valb = array('rec_quantity'=>$rmain_qt);
                                $this->db->where('branch_id',$br_d->row()->id);
                                $this->db->where('p_code',$ptdt->p_code);
                                $qt_up = $this->db->update('branch_wallet',$valb);
                                 if($qt_up)
                                    { 
                                             $arr_a=array("status"=>1);
                                            $this->db->where('id',$pro_t_id);
                                            $upp_dt = $this->db->update('product_trans_detail',$arr_a);
                                            if($upp_dt)
                                            {         
                                        ?>
                                                <script>
                                                    alert("Recieved Successfully.");
                                                    window.location.href="<?php echo base_url();?>shopController/recieveproductlist";
                                                </script>
                                    <?php   }
                                    }
                                    else
                                    {
                                        echo "Quantity not less in sender stock";
                                    }
                            }
                            else
                            {
                                $this->db->where('admin_username',$ptdt->sender_usernm);
                                $admin_d = $this->db->get('general_settings');
                                if($admin_d->num_rows()>0)
                                {
                                    $this->db->where('id',$ptdt->p_code);
                                    $ad_wallet = $this->db->get('stock_products')->row();
                                    $rmain_qt = $ad_wallet->quantity - $ptdt->quantity;
                                    
                                    $valb = array('quantity'=>$rmain_qt);
                                    $this->db->where('id',$ptdt->p_code);
                                    $qt_up = $this->db->update('stock_products',$valb);
                                    if($qt_up)
                                    { 
                                             $arr_a=array("status"=>1);
                                            $this->db->where('id',$pro_t_id);
                                            $upp_dt = $this->db->update('product_trans_detail',$arr_a);
                                            if($upp_dt){
                                    ?>
                                        <script>
                                            alert("Recieved Successfully.");
                                            window.location.href="<?php echo base_url();?>shopController/recieveproductlist";
                                        </script>
                                    <?php }
                                    }
                                    else
                                    {
                                        echo "Quantity not less in sender stock";
                                    }
                                }
                                else
                                {
                                    echo "sender not found";
                                }
                            }
                          
                      }
                      else
                      {
                          echo "branch stock not updated";
                      }
                  }
                }
                else
                {
                    $this->db->where('id',$ptdt->p_code);
                    $st_dt = $this->db->get('stock_products')->row();
                    $vala = array( 'subbranch_id'=>$this->session->userdata('id'),
                                'p_code'=>$ptdt->p_code,
                                'date'=>date('Y-m-d'),
                                'sec'=>$st_dt->sec,
                                'rec_quantity'=>$ptdt->quantity
                      );
                    $in = $this->db->insert('subbranch_wallet',$vala);
                    if($in)
                        {
                          $this->db->where('username',$ptdt->sender_usernm);
                          $br_d = $this->db->get('branch');
                          if($br_d->num_rows()>0)
                            {
                                $this->db->where('branch_id',$br_d->row()->id);
                                $this->db->where('p_code',$ptdt->p_code);
                                $b_wallet = $this->db->get('branch_wallet')->row();
                                
                                $rmain_qt = $b_wallet->rec_quantity - $ptdt->quantity;
                                
                                $valb = array('rec_quantity'=>$rmain_qt);
                                $this->db->where('branch_id',$br_d->row()->id);
                                $this->db->where('p_code',$ptdt->p_code);
                                $qt_up = $this->db->update('branch_wallet',$valb);
                                 if($qt_up)
                                    { 
                                             $arr_a=array("status"=>1);
                                            $this->db->where('id',$pro_t_id);
                                            $upp_dt = $this->db->update('product_trans_detail',$arr_a);
                                            if($upp_dt)
                                            {         
                                        ?>
                                                <script>
                                                    alert("Recieved Successfully.");
                                                    window.location.href="<?php echo base_url();?>shopController/recieveproductlist";
                                                </script>
                                    <?php   }
                                    }
                                    else
                                    {
                                        echo "Quantity not less in sender stock";
                                    }
                            }
                            else
                            {
                                $this->db->where('admin_username',$ptdt->sender_usernm);
                                $admin_d = $this->db->get('general_settings');
                                if($admin_d->num_rows()>0)
                                {
                                    $this->db->where('id',$ptdt->p_code);
                                    $ad_wallet = $this->db->get('stock_products')->row();
                                    $rmain_qt = $ad_wallet->quantity - $ptdt->quantity;
                                    
                                    $valb = array('quantity'=>$rmain_qt);
                                    $this->db->where('id',$ptdt->p_code);
                                    $qt_up = $this->db->update('stock_products',$valb);
                                    if($qt_up)
                                    { 
                                             $arr_a=array("status"=>1);
                                            $this->db->where('id',$pro_t_id);
                                            $upp_dt = $this->db->update('product_trans_detail',$arr_a);
                                            if($upp_dt){
                                    ?>
                                        <script>
                                            alert("Recieved Successfully.");
                                            window.location.href="<?php echo base_url();?>shopController/recieveproductlist";
                                        </script>
                                    <?php }
                                    }
                                    else
                                    {
                                        echo "Quantity not less in sender stock";
                                    }
                                }
                                else
                                {
                                    echo "sender not found";
                                }
                            }
                        }
                }
           }
        }
        else
        {
            echo "product transfer details not found";
        }
   }
   /////////////// pcode////////////
    function admin_to_other()
    {
        $data['pageTitle'] = 'Admin Product Transfer';
    	$data['smallTitle'] = 'Admin Product Transfer';
    	$data['mainPage'] = 'Admin Product Transfer';
    	$data['subPage'] = 'Admin Product Transfer';
    	$data['title'] = 'Admin Product Transfer';
    	$data['headerCss'] = 'headerCss/stockCss';
    	$data['footerJs'] = 'footerJs/stockJs';
    	$data['mainContent'] = 'stock/admin_to_other'; 
    	$this->load->view("includes/mainContent", $data);
    }
    
    function branch_to_other()
    {
        $data['pageTitle'] = 'Branch Product Transfer';
    	$data['smallTitle'] = 'Branch Product Transfer';
    	$data['mainPage'] = 'Branch Product Transfer';
    	$data['subPage'] = 'Branch Product Transfer';
    	$data['title'] = 'Branch Product Transfer';
    	$data['headerCss'] = 'headerCss/stockCss';
    	$data['footerJs'] = 'footerJs/stockJs';
    	$data['mainContent'] = 'stock/branch_to_other'; 
    	$this->load->view("includes/mainContent", $data);
    }
    
    function shop_to_other()
    {
        $data['pageTitle'] = 'Shop Product Transfer';
    	$data['smallTitle'] = 'Shop Product Transfer';
    	$data['mainPage'] = 'Shop Product Transfer';
    	$data['subPage'] = 'Shop Product Transfer';
    	$data['title'] = 'Shop Product Transfer';
    	$data['headerCss'] = 'headerCss/stockCss';
    	$data['footerJs'] = 'footerJs/stockJs';
    	$data['mainContent'] = 'stock/shop_to_other'; 
    	$this->load->view("includes/mainContent", $data);
    }
    function get_data_ad()
    {
       
        $id = $this->input->post('selectidd');
        $this->db->where('district',$id);
        $this->db->where('status',1);
        $sb_dt = $this->db->get('sub_branch');
        if($sb_dt->num_rows()>0)
        {
            foreach($sb_dt->result() as $sbdt)
            { ?>
            <option value="<?php echo $sbdt->username;?>"><?php echo $sbdt->bname;?></option>
        <?php }
        }
        else
        {?>
            <option>Shop Not Found</option>
        <?php }
    }
    function transfer_pro()
    {
        $chk = $this->input->post('t');
        $receiver_id = $this->input->post('receiver_id');
        $send_qty = $this->input->post('send_qty');
        $pcode = $this->input->post('pcode');
        if($chk == 1)
        {
            $this->db->where('id',$receiver_id);
            $dtt = $this->db->get('branch');
            if($dtt->num_rows()>0)
            {
             $val = array('p_code'=>$pcode,
                        'discription'=>'To Branch',
                        'date'=>date('Y-m-d'),
                        'quantity'=>$send_qty,
                        'reciver_usernm'=>$dtt->row()->username,
                        'sender_usernm'=>$this->session->userdata('username'),
                        'status'=>'0');
                $this->db->where('invoice_number','');
                $this->db->where('date(date)',date('Y-m-d'));
                $this->db->where('p_code',$pcode);
                $this->db->where('reciver_usernm',$dtt->row()->username);
                $pds = $this->db->get('product_trans_detail');
                if($pds->num_rows()>0)
                {
                    $qt2 = $pds->row()->quantity + $send_qty;
                    $qt = array('quantity'=>$qt2);
                    $this->db->where('id',$pds->row()->id);
                    $updt = $this->db->update('product_trans_detail',$qt);
                    if($updt)
                    {
                       $idd['idd'] = $dtt->row()->username;
                       $this->load->view('stock/transfr_pro',$idd);
                    }
                    else
                    {
                        echo "not send";
                    }   
                }
                else
                {
                    $in = $this->db->insert('product_trans_detail',$val);
                    if($in)
                    {
                       $idd['idd'] = $dtt->row()->username;
                       $this->load->view('stock/transfr_pro',$idd);
                    }
                    else
                    {
                        echo "not send";
                    }   
                }
                
            }
            else
            {
                echo "sender not found";
            }
        }
        
        elseif($chk == 2)
        {
            $val = array('p_code'=>$pcode,
                        'discription'=>'To Shop',
                        'date'=>date('Y-m-d'),
                        'quantity'=>$send_qty,
                        'reciver_usernm'=>$receiver_id,
                        'sender_usernm'=>$this->session->userdata('username'),
                        'status'=>'0');
                $this->db->where('invoice_number','');
                $this->db->where('date(date)',date('Y-m-d'));
                $this->db->where('p_code',$pcode);
                $this->db->where('reciver_usernm',$receiver_id);
                $pds = $this->db->get('product_trans_detail');
                if($pds->num_rows()>0)
                {
                    $qt2 = $pds->row()->quantity + $send_qty;
                    $qt = array('quantity'=>$qt2);
                    $this->db->where('id',$pds->row()->id);
                    $updt = $this->db->update('product_trans_detail',$qt);
                    if($updt)
                    {
                       $idd['idd'] = $receiver_id;
                       $this->load->view('stock/transfr_pro',$idd);
                    }
                    else
                    {
                        echo "not send";
                    }   
                }
                else
                {
                    $in = $this->db->insert('product_trans_detail',$val);
                    if($in)
                    {
                        $idd['idd'] = $receiver_id;
                       $this->load->view('stock/transfr_pro',$idd);
                    }
                    else
                    {
                        echo "not send";
                    }    
                }
        }
        elseif($chk == 3)
        {
            $this->db->where('id',1);
            $gt = $this->db->get('general_settings')->row();
            $val = array('p_code'=>$pcode,
                        'discription'=>'To Admin',
                        'date'=>date('Y-m-d'),
                        'quantity'=>$send_qty,
                        'reciver_usernm'=>$gt->admin_username,
                        'sender_usernm'=>$this->session->userdata('username'),
                        'status'=>'0');
                $this->db->where('invoice_number','');
                $this->db->where('date(date)',date('Y-m-d'));
                $this->db->where('p_code',$pcode);
                $this->db->where('reciver_usernm',$gt->admin_username);
                $pds = $this->db->get('product_trans_detail');
                if($pds->num_rows()>0)
                {
                    $qt2 = $pds->row()->quantity + $send_qty;
                    $qt = array('quantity'=>$qt2);
                    $this->db->where('id',$pds->row()->id);
                    $updt = $this->db->update('product_trans_detail',$qt);
                    if($updt)
                    {
                       $idd['idd'] = $gt->admin_username;
                       $this->load->view('stock/transfr_pro',$idd);
                    }
                    else
                    {
                        echo "not send";
                    }   
                }
                else
                {
                    $in = $this->db->insert('product_trans_detail',$val);
                    if($in)
                    {
                        $idd['idd'] = $gt->admin_username;
                       $this->load->view('stock/transfr_pro',$idd);
                    }
                    else
                    {
                        echo "not send";
                    }    
                }
        }
        else
        {
            echo "sad";
        }
    }
    
    function delete_tranfr_pro()
    {
        $id = $this->input->post('dlt_id');
        $this->db->where('id',$id);
        $chk = $this->db->delete('product_trans_detail');
        if($chk)
        {
            echo "Send Item Deleted";
        }
        else
        {
            echo " Not Deleted";
        }
        
    }
	////////////pcode end////////////
}
?>