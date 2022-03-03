<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Model
{
    /* Docu: Method to cehck if there is already a user registered on the system.
        Owner: Phil*/
    public function check_user()
    {
        $query = "SELECT * FROM users";
        return $this->db->query($query)->num_rows();
    }
    /* Docu: Method to retrieve user information filtered by email.
        Owner: Phil*/
    public function get_user_by_email($email)
    {
        $query = "SELECT * FROM users WHERE email=?";
        return $this->db->query($query, $this->security->xss_clean($email))->row_array();
    }
    /* Docu: Method to retrieve user information filtered by id.
        Owner: Phil*/
    public function get_user_by_id($id)
    {
        $query = "SELECT * FROM users WHERE id=?";
        return $this->db->query($query, $this->security->xss_clean($id))->row_array();
    }
    /* Docu: Method to check required input fields and if unique email.
        Owner: Phil*/
    public function validate_registration($email)
    {
        $this->form_validation->set_rules('email', 'Email', 'valid_email|trim|required');
        $this->form_validation->set_rules('first_name', 'First Name', 'min_length[2]|trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'min_length[2]|trim|required');
        $this->form_validation->set_rules('password', 'Password', 'min_length[8]|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[password]|required');

        if (!$this->form_validation->run())
        {
            return validation_errors();
        }
        else if ($this->get_user_by_email($email)) 
        {
            return "Email already taken.";
        }
    }
    /* Docu: Method to insert new user info upon registration
        Owner: Phil*/
    public function create_user($data)
    {
        $query = "INSERT INTO users (first_name, last_name, email, password, user_level, created_at, updated_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
        $values = array(
            $this->security->xss_clean($data['first_name']),
            $this->security->xss_clean($data['last_name']),
            $this->security->xss_clean($data['email']),
            md5($this->security->xss_clean($data['password'])),
            $this->security->xss_clean($data['user_level']),
            $this->security->xss_clean(date('Y-m-d H:i:s')),
            $this->security->xss_clean(date('Y-m-d H:i:s'))
        );
        return $this->db->query($query, $values);
    }
    /* Docu: Method to validate input fields from the log in form. Checks if those fields were properly filled.
        Owner: Phil*/
    public function validate_login()
    {
        $this->form_validation->set_rules('email', 'Email', 'valid_email|trim|required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if (!$this->form_validation->run())
        {
            return validation_errors();
        }
        else
        {
            return "success";
        }
    }
    /* Docu: Method to check the entered password if it matches the one stored in the database
        Owner: Phil*/
    public function validate_password($user, $password)
    {
        $hash_password = md5($this->security->xss_clean($password));

        if ($user && $user['password'] == $hash_password)
        {
            return "success";
        }
        else
        {
            return "Invalid Email/Password";
        }
    }
    /* Docu: Method to validate the first_name, last_name, email fields of the edit information form
        Owner: Phil*/
    public function validate_update()
    {
        $this->form_validation->set_rules('email', 'Email', 'valid_email|trim|required');
        $this->form_validation->set_rules('first_name', 'First Name', 'min_length[2]|trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'min_length[2]|trim|required');
        
        if (!$this->form_validation->run())
        {
            return validation_errors();
        }
        else
        {
            return 'success';
        }
    }
    /* Docu: Method to validate the first_name, last_name, email fields of the edit information form
        Owner: Phil*/
    public function update_info($user)
    {
        $query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, updated_at = ? WHERE id = ?";
        $values = array(
            $this->security->xss_clean($user['first_name']),
            $this->security->xss_clean($user['last_name']),
            $this->security->xss_clean($user['email']),
            $this->security->xss_clean(date('Y-m-d H:i:s')),
            $this->security->xss_clean($this->session->userdata('user_id'))
        );
        return $this->db->query($query, $values);
    }
    /* Docu: Method to validate the password fields of the change password form
        Owner: Phil*/
    public function validate_update_pass()
    {
        $this->form_validation->set_rules('old_password', 'Old Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'min_length[8]|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[new_password]|required');
        
        if (!$this->form_validation->run())
        {
            return validation_errors();
        }
        else
        {
            return 'success';
        }
    }
    /* Docu: Method to validate the first_name, last_name, email fields of the edit information form
        Owner: Phil*/
    public function update_password($password)
    {
        $query = "UPDATE users SET password = ?, updated_at = ? WHERE id = ?";
        $values = array(
            md5($this->security->xss_clean($password)),
            $this->security->xss_clean(date('Y-m-d H:i:s')),
            $this->security->xss_clean($this->session->userdata('user_id'))
        );
        return $this->db->query($query, $values);
    }

}
