<div class="col-10 offset-1 mt-4 p-4">
    <div class="col-md-12 d-flex mb-4">
        <h3>Manage Products</h3>
<?php   if($this->session->userdata('user_level') == 9)
        {
?>      <a href="<?=base_url().'new'?>" class="ms-auto"><button type="button" class="btn btn-primary">Add New</button></a>
<?php   }
?>
    </div>
    <table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Inventory Count</th>
        <th scope="col">Quantity Sold</th>
        <?= $this->session->userdata('user_level') == 9 ? '<th scope="col">Action</th>' : '' ?>
        </tr>
    </thead>
    <tbody>
<?php   if (!empty($products))
        {
            foreach ($products as $item)
            {
?>          <tr>
            <th scope="row"><?= $item['id'] ?></th>
            <td><a href="<?= base_url().'products/show/'.$item['id'] ?>"><?= $item['name'] ?></a></td>
            <td><?= $item['inventory_count'] ?></td>
            <td><?= $item['sold'] ?></td>
<?php           if($this->session->userdata('user_level') == 9)
                {
?>          <td><a href="<?=base_url()."products/edit/".$item['id'].""?>">Edit</a> <a data-bs-toggle="modal" data-bs-target="#confirm_action" href="">Remove</a></td>
<?php           }
?>
            </tr>   
<?php       }
       }
        else
        {
?>         <tr><td><?= "No data available"?></td></tr>
<?php   }
?>
    </tbody>
    </table>
</div>
<!-- Modal -->
<div class="modal fade" id="confirm_action" tabindex="-1" aria-labelledby="confirm_action" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirm_action">Are you sure?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Remove <span class="reset text-danger"><?= $item['name'] ?></span>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="<?= base_url().'products/delete/'.$item['id'] ?>"><button type="button" class="btn btn-danger">Yes</button></a>
      </div>
    </div>
  </div>
</div>
