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
										<label for="name"> EAN No </label>
										<input type="text" name="ean" value="<?php echo $this->input->get('ean');?>" class="form-control" placeholder="Enter ean no" />
									</div>
								</div>
								
								<div class="col-md-3 col-sm-3">
									<div class="form-group form-left">
										<label for="name"> From Date(insert date) </label>
										<input type="text" name="from_date" value="<?php echo $this->input->get('from_date');?>" class="form-control datepicker" placeholder="Select from date" readonly />
									</div>
								</div>

								<div class="col-md-3 col-sm-3">
									<div class="form-group form-left">
										<label for="name"> To Date(insert date) </label>
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
						<th>EAN</th>
						<th>Artical No</th>
						<th>Date</th>
						<th>Product Desc</th>
						<th>Rate</th>
						<th>Pre Stock</th>
						<th>Value</th>
						<th>Post Stock</th>
						<th>Value</th>
						<th>Variance Qty</th>
						<th>Variance Value</th>
						<th>Remarks</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php
                               
				if(isset($varianceReport) && !empty($varianceReport))
				{
					foreach ($varianceReport as $value)
					{
                                           
						$post_stock 	= $this->CommonModel->getPostStockByEanNo($value['ean'], TBL_PHYSICAL_SCAN_DETAILS_REGISTER);
						
						$postStock 		= $post_stock['net_scan_qty'];
						$postValue 		= ($postStock * $value['rate']);
						$varianceQty 	= ($value['qty'] - $postStock);
						$varianceValue 	= ($varianceQty * $value['rate']);
				?>
				<tr>
					<td><?php echo isset($value['ean'])?$value['ean']:'';?></td>
					<td><?php echo isset($value['artical_no'])?$value['artical_no']:'';?></td>
					<td><?php echo isset($value['created_on'])?date_format(date_create($value['created_on']),'d-m-Y'):'';?></td>
					<td><?php echo isset($value['product_desc'])?$value['product_desc']:'';?></td>
					<td><?php echo isset($value['rate'])?$value['rate']:'';?></td>
					<td><?php echo isset($value['qty'])?$value['qty']:'';?></td>
					<td><?php echo isset($value['value'])?$value['value']:'';?></td>
					<td><?php echo isset($value['ean'])?$postStock:'';?></td>
					<td><?php echo isset($value['rate'])?$postValue:'';?></td>
					<td><?php echo isset($value['rate'])?$varianceQty:'';?></td>
					<td><?php echo isset($value['rate'])?$varianceValue:'';?></td>
					<td><?php echo isset($post_stock['remarks'])?$post_stock['remarks']:'';?></td>
					<td>
						<a href="<?php echo base_url('reports/delete_variance_record/');?><?php echo isset($value['_id'])?$value['_id']:'';?>" class="delete" onclick="return confirm('This action can delete record permanently from database. Are you sure you want to proceed ?')" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i> </a>
					</td>
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