<div class="page-content">
   <div class="breadcrumb-section">
      <ul class="breadcrumb">
         <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard');?>"> <i class="fa fa-home" aria-hidden="true"></i> Dashboard</a></li>
         <li class="breadcrumb-item"><?php echo isset($meta_title)?$meta_title:'';?></li>
      </ul>
      <div class="clearfix"></div>
   </div>

	<div class="form_section">
		<div class="container-fluid">
			<div class="row">
				<div class="form-content">
					<div class="form-row category-form">
						<h2>Search</h2>
						<form action="" method="get">
							<?php
								$csrf = array(
									'name' => $this->security->get_csrf_token_name(),
									'hash' => $this->security->get_csrf_hash()
								);
							?>
						   <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>" />
						   
							<div class="form-content-inner">
								<div class="col-md-3 col-sm-3">
									<div class="form-group form-left">
										<label for="name"> Location No </label>
										<input type="text" name="location" value="<?php echo $this->input->get('location');?>" class="form-control" placeholder="Enter location no" />
									</div>
								</div>

								<div class="col-md-3 col-sm-3">
									<div class="form-group form-left">
										<label for="name"> Store Code </label>
										<input type="text" name="store_code" value="<?php echo $this->input->get('store_code');?>" class="form-control" placeholder="Enter store code" />
									</div>
								</div>

								<div class="col-md-3 col-sm-3">
									<div class="form-group form-left">
										<label for="name"> From Date </label>
										<input type="text" name="from_date" value="<?php echo $this->input->get('from_date');?>" class="form-control datepicker" placeholder="Select from date" readonly />
									</div>
								</div>

								<div class="col-md-3 col-sm-3">
									<div class="form-group form-left">
										<label for="name"> To Date </label>
										<input type="text" name="to_date" value="<?php echo $this->input->get('to_date');?>" class="form-control datepicker" placeholder="Select to date" readonly />
									</div>
								</div>
								
								<div class="col-md-3 col-sm-3">
									<div class="form-group form-left">
										<div style="float: right; padding-right: 38px; padding-top: 25px;">
											<input type="submit" class="btn btn-success" value="Search">
											<button type="button" onclick="clearAll();" class="btn btn-danger">Clear</button>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="search-result">
		<div class="container-fluid">
			<?php if ($this->session->flashdata('error')!='') { ?>
			<div class="alert alert-danger">
				<?php echo $this->session->flashdata('error'); ?>
			</div>
			<?php } ?>
			<?php if ($this->session->flashdata('success')!='') { ?>
			<div class="alert alert-success">
				<?php echo $this->session->flashdata('success'); ?>
			</div>
			<?php } ?>
			<div class="row">
                             <div class="col-md-10">
                                        <button style="float:right;" type="button" onclick="printall();" class="btn btn-default btn-sm">Print</button>
                                    </div>
				<div class="col-md-12">
                                   
					<div class="table-responsive">
						<div class="search-result-table">
							<table class="table table-bordered table-striped table-datatable-export">
								<thead class="thead-inverse">
									<tr>
										<th><input type="checkbox" id="checkall"></th>
										<th>SL N</th>
										<th>Date</th>
										<th>Store Code</th>
										<!--<th>SC Person</th>-->
										<th>Location</th>
										<!--<th>EAN</th>
										<th>Product Description</th>-->
										<th>Qty</th>
									</tr>
								</thead>
								<tbody>
								<?php
                                                                
								if(isset($locationWisePrintDetails) && !empty($locationWisePrintDetails))
								{
									$i = 1;									
									foreach($locationWisePrintDetails as $value)
									{										
										
										
										/* $locationNo = $value['_id'];
										$details = $this->mongo_db->where('location',$locationNo)->get(TBL_PHYSICAL_SCAN_DETAILS_REGISTER);
										$details = getRowData('location',$locationNo,TBL_PHYSICAL_SCAN_DETAILS_REGISTER); */
										
								?>
									<tr>
										<td><input type="checkbox" class="checkbox_singale" name="check[]" value="<?=$value['_id']['location']?>"></td>
										<td><?php echo $i;?></td>
										<td><?php echo isset($value['_id']['date'])?date('d-m-Y',strtotime($value['_id']['date'])):'';?></td>
										<td><?php echo isset($value['_id']['store_code'])?$value['_id']['store_code']:'';?></td>
										<!--<td><?php //echo isset($value['scanner_man_name'])?$value['scanner_man_name']:'';?></td>-->
										<td><a href="<?php echo base_url('reports/pdf_preview/'.$value['_id']['location']);?>"><?php echo isset($value['_id']['location'])?$value['_id']['location']:'';?></a></td>
										<!--<td><?php //echo isset($value['ean'])?$value['ean']:'';?></td>
										<td><?php //echo isset($value['product_desc'])?$value['product_desc']:'';?></td>-->
										<td><?php echo isset($value['total'])?$value['total']:'';?></td>
									</tr>
								<?php
                                                                $i++;
									}
								}else{
									?>
									<tr>
										<td colspan="16" align="center" valign="middle" class="blue-block">No Records Found</td>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('layouts/includeJS.php'); ?>
<form id="pdf" action="<?php echo base_url().'reports/pdf_preview'?>" method="post">
    <input type="hidden" name="pdf_value" id="pdf_value" value="">
    <input type="hidden" name="from_date" id="from_date_val" value="">
    <input type="hidden" name="to_date" id="to_date_val" value="">
     <?php
                    $csrf = array(
                        'name' => $this->security->get_csrf_token_name(),
                        'hash' => $this->security->get_csrf_hash()
                    );
                ?>
               <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>" />
</form>
<script>
    $("#checkall").click(function(){
       
        if($('#checkall').is(":checked")){
            $('.checkbox_singale').attr('checked',true);
        }else{
           $('.checkbox_singale').attr('checked',false);
        }
    });
    
</script> 
<script>
    function printall(){
var checkedVals = $('.checkbox_singale:checkbox:checked').map(function() {
    return this.value;
}).get();
var dat=checkedVals.join(",");
var from_date=$('#from_date').val();
var to_date=$('#to_date').val();
$('#pdf_value').val(dat);
$('#from_date_val').val(from_date);
$('#to_date_val').val(to_date);
//$('#pdf').attr('target','_blank');
$('#pdf').submit();

    }
 </script>