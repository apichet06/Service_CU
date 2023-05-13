<?php require_once '../db/config.php';

$m_id 	  = $_POST['m_id'];
$place_id = $_POST['place_id'];
$z_id = $_POST['z_id'];
?>

<div class="form-group col-md-6" >
	<label >สถานที่</label>
	<select name="place_id" id="place_id_v_up" class="form-control" style="width: 100%">
		<option value="">----- เลือกสถานที่ -----</option> 
		<?php $sql = mysqli_query($conn,"SELECT * FROM place a Where z_id = '$z_id' ");
		while($rs = mysqli_fetch_assoc($sql)){ ?>
			<option value="<?=$rs['place_id']?>" <?php if($rs['place_id']==$place_id){ echo "selected";}?>><?=$rs['place_name']?></option> 
		<?php } ?>
	</select>
</div>  

<div class="form-group col-md-6" >
	<label >รายชื่อช่างในเขตพื้นที่</label>
<?php $sql = mysqli_query($conn,"SELECT a.m_id,c.z_id,m_name,d.dv_name_short,p_name FROM member a 
			INNER JOIN area_zone b 
			on a.m_id = b.m_id 
			INNER JOIN zone c 
			on c.z_id = b.z_id  
			INNER JOIN division d 
			on d.dv_id = a.dv_id
			INNER JOIN position e 
			on e.p_id = a.p_id
			WHERE c.z_id = '$z_id'  and a.p_id != '3' "); ?>	
	<select name="m_id" id="m_idv_up" class ="form-control" style="width: 100%">
		<option value="">--- รายชื่อช่างในเขตพื้นที่ ---</option>
		<?php while ($rs = mysqli_fetch_assoc($sql)) { ?>
			<option value="<?=$rs['m_id']?>" <?php if($m_id==$rs['m_id']){ echo "selected"; } ?> > <?=$rs['m_name']?> </option>
		<?php } ?>
	</select>

	<script type="text/javascript">
		$(document).ready(function() { $('#place_id_v_up,#m_idv_up').select2(); });
	</script>
</div>

