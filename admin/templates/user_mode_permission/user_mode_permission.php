<!--begin::Card-->
<div class="card card-custom example example-compact">
    <div style="min-height: 50px;;" class="card-header">
        <h3 class="card-title">Manage Role Permission</h3>
        <div class="card-toolbar">
            <div class="example-tools justify-content-center">

            </div>
        </div>
    </div>
    <!--begin::Form-->
    <form class="form">
        <div class="card-body">
            <div class="input_part">

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">
                                User Role
                                <!-- Required hover content -->
                                <span class="req-label-btn" data-container="body" data-toggle="tooltip" data-placement="top" title="This field is required"> * </span>
                                <!-- Info hover content -->
                                <button type="button" class="info-label-btn btn btn-secondary" data-container="body" data-toggle="tooltip" data-placement="top" title="Please select user role then you can give page permission">
                                    <i class="fas fa-info"></i>
                                </button>
                            </label>
                            <select id="user_mode_code" onchange="show_menu_list()" class="form-control select2" data-placeholder="Choose User Role" required>
                                <option value=""></option>
                                <?php
                                $user_mode_dataget = mysqli_query($con, "select user_mode_code,user_mode from user_mode where active='Yes' ");
                                while ($rw = mysqli_fetch_assoc($user_mode_dataget)) {
                                ?>
                                    <option value="<?php echo $rw['user_mode_code'] ?>"><?php echo $rw['user_mode'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="menu_list_div" style="width: 100%;"></div>

            </div>
        </div>
        <div style="padding: 8px 2.25rem;" class="card-footer">
            <div class="row">
                <div class="col-lg-5"></div>
                <div class="col-lg-7">
                    <button type="button" onclick="clear_input()" class="btn btn-light-dark font-weight-bold">Clear</button>
                    <button type="button" onclick="save_details()" class="btn btn-primary font-weight-bold">Save Data</button>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
</div>
<!--end::Card-->