<?php
class branchController extends CI_Controller{
	function __construct(){
		parent::__construct();
			$this->is_login();
		$this->load->model("branch");
		$this->load->model("admin");
		$this->load->model("employee");
	}
	function is_login(){
		$is_login = $this->session->userdata('is_login');
		if(!$is_login){
			redirect("index.php/homeController/index");
		}
		else{
			
			if($this->session->userdata("login_type")>2)
			{
				redirect("index.php/homeController/index");
			}
			
		}
	}
	
	function index(){
	    $username = $this->session->userdata("username");
		$this->db->where("login_username",$username);
		$this->db->where("DATE(opening_date)",date("Y-m-d"));
		$checkopeningclo  = $this->db->get("opening_closing_balance");
		if($checkopeningclo->num_rows()>0){
			
		}else{
		    
			$clo1 = $this->db->query("select * from opening_closing_balance where  login_username ='$username' ORDER BY id DESC LIMIT 1");
			if($clo1->num_rows()>0){
				$clo =$clo1->row();
			$cl_date = $clo->closing_date;
			$cl_balance = $clo->closing_balance;
			$cr_date = date('Y-m-d');

			if($cl_date != $cr_date)
			{
				$this->ocbalance->insert_ocbalance($cl_balance,$cl_balance,$username);
			}
			}else{
				$this->ocbalance->insert_ocbalance(0,0,0);
			}
		}
		$data['pageTitle'] = 'Branch Dashboard';
		$data['smallTitle'] = 'Overview of all Section';
		$data['mainPage'] = 'Branch Dashboard';
		$data['subPage'] = 'Branch dashboard';
		$data['title'] = 'Branch Dashboard';
		$data['headerCss'] = 'headerCss/dashboardCss';
		$data['footerJs'] = 'footerJs/dashboardJs';
		$data['mainContent'] = 'Branch/dashboard';
		$this->load->view("includes/mainContent", $data);
	
	}
	
	
	function bregistration(){
		$data['pageTitle'] = 'Branch Registration';
		$data['smallTitle'] = 'Branch Registration';
		$data['mainPage'] = 'Add Branch Area';
		$data['subPage'] = 'New Branch Registration';
		$data['title'] = 'Add Branch Area';
		$data['headerCss'] = 'headerCss/branchCss';
		$data['footerJs'] = 'footerJs/branchJs';
		$data['mainContent'] = 'Branch/brachRegistration';
		$this->load->view("includes/mainContent", $data);
	}
	function daybook(){
		$data['pageTitle'] = 'DayBook Section';
		$data['smallTitle'] = 'DayBook';
		$data['mainPage'] = 'DayBook';
		$data['subPage'] = 'DayBook';
		$data['title'] = 'DayBook';
		$data['headerCss'] = 'headerCss/stockCss';
		$data['footerJs'] = 'footerJs/stockJs';
		$data['mainContent'] = 'Branch/daybook';
		$this->load->view("includes/mainContent", $data);
	} 
	function daybook_out(){
		$data['pageTitle'] = 'DayBook Section';
		$data['smallTitle'] = 'DayBook';
		$data['mainPage'] = 'DayBook';
		$data['subPage'] = 'DayBook';
		$data['title'] = 'DayBook';
		$data['headerCss'] = 'headerCss/stockCss';
		$data['footerJs'] = 'footerJs/stockJs';
		$data['mainContent'] = 'Branch/daybook_out';
		$this->load->view("includes/mainContent", $data);
	} 
	function daybook_in(){
		// $data['sender_uname'] = $this->input->post('uname');
		$data['pageTitle'] = 'DayBook Section';
		$data['smallTitle'] = 'DayBook';
		$data['mainPage'] = 'DayBook';
		$data['subPage'] = 'DayBook';
		$data['title'] = 'DayBook';
		$data['headerCss'] = 'headerCss/stockCss';
		$data['footerJs'] = 'footerJs/stockJs';
		$data['mainContent'] = 'Branch/daybook_in';
		$this->load->view("includes/mainContent", $data);
	} 
	function indaybook_record()
	{
		$data['sender_uname'] = $this->input->post('uname');
		$this->load->view("Branch/in_daybook_record", $data);
	}
	function outdaybook_record()
	{
		$data['reciver_uname'] = $this->input->post('uname');
		$this->load->view("Branch/out_daybook_record", $data);
	}
	public function pay_others()
	{
		$data['pageTitle'] = 'Pay To Admin Or Shop';
		$data['smallTitle'] = 'Pay To Admin Or Shop';
		$data['mainPage'] = 'Pay To Admin Or Shop';
		$data['subPage'] = 'Pay To Admin Or Shop';
		$data['title'] = 'Pay To Admin Or Shop';
		$data['headerCss'] = 'headerCss/stockCss';
		$data['footerJs'] = 'footerJs/stockJs';
		$data['mainContent'] = 'Shop/pay_other';
		$this->load->view("includes/mainContent", $data);
	}
	public function  payment_record()
	{

		$data['username'] = $this->input->post('uname');
		// print_r($data);
		$this->load->view("Shop/payment_record", $data);
	}
	public function add_details()
	{
		$data['pageTitle'] = 'Add QR Code';
		$data['smallTitle'] = 'Add QR Code Image';
		$data['mainPage'] = 'Add QR Code Image';
		$data['subPage'] = 'Add QR Code Image';
		$data['title'] = 'Add QR Code Image';
		$data['headerCss'] = 'headerCss/stockCss';
		$data['footerJs'] = 'footerJs/stockJs';
		$data['mainContent'] = 'Shop/add_details';
		$this->load->view("includes/mainContent", $data);
	}
	public function save_qr_details()
	{
		$val['username']= $this->session->userdata('username');
		$val['type']= $this->input->post("qr_type");
		$val['image'] = str_replace(' ','',$_FILES['img_1']['name']);
		$config['upload_path'] = $this->db->get('upload_asset')->row()->asset_name.'/images/Qr_code';
		//print_r($config['upload_path']); //exit;
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['max_size'] = '5120';
		$config['file_name']= str_replace(' ','',$_FILES['img_1']['name']);
		if(!empty($_FILES['img_1']['name']))
		{
			$this->upload->initialize($config);
			if($this->upload->do_upload('img_1'))
			{
				$chkk = $this->db->insert('bank_qr_details',$val);
				if($chkk)
				{
					echo "Upload Successfully";
				}
				else
				{
					echo "Data Not Inserted";
				}
			}
			else
			{
				echo "Image Not Uploaded";
			}
		}
	}
	function dlt_img()
	{
		$r_id = $this->input->post("r_id");
		$this->db->where('id',$r_id);
		$dlt = $this->db->delete('bank_qr_details');
		if($dlt)
		{
			echo "1";
		}
		else
		{
			echo "0";
		}
	}
	function saveBranch(){
		$maxid=$this->branch->getMax();
		$maxid=$maxid+1;
		$name=$this->input->post('name');
		$username="PBR".$maxid;
		$value['username']= $username;
		$value['b_name']=$this->input->post('b_name');
		$value['district']=$this->input->post('district');
		$value['name']=$this->input->post('name');
		$value['mobile']=$this->input->post('mob_no');
		$value['aadhar']=$this->input->post('aadhar');
		$value['email_id']=$this->input->post('email');
		$value['password']=$this->input->post('password');
		$bname = $this->input->post('b_name');
		$passw = $this->input->post('password');
		$dt=$this->branch->insert($value);
		  if($dt)
		  {
             $msg = "Dear ". $name . " Your Branch Registration in PAS System is Successfully Done. Your Branch Name is " .$bname . "  and Your Username is ".$username." and Password is ".$passw.". Please Wait For Activation. Best Regards from  PAS System Admin- 7394826066";
              $mobile = $this->input->post('mob_no');
				  sms($mobile,$msg);
				  $mbal['username']=$username;
		          $mbal['balance']=0.00;
		          $mbal['date']=date("y-m-d");

		          $this->db->insert("m_balance",$mbal);
                  //echo $msg;
             redirect(base_url().'branchController/bregistration/5');
		            //   // redirect('https://passystem.in/auth/signupShop','refresh');
		        }else{?>
<?php
		           redirect(base_url().'branchController/error');
		        }
	}
	function error(){
		echo "error";
	}
	
	function branchListActive(){
		$dt = $this->branch->getActiveList();
		$data['activeList']=$dt;
		$data['pageTitle'] = 'Active Branch List';
		$data['smallTitle'] = 'Active  Branch List';
		$data['mainPage'] = 'Active Branch List';
		$data['subPage'] = 'Active Branch List ';
		$data['title'] = 'Active Branch List';
		$data['headerCss'] = 'headerCss/stockCss';
		$data['footerJs'] = 'footerJs/stockJs';
		$data['mainContent'] = 'Branch/branchListActive';
		$this->load->view("includes/mainContent", $data);
		
	}

	function producttransfer(){
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

	function branchListinActive(){
		$dt = $this->branch->getinActiveList();
		$data['activeList']=$dt;
		$data['pageTitle'] = 'Inactive Branch List';
		$data['smallTitle'] = 'Inactive Branch List';
		$data['mainPage'] = 'Inactive Branch List';
		$data['subPage'] = 'Inactive Branch List ';
		$data['title'] = 'Inactive Branch List';
		$data['headerCss'] = 'headerCss/stockCss';
		$data['footerJs'] = 'footerJs/stockJs';
		$data['mainContent'] = 'Branch/branchListinActive';
		$this->load->view("includes/mainContent", $data);
	}
	public function branchstocklist(){
		$data['unm'] = $this->branch->getValue();
		$data['pageTitle'] = 'Branch Product List';
		$data['smallTitle'] = 'Full Product List';
		$data['mainPage'] = 'Active Product List ';
		$data['subPage'] = 'Branch Product List';
		$data['title'] = 'Branch Product List';
		$data['headerCss'] = 'headerCss/stockCss';
		$data['footerJs'] = 'footerJs/stockJs';
		$data['mainContent'] = 'Branch/branchstocklist';
		$this->load->view("includes/mainContent", $data);
	}
	public function subbranchstocklist(){
		$data['pageTitle'] = 'Shop Product List';
		$data['smallTitle'] = 'Shop Product List';
		$data['mainPage'] = 'Shop Product List ';
		$data['subPage'] = 'Shop Product List';
		$data['title'] = 'Shop Product List';
		$data['headerCss'] = 'headerCss/stockCss';
		$data['footerJs'] = 'footerJs/stockJs';
		$data['mainContent'] = 'Branch/subbranchstocklist';
		$this->load->view("includes/mainContent", $data);
	}
	public function branchfull_profile(){
		$id=$this->uri->segment(3);
		//print_r($id);exit();
		if($this->session->userdata("login_type")== 1){
			
			$data['unm'] = $this->branch->full_profile($id);
		}else{
		$data['unm'] = $this->branch->getValue();}
		$data['pageTitle'] = 'Branch Profile';
		$data['smallTitle'] = 'Full Profile';
		$data['mainPage'] = 'Active Branch ';
		$data['subPage'] = 'Branch ';
		$data['title'] = 'Branch';
		$data['headerCss'] = 'headerCss/branchListCss';
		$data['footerJs'] = 'footerJs/branchListJs';
		$data['mainContent'] = 'Branch/branchfull_profile';
		$this->load->view("includes/mainContent", $data);
	}
	public function updateBranch(){
		$id= $this->uri->segment(3);
		$value['email_id'] = $this->input->post('email');
		$value['bank_name'] = $this->input->post('bankname');
		$value['account_no'] = $this->input->post('acc_no');
		$value['branch_name'] = $this->input->post('branchName');
		$value['ifsc'] = $this->input->post('ifsc');
	//	$value['image'] =time().trim($_FILES['image']['name']);
		$value['password'] = $this->input->post('password');
		 $photo_name1 = time().trim($_FILES['image']['name']); 
		// if($query)
		// {
			$this->load->library('upload');
			//$image_path = realpath(APPPATH . '../assets/images/branch');
			$asset_name = $this->db->get('upload_asset')->row()->asset_name;
		
						$image_path = $asset_name.'/images/branch/';
			$config['upload_path'] = $image_path;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|';
			$config['max_size'] = '50';
			$config['file_name'] = $photo_name1;
		//	print_r($config);exit();
		//}
		if (!empty($_FILES['image']['name'])) {
			$this->upload->initialize($config);
			$this->upload->do_upload('image');
			$value['image'] = $photo_name1;
		//	print_r("hiiii");
		//	print_r($value);exit();
		}
		$this->db->where('id',$id);
		$query=$this->db->update('branch',$value);
		
		redirect('index.php/branchController/branchfull_profile/'.$id.'/5');
	}
	
	
	function error1(){
		echo "error";
	}
	function match_pan1(){
	    $pan=$this->input->post('panVal');
	    $data = $this->branch->panCard($pan);
	    if($data){
	        echo "<p class='error' style='color:red;'>You can not use duplicate pan number!!</p>";
	    }else{
	       echo "<p class='error' style='color:green;'>Valid Pan Number</p>";
	    }
	}

	
	  

	function checkjoinerid(){
		  $tid = $this->input->post("cat");
		  $this->load->model("registration1");
		  $var = $this->registration1->checkjoinerid($tid);
		  if($var->num_rows()>0){
		   $rw1=$var->row();
		   print_r($rw1);exit();
		 $this->db->where("parentID",$rw1->id);
		 $data= $this->db->get("tree");
		if($data->num_rows()<20){  }
	}
}

	 function adminproductsend()
 {
    $senderid=$this->input->post('admin');
    $sendquantity=$this->input->post('sendquantity');
    $recquantity=$this->input->post('stockquantity');
    $pcode=$this->input->post('pcode');
    $reciverchk=$this->input->post('reciverchk');
    $recivebranch=$this->input->post('recivebranch');
    $recisubbranch=$this->input->post('recisubbranch');

    if($reciverchk==1)
    { ?>
        <script>
        alert("Can not send Admin to Admin Product");
        $("#sendcheckid").get(0).selectedIndex = 0;
        $("#sendproductdetail").hide();
        </script>
        <?php 
    }
    if($reciverchk==2)
    {
     $this->db->where('id',$pcode);
     $sadminstock=$this->db->get('stock_products')->row();
      if(strlen($sadminstock->sec)>0){
     $data13=array(
      'quantity' =>$sadminstock->quantity-$sendquantity,
      'protrans_date'=>date('Y-m-d'), 
      ); 
      $this->db->where('id',$sadminstock->id);
      $adstockup=$this->db->update('stock_products',$data13);
     

      $this->db->where('p_code',$pcode);
      $this->db->where('branch_id',$recivebranch);
      $admwallet=$this->db->get('branch_wallet');

    if($admwallet->num_rows()>0){
      $adwall=$admwallet->row();
      $data15=array(
        'rec_quantity' =>$adwall->rec_quantity+$sendquantity, 
        'sec'=>$sadminstock->sec,
        'date'=>date('Y-m-d'),
        );
      $this->db->where('id',$adwall->id);
      $newinsert=$this->db->update('branch_wallet',$data15);
    }
  else
  {
    $data16=array(
      'branch_id' =>$recivebranch,
       'p_code'=>$pcode,
       'rec_quantity'=>$sendquantity,
       'sec'=>$sadminstock->sec,
      'date'=>date('Y-m-d'),
      );
     $newinsert=$this->db->insert('branch_wallet',$data16);
    }
   
      $this->db->where('id',$senderid);
      $admusernm=$this->db->get('general_settings')->row();
   
                $this->db->where('id',$recivebranch);
      $branusernm=$this->db->get('branch')->row();

    $data17=array(
    'p_code' =>$pcode,
    'Discription'=>"Admin to Branch",
    'quantity'=>$sendquantity,
     'sender_usernm'=>$admusernm->admin_username,
     'reciver_usernm'=>$branusernm->username,
    );
    $insertpr=$this->db->insert('product_trans_detail',$data17); 

     if($insertpr&& $newinsert){
  $data['recivebranch']=$recivebranch;
   $data['senqt']=$sendquantity;
  $this->load->view('Admin/admintobranch',$data);
    }
      } else{?>

<script>
alert('please update Your Product With Sec Number');
return false;
</script>

<?php } 
    }
    if($reciverchk==3)
    {
     $this->db->where('id',$pcode);
     $sadminstock=$this->db->get('stock_products')->row();
      if(strlen($sadminstock->sec)>0){
     $data18=array(
      'quantity' =>$sadminstock->quantity-$sendquantity,
      'protrans_date'=>date('y-m-d'), 
      ); 
      $this->db->where('id',$sadminstock->id);
      $adstockup=$this->db->update('stock_products',$data18);
      
      $this->db->where('p_code',$pcode);
      $this->db->where('subbranch_id',$recisubbranch);
      $admwallets=$this->db->get('subbranch_wallet');

    if($admwallets->num_rows()>0){
      $adwalls=$admwallets->row();
      $data20=array(
        'rec_quantity' =>$adwalls->rec_quantity+$sendquantity, 
       'sec'=>$sadminstock->sec,
        'date'=>date('Y-m-d'),
        );
      $this->db->where('id',$adwalls->id);
      $newinserts=$this->db->update('subbranch_wallet',$data20);
    }
  else
  {
    $data21=array(
      'subbranch_id' =>$recisubbranch,
       'p_code'=>$pcode,
       'rec_quantity'=>$sendquantity,
        'sec'=>$sadminstock->sec,
         'date'=>date('Y-m-d'),
      );
     $newinserts=$this->db->insert('subbranch_wallet',$data21);
    }
   
      $this->db->where('id',$senderid);
      $admusernms=$this->db->get('general_settings')->row();
   
        $this->db->where('id',$recisubbranch);
      $branusernms=$this->db->get('sub_branch')->row();

    $data22=array(
    'p_code' =>$pcode,
    'Discription'=>"Admin to Subbranch",
    'quantity'=>$sendquantity,
   
     'sender_usernm'=>$admusernms->admin_username,
     'reciver_usernm'=>$branusernms->username,
    );
    $insertpr=$this->db->insert('product_trans_detail',$data22); 
   
   if($insertpr&&$newinserts){
    
    $data['recisubbranch']=$recisubbranch;
    $data['senqt']=$sendquantity;
    $this->load->view('Admin/admintosbbranch',$data);
  }

    } 
    else { ?>
<script>
alert('Please Update Your Product detail with sec');
return false;
</script>

<?php  }
    

 }
}

 function branchproduct(){

	$branchid=$this->input->post('branchid');
	
	$product=$this->branch->getbranchproduct($branchid);
	if($product->num_rows>0){
		
			 $data['adminreciver']=$this->input->post("reciadmin");
			 $data['branchreciver']=$this->input->post("recivebranch");
			 $data['subbranchreciver']=$this->input->post("recisubbranch");
			 $data['brproduct']=$product->result();
			 $this->load->view('Branch/branchproduct',$data);
		
}
}
 function shopproduct(){

	$sbranchid=$this->input->post('subbranchid');

	$product=$this->branch->getshopproduct($sbranchid);
	if($product->num_rows>0){
			$data['adminreciver']=$this->input->post("reciadmin");
			 $data['branchreciver']=$this->input->post("recivebranch");;
			 $data['subbranchreciver']=$this->input->post("recisubbranch");;
			 $data['brproduct']=$product->result();
			 $this->load->view('Branch/subbranchproduct',$data);
}
}

function getsubbranch() {

	$tid = $this->input->post("classv");
	
	$var = $this->branch->getsbranch($tid);
		if($var->num_rows() > 0){
		?>

<option value="">-Select Sub Branch-</option>

<?php
			foreach ($var->result() as $row)
			{?>

<option value="<?php echo $row->id;?>" class="text-uppercase"><?php echo $row->bname;?></option>

<?php }

		}
}



function branchtransferproduct() {

	
	$senderid=$this->input->post('senderid');
	$sendquantity=$this->input->post('sendquantity');
	$recquantity=$this->input->post('recquantity');
	$pcode=$this->input->post('pcode');
	$reciever=$this->input->post('reciever');
	 $idcheck=$this->input->post('idcheck');
 
				$this->db->where('id',$senderid);
				$sendusernm=$this->db->get('branch')->row();
 
				$this->db->where('id',$reciever);
				$reciusernm=$this->db->get('branch')->row();
				print_r($reciever);
				// echo "<br>";
				// print_r($senderid);
				// echo "<br>";
				// print_r($sendquantity);
				// echo "<br>";
				// print_r($recquantity);
				// echo "<br>";
				// print_r($pcode);
				// echo "<br>";
				// print_r($idcheck);
				// print_r($reciusernm);
				exit();
	
	if($idcheck==1){
 
 
			$this->db->where('id',$pcode);
			$getstock=$this->db->get('stock_products')->row();
 
			$data1=array(
		 'quantity' =>$getstock->quantity+$sendquantity,
		 'protrans_date'=>date('Y-m-d'),
		 
		 );
			$this->db->where('id',$getstock->id);
			$updatestock=$this->db->update('stock_products', $data1);
 
				$this->db->where('branch_id',$senderid);
			 $this->db->where('p_code',$pcode);
			$getbranchwallet=$this->db->get('branch_wallet')->row();
			echo"<pre>";
//  print_r($getbranchwallet);
//  print_r($senderid);
//   print_r($sendquantity);
//   print_r($pcode);
//  exit();
	 $data3=array(
			'sale_quantity'=>$getbranchwallet->sale_quantity+$sendquantity,
		 'rec_quantity' =>$getbranchwallet->rec_quantity-$sendquantity,
	 );
			$this->db->where('id', $getbranchwallet->id);
			$branchwallet=$this->db->update('branch_wallet',$data3);
		
				 $this->db->where('id',$reciever);
			$getadmin=$this->db->get('general_settings')->row();
 
		 $data2=array(
			 'p_code' =>$pcode , 
			 'Discription'=>"Branch to Admin",
				'quantity'=> $sendquantity,
				'sender_usernm'=>$sendusernm->username,
				'reciver_usernm'=>$getadmin->admin_username,
		 );
			$prdetail=$this->db->insert('product_trans_detail', $data2);
		if($prdetail &&$branchwallet&& $updatestock){
			//$data['p_code']=$pcode;
			$this->load->view('Branch/branchtoadmin');
			}
	}
			if($idcheck==2)
			{
		 if($senderid!=$reciever)
		 {
			 $this->db->where('p_code',$pcode);
			 $this->db->where('branch_id',$reciever);
			 $brawallet=$this->db->get('branch_wallet');
 
		 if($brawallet->num_rows()>0){
			 $bwll=$brawallet->row();
			 $data7=array(
				 'rec_quantity' =>$bwll->rec_quantity+$sendquantity,
				 );
			 $this->db->where('id',$bwll->id);
			 $newinsert=$this->db->update('branch_wallet',$data7);
		 }
	 else
	 {
		 $data4=array(
			 'branch_id' =>$reciever,
				'p_code'=>$pcode,
				'rec_quantity'=>$sendquantity,
				'date'=> Date("y-m-d")
			 
			 );
			$newinsert=$this->db->insert('branch_wallet',$data4);
		 }
			if($newinsert)
			{
			 $this->db->where('p_code',$pcode);
			 $this->db->where('branch_id',$senderid);
			 $brawallet=$this->db->get('branch_wallet')->row();
 
			$data5=array(
			 'rec_quantity'=>$brawallet->rec_quantity-$sendquantity,
				'sale_quantity'=>$brawallet->sale_quantity+$sendquantity,
				'date'=>Date('y-m-d')
			 );
			$this->db->where('id',$brawallet->id);
			 $brawallet=$this->db->update('branch_wallet', $data5);
		}
		$data6=array(
		 'p_code' =>$pcode,
		 'Discription'=>"Branch to Branch",
		 'quantity'=>$sendquantity,
			'sender_usernm'=>$sendusernm->username,
			'reciver_usernm'=>$reciusernm->username,
		 );
		 $insertpr=$this->db->insert('product_trans_detail',$data6);
		 if($insertpr&&$brawallet){
		 
			 $data['reciever']=$reciever;
			 $this->load->view('Branch/branchtobranch',$data);
		 }
	 }
		 else
		 {?>
<script>
alert("You can not send own Branch Product");
$("#sendproductdetail").hide();
window.location.reload();
</script>
<?php 
		 } 
			}
			if($idcheck==3){
			
			$this->db->where('p_code',$pcode);
			 $this->db->where('subbranch_id',$reciever);
			 $sbrawallet=$this->db->get('subbranch_wallet');
		 if($sbrawallet->num_rows()>0){
			 $sbwll=$sbrawallet->row();
			 $data9=array(
				 'rec_quantity' =>$sbwll->rec_quantity+$sendquantity, 
				 );
			 $this->db->where('id',$sbwll->id);
			 $newinsert=$this->db->update('subbranch_wallet',$data9);
		 }
	 else
	 {
		 $data10=array(
			 'subbranch_id' =>$reciever,
				'p_code'=>$pcode,
				'rec_quantity'=>$sendquantity,
				'date'=>Date('y-m-d')
			 );
			$newinsert=$this->db->insert('subbranch_wallet',$data10);
		 }
			
			if($newinsert)
			{
			 $this->db->where('p_code',$pcode);
			 $this->db->where('branch_id',$senderid);
			 $brawallet=$this->db->get('branch_wallet')->row();
 
			$data11=array(
			 'rec_quantity'=>$brawallet->rec_quantity-$sendquantity,
			 'sale_quantity'=>$brawallet->sale_quantity+$sendquantity,
			 'date'=>Date('y-m-d')
			 );
			$this->db->where('id',$brawallet->id);
			 $brawallet=$this->db->update('branch_wallet', $data11);
		}
			 $this->db->where('id',$reciever);
			 $subbranch=$this->db->get('sub_branch')->row();
		$data12=array(
		 'p_code' =>$pcode,
		 'Discription'=>"Branch to Subbranch",
		 'quantity'=>$sendquantity,
			'sender_usernm'=>$sendusernm->username,
			'reciver_usernm'=>$subbranch->username,
		 );
		 $insertpr=$this->db->insert('product_trans_detail',$data12); 
			 if($insertpr&& $brawallet){
			 $data['reciever']=$reciever;
			 $this->load->view('Branch/branchtosubbranch',$data);
			}
 
			 }
	}





	function subbratransferproduct()
	{
 
	$senderid=$this->input->post('senderid');
	$sendquantity=$this->input->post('sendquantity');
	$recquantity=$this->input->post('recquantity');
	$pcode=$this->input->post('pcode');
	$reciever=$this->input->post('reciever');
	 $idcheck=$this->input->post('idcheck');
 
			 $this->db->where('id',$senderid);
				$ssendusernm=$this->db->get('sub_branch')->row();
 
				$this->db->where('id',$reciever);
				$sreciusernm=$this->db->get('sub_branch')->row();
	
	if($idcheck==1){
			$this->db->where('id',$pcode);
			$getstock=$this->db->get('stock_products')->row();
			$data24=array(
		 'quantity' =>$getstock->quantity+$sendquantity,
		 'protrans_date'=>date('Y-m-d'),
		 );
			$this->db->where('id',$getstock->id);
			$updatestock=$this->db->update('stock_products', $data24);
 
			$this->db->where('subbranch_id',$senderid);
			$this->db->where('p_code',$pcode);
			$sgetsbranchwallet=$this->db->get('subbranch_wallet')->row();
 
	 $data25=array(
		 'sale_quantity' =>$sgetsbranchwallet->sale_quantity+$sendquantity,
		 'rec_quantity' =>$sgetsbranchwallet->rec_quantity-$sendquantity, 
	 );
			$this->db->where('id',$sgetsbranchwallet->id);
			$sbranchwallet=$this->db->update('subbranch_wallet',$data25);
		
				 $this->db->where('id',$reciever);
			$sgetadmin=$this->db->get('general_settings')->row();
 
		 $data26=array(
			 'p_code' =>$pcode , 
			 'Discription'=>"Subbranch to Admin",
				'quantity'=> $sendquantity,
				'sender_usernm'=>$ssendusernm->username,
				'reciver_usernm'=>$sgetadmin->admin_username,
		 );
		 $pp=$this->db->insert('product_trans_detail', $data26);
	 if($pp&&$sbranchwallet&&$updatestock){ 
		
	 // $data['p_code']=$pcode;
		$this->load->view('Admin/subbranchtoadmin');
	 
			}
 }
			if($idcheck==3)
			{
		 if($senderid!=$reciever)
		 {
			 $this->db->where('p_code',$pcode);
			 $this->db->where('subbranch_id',$reciever);
			 $sbrawallet=$this->db->get('subbranch_wallet');
 
		 if($sbrawallet->num_rows()>0){
			 $sbwll=$sbrawallet->row();
			 $data27=array(
				 'rec_quantity' =>$sbwll->rec_quantity+$sendquantity, 
				
				 );
			 $this->db->where('id',$sbwll->id);
			 $newinsert=$this->db->update('subbranch_wallet',$data27);
		 }
	 else
	 {
		 $data28=array(
			 'subbranch_id' =>$reciever,
				'p_code'=>$pcode,
				'rec_quantity'=>$sendquantity,
				'date'=>Date("y-m-d")
			 
			 );
			$newinsert=$this->db->insert('subbranch_wallet',$data28);
		 }
			
			if($newinsert)
			{
			 $this->db->where('p_code',$pcode);
			 $this->db->where('subbranch_id',$senderid);
			 $sbrawallet=$this->db->get('subbranch_wallet')->row();
 
			$data29=array(
			 'rec_quantity'=>$sbrawallet->rec_quantity-$sendquantity, 
			'sale_quantity' =>$sbrawallet->sale_quantity+$sendquantity,
			'date'=>Date('y-m-d')
			 );
			$this->db->where('id',$sbrawallet->id);
			 $brawallet=$this->db->update('subbranch_wallet', $data29);
		}
		$data30=array(
		 'p_code' =>$pcode,
		 'Discription'=>"Subbranch to Subbranch",
		 'quantity'=>$sendquantity,
			'sender_usernm'=>$ssendusernm->username,
			'reciver_usernm'=>$sreciusernm->username,
			
		 );
		 $insertprs=$this->db->insert('product_trans_detail',$data30);
		 if($insertprs&&$brawallet&& $newinsert){
				 
		 $data['reciever']=$reciever;   
		 $this->load->view('Branch/subbranchtosubbranch',$data);
				}
		 }
		 else
		 {?>
<script>
alert("You can not send own Subbranch Product");
$("#sendproductdetail").hide();
window.location.reload();
</script>
<?php 
		 } 
			}
			if($idcheck==2){
			$this->db->where('p_code',$pcode);
			 $this->db->where('branch_id',$reciever);
			 $brawallet=$this->db->get('branch_wallet');
 
		 if($brawallet->num_rows()>0){
			 $bwll=$brawallet->row();
			 $data31=array(
				 'rec_quantity' =>$bwll->rec_quantity+$sendquantity, 
				 'date'=> Date("y-m-d")
				
				 );
			 $this->db->where('id',$bwll->id);
			 $newinsert=$this->db->update('branch_wallet',$data31);
		 }
	 else
	 {
		 $data32=array(
			 'branch_id' =>$reciever,
				'p_code'=>$pcode,
				'rec_quantity'=>$sendquantity,
				'date'=> Date("y-m-d")
			 );
			$newinsert=$this->db->insert('branch_wallet',$data32);
		 }
			
			if($newinsert)
			{
			 $this->db->where('p_code',$pcode);
			 $this->db->where('subbranch_id',$senderid);
			 $sbrawallet=$this->db->get('subbranch_wallet')->row();
 
			$data32=array(
			 'rec_quantity'=>$sbrawallet->rec_quantity-$sendquantity, 
				'sale_quantity' =>$sbrawallet->sale_quantity+$sendquantity,
			 );
			$this->db->where('id',$sbrawallet->id);
			 $brawallet=$this->db->update('subbranch_wallet', $data32);
		}
			 $this->db->where('id',$reciever);
			 $branch=$this->db->get('branch')->row();
		$data33=array(
		 'p_code' =>$pcode,
		 'Discription'=>"Subbranch to Branch",
		 'quantity'=>$sendquantity,
			'sender_usernm'=>$ssendusernm->username,
			'reciver_usernm'=>$branch->username,
		 );
		 $insertprss=$this->db->insert('product_trans_detail',$data33); 
 
			if($insertprss&& $brawallet&&$newinsert){
					$data['reciever']=$reciever;
				$this->load->view('Branch/subbranchtobranch',$data);
				} 
		}
		}
		function delete_branch(){

		 $id=$this->uri->segment(3);
		 $data['view']= $this->branch->deleteBranch($id);
		 redirect(base_url().'branchController/branchListActive');
		}
		public function offlinepaymentapproval()         
		{
		$data['branch']= $this->branch->getValue();
		$data['pageTitle'] = 'Payment Approval';
		$data['smallTitle'] = 'Payment Approval';
		$data['mainPage'] = 'Payment Approval';
		$data['subPage'] = 'Payment Approval';
		$data['title'] = 'Admin Payment Approval';
		$data['headerCss'] = 'headerCss/adminapprovelcss';
		$data['footerJs'] = 'footerJs/branchproducttransferJs';
		$data['mainContent'] = 'Branch/offlinepaymentapproval';
		$this->load->view("includes/mainContent", $data);
		}
		function getsubpayment() {
			$tid = $this->input->post("branch");
			$var = $this->branch->getsbranch($tid);
			if($var->num_rows() > 0){
		?>
<option value="">-Select Sub Branch-</option>
<?php	foreach ($var->result() as $row)
			{?>
<option value="<?php echo $row->id;?>" class="text-uppercase"><?php echo $row->bname;?></option>
<?php }
		}
		
}	
function getemptype(){
$subbranch= $this->input->post('subBranch');
$emp= $this->employee->empSubbranch1($subbranch);
			if($emp->num_rows()>0){
				?>
		<option value="">-Select Employee-</option>
<?php	foreach ($emp->result() as $row)
			{?>
<option value="<?php echo $row->id;?>" class="text-uppercase"><?php echo $row->name;?></option>
		<?php	}
		}
 }
 function remainingamount(){
	 $data['branchid']=$this->input->post('branchid');
	$data['subbranchid']=$this->input->post('sbranchid');
	$data['enddate']=$this->input->post('enddate');
	$data['delivery']=$this->input->post('delivery');
	$this->db->where('del_boy_id',$this->input->post('delivery'));
	$this->db->where('order_date',$this->input->post('enddate'));
	$this->db->where('sub_branchid',$this->input->post('sbranchid'));
	$order=$this->db->get('order_serial');
	$data['odrdernum']=$order->num_rows();
	$data['oderdetail']=$order->result();
	$this->load->view('Branch/paymentdetail',$data);
 }
 function branchorderapprove(){
 	$data['pageTitle'] = 'Branch Approval';
	$data['smallTitle'] = 'Branch Approval';
	$data['mainPage'] = 'Branch Approval';
	$data['subPage'] = 'Branch Approval';
	$data['title'] = 'Branch Approval';
	$data['headerCss'] = 'headerCss/adminapprovelcss';
	$data['footerJs'] = 'footerJs/producttransfer';
	$data['mainContent'] = 'Branch/branchorderapprove';
	$this->load->view("includes/mainContent", $data);
 }
 	function match_name_branch(){
	     $name=$this->input->post('name');
	    $this->db->where('b_name',$name);
	    $panno=$this->db->get('branch')->row();
	    if($panno){
	        echo "<p class='error' style='color:red;'>You can not use duplicate Branch Name!!</p>";
	    }else{
	       echo "<p class='error' style='color:green;'>Correct</p>";
	    }
	}
	function paidInvoice(){
	 $data['pageTitle'] = 'Paid Invoice';
	$data['smallTitle'] = 'Paid Invoice';
	$data['mainPage'] = 'Paid Invoice';
	$data['subPage'] = 'Paid Invoice';
	$data['title'] = 'Paid Invoice';
	$data['headerCss'] = 'headerCss/adminapprovelcss';
	$data['footerJs'] = 'footerJs/producttransfer';
	$data['mainContent'] = 'Branch/paidInvoice';
	$this->load->view("includes/mainContent", $data);
	}
}
 