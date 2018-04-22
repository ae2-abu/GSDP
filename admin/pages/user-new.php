<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////         NEW USER REGISTRATION Page       //////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<div class="col-md-6">
	<div class="col-insdide">
		<form action="#" id="new-user-form">
			<div class="form-field-cont">
				<label>surname :</label>
				<input type="text" name="surname" placeholder="surname">
				<div class="clearfix"></div>
			</div>
			<div class="form-field-cont">
				<label>firstname :</label>
				<input type="text" name="firstname" placeholder="firstname">
				<div class="clearfix"></div>
			</div>
			<div class="form-field-cont">
				<label>username :</label>
				<input type="text" name="username" placeholder="username">
				<div class="clearfix"></div>
			</div>
			<div class="form-field-cont">
				<label>password :</label>
				<input type="text" name="password" value="<?php echo uniqid('PWD'); ?>" readonly="true">
				<div class="clearfix"></div>
			</div>
			<div class="form-field-cont">
				<label>Company :</label>
				<input type="text" placeholder="Transcorp Ughelli" disabled="disabled" >
				<input type="hidden" name="company" value="1" >
				<div class="clearfix"></div>
			</div>
			<div class="form-field-cont">
				<label>unit :</label>
				<select name="unit">
					<option value="2">dd</option>
					<option value="1">ddfef</option>
				</select>
				<div class="clearfix"></div>
			</div>
			<div class="form-field-cont">
				<label>phone :</label>
				<input type="text" name="phone" placeholder="phone">
				<div class="clearfix"></div>
			</div>
			<div class="form-field-cont">
				<label>email :</label>
				<input type="text" name="email" placeholder="email">
				<div class="clearfix"></div>
			</div>
			
			<button type="reset" style="width: 18%" >Reset</button>
			<button type="submit" style="width: 18%" id="nuser-submit-btn">Add</button>
		</form>
	</div>
</div>
<div class="col-md-6">
	<div class="col-inside">
		<input id="filer" type="file" name="newuser">
	</div>
</div>
					 	
					 