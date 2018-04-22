<!-- NOTE : some informations here will be changed dynamically when the popup calls this  -->
<div id="donate-modal" class="col-inside" style="display:none;min-height:200px;width:400px;background:#fff;border-radius: 2px;">
	 <h5 class="col-head">Details:</h5>
	 <form action="#" id="donate-form">
	 <div class="col-body">
			<div class="form-field-cont">
				<label>Amount :</label>
				<input type="text" name="amount" placeholder="e.g 20,000">
				<div class="clearfix"></div>
			</div>
			<div class="form-field-cont">
				<label>Project :</label>
	            <div class="fancy-select">
					<select id="donation-select" name="project">
						<option value="2">Social Media Literacy</option>
						<option value="1">Mosambique Cancer</option>
					</select>
			    </div>
				<div class="clearfix"></div>
			</div>
	 </div>
	 <div class="col-footer">
	 		<button type="reset" class="close-donate col-btn second-btn">Cancel</button>
			<button type="submit" id="nuser-submit-btn" class="col-btn prime-btn">Donate</button>
	 </div>
	</form>
</div>
					 	
					 