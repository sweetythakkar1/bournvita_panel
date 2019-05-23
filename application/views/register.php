<?php
$company_log = get_logo();
$site_name = get_site_setting('site_name');
$favicon = get_fevicon();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" href="<?php echo $favicon; ?>">
        <title>Register</title>
        <!-- Font Icon -->
        <link rel="stylesheet" href="<?php echo base_url('assets/register/fonts/themify-icons/themify-icons.css'); ?>">
        <!-- Main css -->
        <link rel="stylesheet" href="<?php echo base_url('assets/register/css/style.css'); ?>">
    </head>
    <body>

        <div class="main">
            <div class="container">
                <div style="padding-top: 40px;text-align: center">
                    <a href="<?php echo base_url(); ?>">
                        <img src="<?php echo base_url('assets/img/login.png'); ?>" height="40" width="260" class="light-logo" />
                    </a>
                </div>

                <h2>SIGN UP NOW</h2>
                <?php
                $form_attr = array("class" => "signup-form", "id" => "signup-form", "name" => "signup-form", "method" => "post");
                echo form_open_multipart(site_url('auth/register_action'), $form_attr);
                ?>

                <h3>
                    <span class="icon"><i class="ti-user"></i></span>
                    <span class="title_text">Personal</span>
                </h3>
                <fieldset>
                    <legend>
                        <span class="step-heading">Personal Information: </span>
                        <span class="step-number">Step 1 / 4</span>
                    </legend>
                    <div class="form-group">
                        <label for="first_name" class="form-label required">First name</label>
                        <input type="text" name="first_name" value="<?php echo set_value('first_name'); ?>" id="first_name" maxlength="50"/>
                        <?php echo form_error('first_name'); ?>
                    </div>

                    <div class="form-group">
                        <label for="last_name" class="form-label required">Last name</label>
                        <input type="text" name="last_name" id="last_name" value="<?php echo set_value('last_name'); ?>" maxlength="50"/>
                        <?php echo form_error('last_name'); ?>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label required">Email</label>
                        <input type="email" name="email" id="email" maxlength="50" value="<?php echo set_value('email'); ?>"/>
                        <?php echo form_error('email'); ?>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label required">Email</label>
                        <input type="text" name="phone" id="phone" maxlength="50" value="<?php echo set_value('phone'); ?>"/>
                        <?php echo form_error('phone'); ?>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label required">Password</label>
                        <input type="password" name="password" id="password"  />
                        <?php echo form_error('password'); ?>
                    </div>
                </fieldset>

                <h3>
                    <span class="icon"><i class="ti-email"></i></span>
                    <span class="title_text">Billing</span>
                </h3>
                <fieldset>
                    <legend>
                        <span class="step-heading">Billing Information: </span>
                        <span class="step-number">Step 2 / 4</span>
                    </legend>
                    <div class="form-group">
                        <label for="billing_address" class="form-label required">Address</label>
                        <input type="text" name="billing_address" value="<?php echo set_value('billing_address'); ?>" id="billing_address" maxlength="250"  />
                        <?php echo form_error('billing_address'); ?>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label required">City</label>
                        <input type="text" name="city" id="city" value="<?php echo set_value('city'); ?>" maxlength="30"/>
                        <?php echo form_error('city'); ?>
                    </div>

                    <div class="form-group">
                        <label for="state" class="form-label required">State</label>
                        <input type="text" name="state" id="state" value="<?php echo set_value('state'); ?>"/>
                        <?php echo form_error('state'); ?>
                    </div>
                    <div class="form-group">
                        <label for="postal_code" class="form-label required">Postal Code</label>
                        <input type="text" name="postal_code" id="postal_code" <?php echo set_value('postal_code'); ?> maxlength="6" />
                        <?php echo form_error('postal_code'); ?>
                    </div>
                </fieldset>

                <h3>
                    <span class="icon"><i class="ti-credit-card"></i></span>
                    <span class="title_text">Payment</span>
                </h3>
                <fieldset>
                    <legend>
                        <span class="step-heading">Payment Information: </span>
                        <span class="step-number">Step 3 / 3</span>
                    </legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="card_number" class="form-label required">Card Number</label>
                            <input type="number" name="card_number" id="card_number" maxlength="20" value="<?php echo set_value('card_number'); ?>"/>
                            <?php echo form_error('card_number'); ?>
                        </div>
                        <div class="form-group">
                            <label for="cvc" class="form-label required">CVC</label>
                            <input type="text" name="cvc" id="cvc" maxlength="3" value="<?php echo set_value('cvc'); ?>"/>
                            <?php echo form_error('cvc'); ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-date">
                            <label for="expiry_date" class="form-label">Expiry Date</label>
                            <div class="form-date-group">
                                <div class="form-date-item">
                                    <select id="month" name="month">
                                        <option value="">Select Month</option>
                                        <option value="01">Jan</option>
                                        <option value="02">Feb</option>
                                        <option value="03">Mar</option>
                                        <option value="04">Apr</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">Aug</option>
                                        <option value="09">Sep</option>
                                        <option value="10">Oct</option>
                                        <option value="11">Nov</option>
                                        <option value="12">Dec</option>
                                    </select>
                                    <span class="select-icon"><i class="ti-angle-down"></i></span>
                                    <?php echo form_error('month'); ?>
                                </div>
                                <div class="form-date-item">
                                    <select id="year" name="year">
                                        <option value="">Select Year</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                    </select>
                                    <span class="select-icon"><i class="ti-angle-down"></i></span>
                                    <?php echo form_error('year'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-select">
                            <label for="payment_type" class="form-label">Card Type</label>
                            <div class="select-list">
                                <select name="payment_type" id="payment_type">
                                    <option value="">Card Type</option>
                                    <option value="Master Card">Master Card</option>
                                    <option value="visa">Visa Card</option>
                                </select>
                                <?php echo form_error('payment_type'); ?>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <?php echo form_close(); ?>
            </div>
        </div>
        <!-- JS -->
        <script src="<?php echo base_url('assets/register/vendor/jquery/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/register/vendor/jquery-validation/dist/jquery.validate.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/register/vendor/jquery-validation/dist/additional-methods.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/register/vendor/jquery-steps/jquery.steps.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/register/vendor/minimalist-picker/dobpicker.js'); ?>"></script>
        <script src="<?php echo base_url('assets/register/js/main.js'); ?>"></script>
    </body>
</html>