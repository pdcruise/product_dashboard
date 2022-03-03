<div class="col-10 offset-1 mt-4 p-4">
    <div class="col-md-12 mb-4">
        <h3>Edit Profile</h3>
        <span class="text-primary fw-bolder d-flex justify-content-center"><?= !empty($message) ? $message : "" ?></span>
    </div>
    <div class="row">
        <div class="col-4 offset-1 bg-light">
            <?= form_open('users/process_update_profile') ?>
                <fieldset class="row g-3 p-3"> 
                    <legend>Edit Information</legend>
                    <div class="form-floating">
                        <input type="text" id="email" class="form-control" name="email" placeholder="Email Address" value="<?= $profile['email'] ?>">
                        <label for="email">Email Address</label>
                        <span class="text-danger reset"><?= form_error('email') ?></span>
                    </div>
                    <div class="form-floating">
                        <input type="text" id="first_name" class="form-control" name="first_name" placeholder="First Name" value="<?= $profile['first_name'] ?>">
                        <label for="first_name">First Name </label>
                        <span class="text-danger reset"><?= form_error('first_name') ?></span>
                    </div>
                    <div class="form-floating">
                        <input type="text" id="last_name" class="form-control" name="last_name" placeholder="Last Name" value="<?= $profile['last_name'] ?>">
                        <label for="last_name">Last Name </label>
                        <span class="text-danger reset"><?= form_error('last_name') ?></span>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success float-end">Save</button>
                    </div>
                </fieldset>
            <?= form_close() ?>
        </div>
        <div class="col-4 offset-2 bg-secondary">
            <?= form_open('users/process_update_password') ?>
                <fieldset class="row g-3 p-3"> 
                    <legend>Change Password</legend>
                    <div class="form-floating">
                        <input type="password" id="old_password" class="form-control" name="old_password" placeholder="Old Password">
                        <label for="old_password">Old Password</label>
                        <span class="text-warning reset"><?= form_error('old_password') ?></span>
                    </div>
                    <div class="form-floating">
                        <input type="password" id="new_password" class="form-control" name="new_password" placeholder="New Password">
                        <label for="new_password">New Password</label>
                        <span class="text-warning reset"><?= form_error('new_password') ?></span>
                    </div>
                    <div class="form-floating">
                        <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="Confirm Password">
                        <label for="confirm_password">Confirm Password</label>
                        <span class="text-warning reset"><?= form_error('confirm_password') ?></span>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success float-end">Save</button>
                    </div>
                </fieldset>
            <?= form_close() ?>
        </div>
    </div>
</div>