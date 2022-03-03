    <div class="col-4 offset-4">
        <div class="login-form bg-light mt-4 p-4">
            <?= form_open('login/validate', 'class="row g-3"') ?>
                <h4>Login</h4>
                <div class="form-group">
                    <label for="email">Email Address: </label>
                    <input type="text" id="email" class="form-control" name="email" placeholder="Email Address">
                    <span class="text-danger reset"><?= form_error('email') ?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password: </label>
                    <input type="password" id="password" class="form-control" name="password" placeholder="Password">
                    <span class="text-danger reset"><?= form_error('password') ?><?= !empty($message) ? $message : ""?></span>
                </div>
                <div>
                    <button type="submit" class="btn btn-dark float-end">Login</button>
                </div>
                <hr class="mt-4">
                <div>
                    <p class="text-center mb-0">Don't have an account yet? <a href="<?= base_url()?>register">Register</a></p>
                </div>
            <?= form_close() ?>
        </div>
    </div>
