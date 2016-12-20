<!--Call Header File-->
<?php $this->load->view('template/header');?>
<!--End Header file-->
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Login In</h3>
                    </div>
                    <div class="panel-body">
                        <?php if(validation_errors()) echo '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>'; if(isset($errorMessage)) echo '<div class="alert alert-danger" role="alert">'.$errorMessage.'</div>';?>
                        <?php
                            $attributes = array('name' => 'form-login', 'id' => 'form-login', 'class' => 'form-login');
                            echo form_open("login/submitData", $attributes);
                        ?>
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" id="username" type="text" autofocus required />
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" id="password" type="password" required />
                                </div>
                                <div class="form-group">
                                    <?php
                                        $submitButton = array(
                                                    'name' => 'login',
                                                    'id' => 'login',
                                                    'value' => 'Log in',
                                                    'type' => 'submit',
                                                    'class' => 'btn btn-primary btn-lg btn-block'
                                                );

                                        echo form_submit($submitButton);
                                    ?>
                                </div>
                                <div class="form-group"><a href="#">Forget Password?</a></div>
                            </fieldset>
                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--Call Footer file-->
<?php $this->load->view('template/footer');?>
<!--End Footer file-->