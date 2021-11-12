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
				<div class="col-md-12">
					<div class="table-responsive">
						<div class="search-result-table">
			
			<table class="table table-bordered table-striped table-datatable-export">
				<thead class="thead-inverse">
					<tr>
						<th style="width:20px;">SL</th>
						<th>Date</th>
						<th>Stock Take No</th>
						<th>Store Code</th>
						<th>Location</th>
						<th>Upload GC Count</th>
						<th>GC Count</th>
						<th>Valid Qty</th>
						<th>Invalid Qty</th>
						<th>WBC Qty</th>
						<th>Net Scan Qty</th>
						<th>Excess Qty</th>
						<th>Short Qty</th>
						<th>Accuracy</th>
						<th>Remarks</th>
						<th>User ID</th>
						<th>Scannerman Name</th>
						<th>GC Person Name</th>
					</tr>
				</thead>
				<tbody>
				<?php
                                
				if(isset($loctionWiseUserDetails) && !empty($loctionWiseUserDetails))
				{
					$i = 0;
					
					foreach ($loctionWiseUserDetails as $scanReport)
					{   
                                         $gc_count=$this->CommonModel->RetriveRecordBygroupcount(TBL_GC_USER_DETAILS_UPLOAD,'stock_take_no', $scanReport['stock_take_no']);
                                         $axcess_qty=isset($scanReport['axcess_qty'])?$scanReport['axcess_qty']:'0';
                                            $valid_qty=isset($scanReport['valid_qty'])?$scanReport['valid_qty']:'0';
                                            $invalid_qty=isset($scanReport['invalid_qty'])?$scanReport['invalid_qty']:'0';
                                            $wbc_qty=isset($scanReport['wbc_qty'])?$scanReport['wbc_qty']:'0';
                                            $net_scan_qty=$valid_qty+$invalid_qty+$wbc_qty;
						
						$i++;
				?>
					<tr>
						<td scope="row"><?php echo $i;?></td>
						<td><?php echo isset($scanReport['date'])?date_format(date_create($scanReport['date']),'d-m-Y'):'';?></td>
						<td><?php echo isset($scanReport['stock_take_no'])?$scanReport['stock_take_no']:'';?></td>
						<td><?php echo isset($scanReport['store_code'])?$scanReport['store_code']:'';?></td>
						<td><?php echo isset($scanReport['location'])?$scanReport['location']:'';?></td>
						<td><?php echo isset($scanReport['gc_qty'])?$scanReport['gc_qty']:'';?></td>
						<td><?php echo $gc_count['total']!=''?$gc_count['total']:'0' ?></td>
						<td><?php echo $valid_qty;?></td>
						<td><?php echo $invalid_qty;?></td>
						<td><?php echo $wbc_qty;?></td>
						<td><?php echo $net_scan_qty;?></td>
						<td><?php echo $net_scan_qty-($scanReport['gc_qty']+$gc_count['total']);?></td>
						<td><?= $scanReport['short_qty']?></td>
						<td><?php echo number_format((($scanReport['gc_qty']+$gc_count['total'])/$net_scan_qty)*100,2);?></td>
						<td><?php echo isset($scanReport['remarks'])?$scanReport['remarks']:'';?></td>
						<td><?php echo isset($scanReport['user_id'])?$scanReport['user_id']:'';?></td>
						<td><?php echo isset($scanReport['scanner_man_name'])?$scanReport['scanner_man_name']:'';?></td>
						<td><?php echo isset($scanReport['gc_person_name'])?$scanReport['gc_person_name']:'';?></td>
					</tr>
				<?php
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