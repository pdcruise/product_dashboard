    <div class="col-4 offset-4">
        <div class="login-form bg-light mt-4 p-4">
            <?= form_open('register/validate', 'class="row g-3"') ?>
                <h4>Register</h4>
                <div class="form-group">
                    <label for="email">Email address: </label>
                    <input type="text" id="email" class="form-control" name="email" placeholder="Email Address" value="<?= set_value('email'); ?>">
                    <span class="text-danger reset"><?= form_error('email') ?></span>
                </div>
                <div class="form-group">
                    <label for="first_name">First Name: </label>
                    <input type="text" id="first_name" class="form-control" name="first_name" placeholder="First Name" value="<?= set_value('first_name'); ?>">
                    <span class="text-danger reset"><?= form_error('first_name') ?></span>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name: </label>
                    <input type="text" id="last_name" class="form-control" name="last_name" placeholder="Last Name" value="<?= set_value('last_name'); ?>">
                    <span class="text-danger reset"><?= form_error('last_name') ?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password: </label>
                    <input type="password" id="password" class="form-control" name="password" placeholder="Password">
                    <span class="text-danger reset"><?= form_error('password') ?></span>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password: </label>
                    <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="Confirm Password">
                    <span class="text-danger reset"><?= form_error('confirm_password') ?></span>
                </div>
                <div>
                    <button type="submit" class="btn btn-dark float-end">Register</button>
                </div>
                <hr class="mt-4">
                <div>
                    <p class="text-center mb-0">Already have an account? <a href="<?=base_url()?>login">Login</a></p>
                </div>
            <?= form_close() ?>
        </div>
    </div>
