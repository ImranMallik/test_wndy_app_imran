<?php
include("../db/db.php");
$sendData = json_decode($_POST['sendData'],true);
$user_mode_code = mysqli_real_escape_string($con,$sendData['user_mode_code']);
?>

<table style="width: 50%; margin:0 auto;" class="table">
    <thead>
        <tr>
            <th style="width: 115px;">
                <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-success" >
                    <input type="checkbox" name="Checkboxes16" id="main_checkbox" onchange="chng_main_checkbox()" />
                    <span style="margin-right: 6px;"></span> Select All
                </label>
            </th>
            <th>Menu Details</th>
        </tr>
    </thead>
    <tbody>
		<?php
		if ($session_user_mode_code=="Project Admin") {
			$menu_query = "select menu_master.menu_code, menu_master.menu_name, menu_master.menu_icon, menu_master.sub_menu_status, CASE WHEN (select count(*) from user_permission where user_permission.all_menu_code=menu_master.menu_code and user_mode_code='".$user_mode_code."' ) > 0 THEN 'true' ELSE 'false' END AS checkColumn from menu_master where menu_master.active='Yes' order by menu_master.order_num ";
		}
		else{
			$menu_query = "select menu_master.menu_code, menu_master.menu_name, menu_master.menu_icon, menu_master.sub_menu_status, CASE WHEN (select count(*) from user_permission where user_permission.all_menu_code=menu_master.menu_code and user_mode_code='".$user_mode_code."' ) > 0 THEN 'true' ELSE 'false' END AS checkColumn from menu_master RIGHT JOIN user_permission ON user_permission.all_menu_code=menu_master.menu_code where menu_master.active='Yes' and user_permission.user_mode_code='".$session_user_mode_code."' order by menu_master.order_num ";
		}
		$i = 1;
		$menu_dataget = mysqli_query($con,$menu_query);
		while($menu_rw = mysqli_fetch_assoc($menu_dataget)){
		?>
        <tr>
            <th scope="row">
				<input type="hidden" value="<?php echo $menu_rw['menu_code'] ?>" id="all_menu_code_<?php echo $i; ?>" />
                <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
                    <input type="checkbox" onchange="checkSelection(<?php echo $i; ?>)" id="menu_checkbox_<?php echo $i; ?>" <?php echo $menu_rw['checkColumn']=="true" ? "checked" : ""; ?> />
                    <span></span>
                </label>
            </th>
            <td>
				<i class="<?php echo $menu_rw['menu_icon'] ?> mr-2"></i>
				<?php echo $menu_rw['menu_name'] ?>
			</td>
        </tr>
			<?php
			if($menu_rw['sub_menu_status']=="Yes"){
				$i++;
				if ($session_user_mode_code=="Project Admin") {
					$sub_menu_query = "select sub_menu_master.sub_menu_code, sub_menu_master.sub_menu_name, sub_menu_master.menu_icon, CASE WHEN (select count(*) from user_permission where user_permission.all_menu_code=sub_menu_master.sub_menu_code and user_mode_code='".$user_mode_code."' ) > 0 THEN 'true' ELSE 'false' END AS checkColumn from sub_menu_master where sub_menu_master.menu_code='".$menu_rw['menu_code']."' and sub_menu_master.active='Yes' order by sub_menu_master.order_num ";
				}
				else{
					$sub_menu_query = "select sub_menu_master.sub_menu_code, sub_menu_master.sub_menu_name, sub_menu_master.menu_icon, CASE WHEN (select count(*) from user_permission where user_permission.all_menu_code=sub_menu_master.sub_menu_code and user_mode_code='".$user_mode_code."' ) > 0 THEN 'true' ELSE 'false' END AS checkColumn from sub_menu_master RIGHT JOIN user_permission ON user_permission.all_menu_code=sub_menu_master.sub_menu_code where sub_menu_master.menu_code='".$menu_rw['menu_code']."' and sub_menu_master.active='Yes' and user_permission.user_mode_code='".$session_user_mode_code."' order by sub_menu_master.order_num ";
				}
				$sub_menu_dataget = mysqli_query($con,$sub_menu_query);
				while($sub_menu_rw = mysqli_fetch_assoc($sub_menu_dataget)){
			?>
			<tr>
				<th scope="row">
					<input type="hidden" value="<?php echo $sub_menu_rw['sub_menu_code'] ?>" id="all_menu_code_<?php echo $i; ?>" />
					<label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
						<input type="checkbox" onchange="checkSelection(<?php echo $i; ?>)" id="menu_checkbox_<?php echo $i; ?>" <?php echo $sub_menu_rw['checkColumn']=="true" ? "checked" : ""; ?> />
						<span></span>
					</label>
				</th>
				<td style="padding-left: 50px;">
					<i class="<?php echo $sub_menu_rw['menu_icon'] ?> mr-2"></i>
					<?php echo $sub_menu_rw['sub_menu_name'] ?>
				</td>
			</tr>
			<?php
					$i++;
				}
			}
			else{
				$i++;
			}
			?>
		<?php
		}
		?>
    </tbody>
</table>

<input type="hidden" value="<?php echo $i; ?>" id="total_rw" />
