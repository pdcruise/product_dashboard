<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    /*  Docu: This method is called by default by going to base URL
        Owner: Phil */
    public function index($message = null)
    {
        $current_user_id = $this->session->userdata('user_id');

        if (!$current_user_id)
        {
            $url['link'] = 'register';
            $data['message'] = $message;
            $this->load->view('partials/header', $url);
            $this->load->view('users/login', $data);
            $this->load->view('partials/footer');
        }
        else
        {
            redirect('dashboard');
        }
    }
    /* Docu: This method is called after clicking register link on login page
        Owner: Phil */
    public function register()
    {
        $current_user_id = $this->session->userdata('user_id');

        if (!$current_user_id)
        {
            $url['link'] = 'login';
            $this->load->view('partials/header', $url);
            $this->load->view('users/register');
            $this->load->view('partials/footer');
        }
        else
        {
            redirect('dashboard');
        }
    }
    /* Docu: This method is called after the register button was clicked. Validates the input fields. Checks if no other users are registered, if non assigns the registration as admin
        Upon successful validation, inserts the new user info. 
        Owner: Phil */
    public function process_registration()
    {
        $email = $this->input->post('email');

        $result = $this->user->validate_registration($email);

        if ($result != null)
        {
            $this->register();
        }
        else
        {
            $form_data = $this->input->post();
            $this->user->check_user() > 0 ? $form_data['user_level'] = 1 : $form_data['user_level'] = 9; 
            $this->user->create_user($form_data);

            $new_user = $this->user->get_user_by_email($form_data['email']);
            $this->session->set_userdata(array('user_id' => $new_user['id'], 'user_level' => $new_user['user_level']));

            redirect('dashboard');
        }
    }
    /* Docu: This method is called when user clicks the profile link. Gets the information of the current user based on user id then
        proceeds to a function that loads the view.
        Owner: Phil */
    public function edit($message = null)
    {
        $id = $this->session->userdata('user_id');
        $data = $this->user->get_user_by_id($id);
        $this->profile($data, $message);
    }
    /* Docu: This method is triggered when the log in button is clicked. This validates the input fields. Checks if email can be found on the
        database.
        Owner: Phil */
    public function process_login()
    {
        $result = $this->user->validate_login();
        if ($result != 'success' )
        {
            $this->index();
        }
        else
        {
            $email = $this->input->post('email');

            $user = $this->user->get_user_by_email($email);

            $result = $this->user->validate_password($user, $this->input->post('password'));
            if ($result == 'success')
            {
                $this->session->set_userdata(array('user_id' => $user['id'], 'user_level' => $user['user_level']));
                redirect('dashboard');
            }
            else
            {
                $this->index($result);
            }
        }
    }
    /* Docu: This method is called when the user clicks the log out button 
        Owner: Phil */
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('/');
    }
    /* Docu: This method is called when the user clicks the save button on profile page on information side. Validate the post data,
        check email if existing, updates information.
        Owner: Phil */
    public function process_update_profile()
    {
        $result = $this->user->validate_update();
        if ($result != 'success' )
        {
            $this->edit();
        }
        else
        {
            $email = $this->input->post('email');

            $user = $this->user->get_user_by_email($email);

            if ($user && $user['id'] != $this->session->userdata['user_id'])
            {
                $message = 'Email Already Taken.';
                $this->edit($message);
            }
            else
            {
                $form_input = $this->input->post();
                $this->user->update_info($form_input);
                $message = 'Successfully Updated';
                $this->edit($message);
            }
        }
    }
    /* Docu: This method is called whenever there is a need to load the profile page of the user. Proceeds to a page where users can
        update their information.
        Owner: Phil */
    public function profile($data, $message = null)
    {   
        $data['message'] = $message;
        $data['profile'] =  $data;
        $this->load->view('partials/header');
        $this->load->view('users/profile', $data);
        $this->load->view('partials/footer');
    }
    /* Docu: This method is called when the user clicks the save button on the profile page on password side. Validate the post data, 
        check old password if valid, updates password.
        Owner: Phil */
    public function process_update_password()
    {
        $result = $this->user->validate_update_pass();
        if ($result != 'success' )
        {
            $this->edit();
        }
        else
        {
            $id = $this->session->userdata('user_id');

            $user = $this->user->get_user_by_id($id);

            $result = $this->user->validate_password($user, $this->input->post('old_password'));
            if ($result == 'success')
            {
                $password = $this->input->post('new_password');
                $this->user->update_password($password);
                $message = "Password Successfully Changed";
                $this->edit($message);
            }
            else
            {
                $message = 'Invalid Password';
                $this->edit($message);
            }
        }
    }

}
